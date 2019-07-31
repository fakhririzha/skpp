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
    return $this->db->where("kode_kelas", $kelas)->get("vSiswaKelas")->result();
  }
  public function getSiswaBySttb($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vSiswaKelas")->row();
  }
  public function getNominalBayar($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vSiswaKelas")->row();
  }
  public function getAllKodeTransaksi()
  {
    return $this->db->like('kode', 'B')->get("kode_transaksi")->result();
  }
  public function getAllTransaksi()
  {
    return $this->db->get("vHistoriTransaksi")->result();
  }
  public function getTransaksiBulananBySttb($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("vHistoriTransaksiBulanan")->result();
  }
  public function getIDTransaksiBulananTerakhir()
  {
    return $this->db->query("SELECT id FROM bulanan ORDER BY id DESC LIMIT 1")->row();
  }
  public function getIDTransaksiTahunanTerakhir()
  {
    return $this->db->query("SELECT id FROM tahunan ORDER BY id DESC LIMIT 1")->row();
  }
  public function getIDTransaksiTerakhir()
  {
    return $this->db->query("SELECT id FROM transaksi ORDER BY id DESC LIMIT 1")->row();
  }

  // INSERT METHOD
  public function addBayarBulanan($data)
  {
    $checkPaid = $this->db->where("sttb", $data["sttb"])
      ->where("tahun_akademik", $data["tahun_akademik"])
      ->where("semester", $data["semester"])
      ->where("bulan_bayar", $data["bulanBayar"])
      ->get("bulanan")->num_rows();

    if ($checkPaid > 0) {
      return false;
    } else {
      $no_ref = ((int) $this->getIDTransaksiBulananTerakhir() + 1);
      $no_ref = 'BLN' . $no_ref;
      $addBayarBulanan = $this->db->insert("bulanan", [
        "sttb" => $data["sttb"],
        "no_ref" => $no_ref,
        "tahun_akademik" => $data["tahunAkademik"],
        "semester" => $data["semester"],
        "tanggal" => $data["tanggal"],
        "nominal" => $data["nominal"],
        "bulan_bayar" => $data["bulanBayar"],
        " id_petugas" => $data["idPetugas"]
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
      $no_ref = ((int) $this->getIDTransaksiTahunanTerakhir() + 1);
      $no_ref = 'THN' . $no_ref;
      $addBayarTahunan = $this->db->insert("tahunan", [
        "sttb" => $data["sttb"],
        "no_ref" => $no_ref,
        "tahun_akademik" => $data["tahunAkademik"],
        "tanggal" => $data["tanggal"],
        "nominal" => $data["nominal"],
        "id_petugas" => $data["idPetugas"]
      ]);

      return $addBayarTahunan;
    }
  }
  public function addPemasukanLainnya($data)
  {
    if ($data["kodeTransaksi"] == "4A") {
      $data["tanggalTransaksi"] = "1970-01-01";
    }
    $no_ref = ((int) $this->getIDTransaksiTerakhir() + 1);
    $no_ref = 'LN' . $no_ref;
    $addPemasukanLainnya = $this->db->insert("transaksi", [
      "no_ref" => $no_ref,
      "kode" => $data["kodeTransaksi"],
      "keterangan" => $data["keterangan"],
      "tanggal" => $data["tanggalTransaksi"],
      "nominal" => $data["nominalTransaksi"],
      "status" => $data["status"],
      "id_petugas" => $data["idPetugas"]
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

    return $addPengeluaran;
  }

  // DELETE METHOD
  public function hapusTransaksiBulananBySttbId($sttb, $no_ref)
  {
    $this->db->where("sttb", $sttb)->where("no_ref", $no_ref)->delete("bulanan");
    $count = $this->db->affected_rows();

    return $count;
  }
}
