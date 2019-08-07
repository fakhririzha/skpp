<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminModel extends CI_Model
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

  public function getAllUser()
  {
    return $this->db->get("user")->result();
  }
  public function getUserByUsername($u)
  {
    return $this->db->where("username", $u)->get("user")->row();
  }
  public function getAllSiswa()
  {
    return $this->db->get("siswa")->result();
  }
  public function getAllKelas()
  {
    return $this->db->get("kelas")->result();
  }
  public function getSiswaByKelas($kelas)
  {
    return $this->db->where("kode_kelas", $kelas)->get("siswa")->result();
  }
  public function getSiswaBySTTB($sttb)
  {
    return $this->db->where("sttb", $sttb)->get("siswa")->row();
  }
  public function getSemesterTahunAkademikAktif()
  {
    return $this->db->query("SELECT semester, tahun_akademik FROM kelas LIMIT 1")->row();
  }
  public function getKelasByKodeKelas($kode_kelas)
  {
    return $this->db->where("kode_kelas", $kode_kelas)->get("kelas")->row();
  }
  public function getAllSiswaBelumAdaKelas()
  {
    return $this->db->where("kode_kelas", "")->get("siswa")->result();
  }

  // INSERT METHOD
  public function addUser($data)
  {
    $checkUser = $this->db->where("username", $data["username"])->get("user");
    if ($checkUser->num_rows() > 0) {
      return false;
    } else {

      $addUser = $this->db->insert("user", [
        "username" => $data["username"],
        "nama" => $data["nama"],
        "jabatan" => $data["jabatan"],
        "last_login" => date("Y-m-d H:i:s", time()),
        "status" => "inactive",
        "password" => password_hash($data["password"], PASSWORD_BCRYPT)
      ]);

      return $addUser;
    }
  }
  public function addSiswaImport($data)
  {
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {
      if ($this->db->where("sttb", $data[$i]["sttb"])->get("siswa")->num_rows() < 1) {
        $insert = $this->db->insert("siswa", [
          "sttb" => $data[$i]["sttb"],
          "nama" => $data[$i]["nama"],
          "kode_kelas" => "",
          "jenis_kelamin" => $data[$i]["jenis_kelamin"],
          "status" => $data[$i]["status"]
        ]);
        array_push($data[$i], ["sukses" => "Sukses"]);
      } else {
        array_push($data[$i], ["sukses" => "Gagal (data duplikat)"]);
      }
    }
    return [true, $data];
  }
  public function addSiswa($data)
  {
    $checkSiswa = $this->db->where("sttb", $data["sttb"])->get("siswa");
    if ($checkSiswa->num_rows() > 0) {
      return false;
    } else {

      $addSiswa = $this->db->insert("siswa", [
        "sttb" => $data["sttb"],
        "nama" => $data["nama"],
        "kode_kelas" => $data["kodeKelas"],
        "jenis_kelamin" => $data["jenisKelamin"],
        "status" => $data["status"]
      ]);

      return $addSiswa;
    }
  }
  public function addKelas($data)
  {
    $checkKelas = $this->db->where("kode_kelas", $data["kodeKelas"])->get("kelas");
    if ($checkKelas->num_rows() > 0) {
      return false;
    } else {

      $addKelas = $this->db->insert("kelas", [
        "kode_kelas" => $data["kodeKelas"],
        "semester" => $this->getSemesterTahunAkademikAktif()->semester,
        "tahun_akademik" => $this->getSemesterTahunAkademikAktif()->tahun_akademik,
        "iuran_bulanan" => $data["iuranBulanan"],
        "iuran_bulanan_subsidi" => $data["iuranBulananSubsidi"],
        "iuran_tahunan" => $data["iuranTahunan"]
      ]);

      return $addKelas;
    }
  }

  // UPDATE METHOD
  public function editUser($data)
  {
    $count = 0;
    if ($data["username"] != $data["oldUsername"]) {
      $checkUser = $this->db->where("username", $data["username"])->get("user");
      $count = $checkUser->num_rows();
    } else {
      $count = 0;
    }
    if ($count > 0) {
      return false;
    } else {

      $updateUser = $this->db->where("username", $data["username"])->update("user", [
        "username" => $data["username"],
        "nama" => $data["nama"],
        "jabatan" => $data["jabatan"]
      ]);

      return $updateUser;
    }
  }
  public function editSiswa($data)
  {
    $count = 0;
    if ($data["sttb"] != $data["oldSttb"]) {
      $checkSiswa = $this->db->where("sttb", $data["sttb"])->get("siswa");
      $count = $checkSiswa->num_rows();
    } else {
      $count = 0;
    }
    if ($count > 0) {
      return false;
    } else {

      $updateSiswa = $this->db->where("sttb", $data["sttb"])->update("siswa", [
        "sttb" => $data["sttb"],
        "nama" => $data["nama"],
        "kode_kelas" => $data["kodeKelas"],
        "jenis_kelamin" => $data["jenisKelamin"],
        "status" => $data["status"]
      ]);

      return $updateSiswa;
    }
  }
  public function editKelas($data)
  {
    $checkKelas = $this->db->where("kode_kelas", $data["kodeKelas"])->get("kelas");

    if ($checkKelas->num_rows() > 0) {
      $updateKelas = $this->db->where("kode_kelas", $data["kodeKelas"])->update("kelas", [
        "iuran_bulanan" => $data["iuranBulanan"],
        "iuran_bulanan_subsidi" => $data["iuranBulananSubsidi"],
        "iuran_tahunan" => $data["iuranTahunan"]
      ]);

      return $updateKelas;
    } else {
      return false;
    }
  }
  public function updateKelasSiswaBulk($listToAdd, $kelas)
  {
    foreach ($listToAdd as $sttb) {
      if ($this->db->where("sttb", $sttb)->where("kode_kelas", $kelas)->get("pembagian_kelas")->num_rows() < 1) {
        $this->db->insert("pembagian_kelas", [
          "sttb" => $sttb,
          "kode_kelas" => $kelas,
          "tahun_akademik" => $this->getSemesterTahunAkademikAktif()->tahun_akademik,
          "status" => "aktif"
        ]);
        $this->db->where("sttb", $sttb)->update("siswa", [
          "kode_kelas" => $kelas
        ]);
      }
    }
  }

  // DELETE METHOD
  public function hapusUser($username)
  {
    $this->db->where("username", $username)->delete("user");
    $count = $this->db->affected_rows();

    return $count;
  }
  public function hapusSiswa($sttb)
  {
    $this->db->where("sttb", $sttb)->delete("siswa");
    $count = $this->db->affected_rows();

    return $count;
  }
  public function hapusKelas($kode_kelas)
  {
    $this->db->where("kode_kelas", $kode_kelas)->delete("kelas");
    $count = $this->db->affected_rows();

    return $count;
  }
}
