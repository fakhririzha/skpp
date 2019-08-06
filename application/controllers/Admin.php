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
    if ($this->input->post("editUser")) {
      $data = [
        'username' => $this->input->post('username'),
        'oldUsername' => $this->input->post('oldUsername'),
        'password' => $this->input->post('password'),
        'nama' => $this->input->post('nama'),
        'jabatan' => $this->input->post('jabatan')
      ];
      if ($this->AdminModel->editUser($data)) {
        $this->session->set_flashdata('suksesMsg', 'Sukses mengubah informasi user : ' . $data["username"] . '.');
      } else if (!$this->AdminModel->editUser($data)) {
        $this->session->set_flashdata('actionMsg', 'Username "' . $data["username"] . '" telah ada. Silahkan coba username lain.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal mengubah informasi user.');
      }
      redirect("admin/user");
    } else {
      $username = $this->input->get("username");

      $data = [
        "user" => $this->AdminModel->getUserByUsername($username),
        "content" => "admin/pages/editUser"
      ];

      $this->load->view('admin/index', $data);
    }
  }

  public function hapusUser()
  {
    $username = $this->input->get("username");
    if ($this->AdminModel->hapusUser($username) > 0) {
      $this->session->set_flashdata('suksesMsg', 'Sukses menghapus user : ' . $username . '.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus user.');
    }
    redirect("admin/user");
  }

  public function siswa()
  {
    if ($this->input->post("filterKelas")) {
      $kelas = $this->input->post("kelas");

      $data = [
        "kelass" => $this->AdminModel->getAllKelas(),
        "content" => "admin/pages/siswa",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"],
        "siswas" => $this->AdminModel->getSiswaByKelas($kelas)
      ];
    } else {
      $data = [
        "kelass" => $this->AdminModel->getAllKelas(),
        "content" => "admin/pages/siswa",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"]
      ];
    }

    $this->load->view('admin/index', $data);
  }

  public function addSiswa()
  {
    if ($this->input->post('addSiswa')) {
      $data = [
        'sttb' => $this->input->post('sttb'),
        'nama' => $this->input->post('nama'),
        'kodeKelas' => $this->input->post('kodeKelas'),
        'jenisKelamin' => $this->input->post('jenisKelamin'),
        'status' => $this->input->post('status')
      ];
      if ($this->AdminModel->addSiswa($data)) {
        $this->session->set_flashdata('suksesMsg', 'Sukses menambahkan siswa : ' . $data["nama"] . ' kelas ' . $data["kodeKelas"] . '.');
      } else if (!$this->AdminModel->addSiswa($data)) {
        $this->session->set_flashdata('actionMsg', 'No. STTB "' . $data["sttb"] . '" telah ada. Silahkan coba username lain.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambahkan siswa.');
      }
      redirect("admin/siswa");
    }
  }

  public function editSiswa()
  {
    if ($this->input->post("editSiswa")) {
      $data = [
        'sttb' => $this->input->post('sttb'),
        'oldSttb' => $this->input->post('oldSttb'),
        'nama' => $this->input->post('nama'),
        'kelas' => $this->input->post('kelas'),
        'jenisKelamin' => $this->input->post('jenisKelamin'),
        'status' => $this->input->post('status')
      ];
      if ($this->AdminModel->editSiswa($data)) {
        $this->session->set_flashdata('suksesMsg', 'Sukses mengubah informasi siswa : No. STTB' . $data["sttb"] . '.');
      } else if (!$this->AdminModel->editSiswa($data)) {
        $this->session->set_flashdata('actionMsg', 'No. STTB "' . $data["sttb"] . '" telah ada. Silahkan coba No. STTB lain.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal mengubah informasi siswa.');
      }
      redirect("admin/siswa");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "siswa" => $this->AdminModel->getSiswaBySTTB($sttb),
        "kelass" => $this->AdminModel->getAllKelas(),
        "content" => "admin/pages/editSiswa"
      ];

      $this->load->view('admin/index', $data);
    }
  }

  public function hapusSiswa()
  {
    $sttb = $this->input->get("sttb");
    if ($this->AdminModel->hapusSiswa($sttb) > 0) {
      $this->session->set_flashdata('suksesMsg', 'Sukses menghapus siswa : No. STTB ' . $sttb . '.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus siswa.');
    }
    redirect("admin/siswa");
  }

  public function kelas()
  {
    $data = [
      "kelass" => $this->AdminModel->getAllKelas(),
      "content" => "admin/pages/kelas",
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];

    $this->load->view('admin/index', $data);
  }
}
