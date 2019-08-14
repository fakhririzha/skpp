<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BendaharaModel extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }

  // GET METHOD
  public function getJumlahAkun()
  {
    return $this->db->query("SELECT jumlahAkun() AS jumlahAkun")->row();
  }
  public function getJumlahSiswa()
  {
    return $this->db->query("SELECT jumlahSiswa() AS jumlahSiswa")->row();
  }
  public function getJumlahSiswi()
  {
    return $this->db->query("SELECT jumlahSiswi() AS jumlahSiswi")->row();
  }
  public function getAllKelas()
  {
    return $this->db->get("kelas")->result();
  }
  public function getSiswaByKelas($kelas)
  {
    return $this->db->where("kode_kelas", $kelas)->get("vsiswakelas")->result();
  }
  public function getSiswaBySttb($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vsiswakelas")->row();
  }
  public function getNominalBayar($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vsiswakelas")->row();
  }
  public function getAllKodeTransaksi()
  {
    return $this->db->like('kode', 'B')->get("kode_transaksi")->result();
  }
  public function getAllTransaksi()
  {
    return $this->db->get("vhistoritransaksi")->result();
  }
  public function getTransaksiBulananBySttb($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vhistoritransaksibulanan")->result();
  }
  public function getTransaksiTahunanBySttb($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vhistoritransaksitahunan")->result();
  }
  public function getPemasukan($tanggal)
  {
    return $this->db->query("SELECT hitungPenerimaan('1970-01-01', '$tanggal') AS pemasukan")->row();
  }
  public function getPengeluaran($tanggal)
  {
    return $this->db->query("SELECT hitungPengeluaran('1970-01-01', '$tanggal') AS pengeluaran")->row();
  }
  public function getPemasukanLainnya($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT hitungPemasukanLainnya('$tanggalAsli', '$sebulan') AS pemasukanLainnya")->row();
  }
  public function getLaporanSPP($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT * FROM vlaporanspp WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->result();
  }
  public function getLaporanKeuangan($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT * FROM vlaporankeuangan WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->result();
  }
  public function getLaporanPengeluaran($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT * FROM vlaporanpengeluaran WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->result();
  }
  public function getLaporanDetailPenerimaan($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT * FROM vlaporandetailpenerimaan WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->result();
  }
  public function getLaporanPengeluaranDetail($tanggal)
  {
    return $this->db->query("SELECT * FROM transaksi WHERE kode LIKE '%B' AND tanggal = '$tanggal'")->result();
  }
  public function getPemasukanLainnyaDetail($tanggal)
  {
    return $this->db->query("SELECT * FROM transaksi WHERE kode LIKE '3A' AND tanggal = '$tanggal'")->result();
  }
  public function getPenerimaanSPPDetail($tanggal)
  {
    return $this->db->query("SELECT * FROM vlaporandetailpenerimaan WHERE tanggal = '$tanggal'")->result();
  }
  public function getPenerimaanPutra($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT SUM(penerimaanPutra) AS putra FROM vpenerimaanputra WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->row();
  }
  public function getPenerimaanPutri($tanggalAsli, $sebulan)
  {
    return $this->db->query("SELECT SUM(penerimaanPutri) AS putri FROM vpenerimaanputri WHERE tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->row();
  }
  public function getPengeluaranByKode($tanggalAsli, $sebulan, $kode)
  {
    return $this->db->query("SELECT SUM(nominal) AS jumlah FROM transaksi WHERE kode = '$kode' AND tanggal BETWEEN '$tanggalAsli' AND '$sebulan'")->row();
  }

  // INSERT METHOD
  public function addBayarBulanan($data)
  {
    $checkPaid = $this->db->where("sttb", $data["sttb"])
      ->where("tahun_akademik", $data["tahunAkademik"])
      ->where("semester", $data["semester"])
      ->where("bulan_bayar", $data["bulanBayar"])
      ->get("bulanan")->num_rows();

    if ($checkPaid > 0) {
      return false;
    } else {
      $addBayarBulanan = $this->db->insert("bulanan", [
        "sttb" => $data["sttb"],
        "tahun_akademik" => $data["tahunAkademik"],
        "semester" => $data["semester"],
        "tanggal" => $data["tanggal"],
        "nominal" => $data["nominal"],
        "bulan_bayar" => $data["bulanBayar"],
        "id_petugas" => $data["idPetugas"]
      ]);
      $last = $this->db->insert_id();
      $noref = $this->db->where("id", $last)->update("bulanan", [
        "no_ref" => 'BLN' . $last
      ]);

      return $addBayarBulanan;
    }
  }
  public function addBayarTahunan($data)
  {
    $billPaid = $this->db->query("SELECT SUM(nominal) AS jumlahTerbayar FROM tahunan WHERE sttb=" . $data['sttb'] . " AND tahun_akademik=" . $data['tahunAkademik'] . "")->row();
    $totalTagihan = $this->getNominalBayar($data['sttb'])->iuran_tahunan;

    if ($billPaid->jumlahTerbayar == NULL) {
      $billPaid = 0;
    }

    if ($totalTagihan < ($billPaid + $data['nominal'])) {
      return false;
    } else {
      $addBayarTahunan = $this->db->insert("tahunan", [
        "sttb" => $data["sttb"],
        "tahun_akademik" => $data["tahunAkademik"],
        "tanggal" => $data["tanggal"],
        "nominal" => $data["nominal"],
        "id_petugas" => $data["idPetugas"]
      ]);
      $last = $this->db->insert_id();
      $noref = $this->db->where("id", $last)->update("tahunan", [
        "no_ref" => 'THN' . $last
      ]);

      return $addBayarTahunan;
    }
  }
  public function addPemasukanLainnya($data)
  {
    if ($data["kodeTransaksi"] == "4A") {
      $data["tanggalTransaksi"] = "1970-01-01";
    }

    $addPemasukanLainnya = $this->db->insert("transaksi", [
      "kode" => $data["kodeTransaksi"],
      "keterangan" => $data["keterangan"],
      "tanggal" => $data["tanggalTransaksi"],
      "nominal" => $data["nominalTransaksi"],
      "status" => $data["status"],
      "id_petugas" => $data["idPetugas"]
    ]);

    $last = $this->db->insert_id();
    $noref = $this->db->where("id", $last)->update("transaksi", [
      "no_ref" => 'LN' . $last
    ]);

    return $addPemasukanLainnya;
  }
  public function addPengeluaran($data)
  {
    $addPengeluaran = $this->db->insert("transaksi", [
      "kode" => $data["kodeTransaksi"],
      "keterangan" => $data["keterangan"],
      "tanggal" => $data["tanggalTransaksi"],
      "nominal" => $data["nominalTransaksi"],
      "status" => $data["status"],
      "id_petugas" => $data["idPetugas"]
    ]);

    $last = $this->db->insert_id();
    $noref = $this->db->where("id", $last)->update("transaksi", [
      "no_ref" => 'OUT' . $last
    ]);

    return $addPengeluaran;
  }

  // DELETE METHOD
  public function hapusTransaksiBulananBySttbId($sttb, $no_ref)
  {
    $this->db->where("sttb", $sttb)->where("no_ref", $no_ref)->delete("bulanan");
    $count = $this->db->affected_rows();
    $this->db->where("no_ref", $no_ref)->delete("transaksi");

    return $count;
  }
  public function hapusTransaksiTahunanBySttbId($sttb, $no_ref)
  {
    $this->db->where("sttb", $sttb)->where("no_ref", $no_ref)->delete("tahunan");
    $count = $this->db->affected_rows();
    $this->db->where("no_ref", $no_ref)->delete("transaksi");

    return $count;
  }
}
