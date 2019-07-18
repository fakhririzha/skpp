<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminModel extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }

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
}
