<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bendahara extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("BendaharaModel");
    if ($this->session->jabatan == "admin") {
      redirect("admin");
    } elseif ($this->session->jabatan != "bendahara") {
      redirect("");
    }
  }

  public function index()
  {
    $data = [
      "content" => 'bendahara/pages/main',
      "jumlahAkun" => $this->BendaharaModel->getJumlahAkun(),
      "jumlahSiswa" => $this->BendaharaModel->getJumlahSiswa(),
      "jumlahSiswi" => $this->BendaharaModel->getJumlahSiswi(),
      "headingPanel" => true
    ];
    $this->load->view('bendahara/index', $data);
  }
}
