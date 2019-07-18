<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("AdminModel");
    if ($this->session->jabatan == "bendahara") {
      redirect("bendahara");
    } elseif ($this->session->jabatan != "admin") {
      redirect("");
    }
  }
  public function index()
  {
    $data = [
      "content" => 'admin/pages/main',
      "jumlahAkun" => $this->AdminModel->getJumlahAkun(),
      "jumlahSiswa" => $this->AdminModel->getJumlahSiswa(),
      "jumlahSiswi" => $this->AdminModel->getJumlahSiswi(),
      "headingPanel" => true
    ];
    $this->load->view('admin/index', $data);
  }

  public function user()
  {
    $data = [
      "akuns" => $this->AdminModel->getAllUser(),
      "content" => "admin/pages/user",
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];

    $this->load->view('admin/index', $data);
  }

  public function addUser()
  {
    if ($this->input->post('addUser')) {
      $data = [
        'username' => $this->input->post('username'),
        'password' => $this->input->post('password'),
        'nama' => $this->input->post('nama'),
        'jabatan' => $this->input->post('jabatan')
      ];
      if ($this->AdminModel->addUser($data)) {
        $this->session->set_flashdata('suksesMsg', 'Sukses menambahkan user : ' . $data["username"] . '.');
      } else if (!$this->AdminModel->addUser($data)) {
        $this->session->set_flashdata('actionMsg', 'Username "' . $data["username"] . '" telah ada. Silahkan coba username lain.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambahkan user.');
      }
      redirect("admin/user");
    }
  }

  public function editUser()
  {
    $username = $this->input->get("username");
  }

  public function deleteUser()
  {
    $username = $this->input->get("username");
  }
}
