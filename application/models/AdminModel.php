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
}
