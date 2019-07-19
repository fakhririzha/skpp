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

  // INSERT METHOD
  public function addBayarBulanan($data)
  {
    $addBayarBulanan = $this->db->insert("bulanan", [
      "sttb" => $data["sttb"],
      "tahun_akademik" => $data["tahunAkademik"],
      "semester" => $data["semester"],
      "tanggal" => $data["tanggal"],
      "nominal" => $data["nominal"],
      "bulan_bayar" => $data["bulanBayar"],
      " id_petugas" => $data["idPetugas"]
    ]);

    return $addBayarBulanan;
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
}
