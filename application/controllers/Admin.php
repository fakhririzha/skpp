<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("AdminModel");
    $this->load->helper("form");
    $this->load->library("upload");
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
      "jsFiles" => ["datatables.min.js", "cleave.min.js"]
    ];

    $this->load->view('admin/index', $data);
  }
  public function addKelas()
  {
    if ($this->input->post('addKelas')) {
      $iuranBulanan = str_replace("Rp ", "", $this->input->post("iuranBulanan"));
      $iuranBulanan = str_replace(",", "", $iuranBulanan);
      $iuranBulananSubsidi = str_replace("Rp ", "", $this->input->post("iuranBulananSubsidi"));
      $iuranBulananSubsidi = str_replace(",", "", $iuranBulananSubsidi);
      $iuranTahunan = str_replace("Rp ", "", $this->input->post("iuranTahunan"));
      $iuranTahunan = str_replace(",", "", $iuranTahunan);

      if ($iuranBulanan == "" || $iuranBulananSubsidi == "" || $iuranTahunan == "" || $iuranBulanan == "0" || $iuranBulananSubsidi == "0" || $iuranTahunan == "0") {
        $this->session->set_flashdata('actionMsg', "Iuran tidak boleh kosong!");
        redirect("admin/kelas");
      } else {
        $data = [
          'kodeKelas' => $this->input->post('kodeKelas'),
          'iuranBulanan' => $iuranBulanan,
          'iuranBulananSubsidi' => $iuranBulananSubsidi,
          'iuranTahunan' => $iuranTahunan
        ];
        if ($this->AdminModel->addKelas($data)) {
          $this->session->set_flashdata('suksesMsg', 'Sukses menambahkan kelas : ' . $data["kodeKelas"] . '.');
        } else if (!$this->AdminModel->addKelas($data)) {
          $this->session->set_flashdata('actionMsg', 'Kelas dengan kode "' . $data["kodeKelas"] . '" telah ada. Silahkan periksa kembali.');
        } else {
          $this->session->set_flashdata('actionMsg', 'Gagal menambahkan kelas.');
        }
        redirect("admin/kelas");
      }
    } else {
      redirect("admin/kelas");
    }
  }
  public function editKelas()
  {
    if ($this->input->post("editKelas")) {
      $iuranBulanan = str_replace("Rp ", "", $this->input->post("iuranBulanan"));
      $iuranBulanan = str_replace(",", "", $iuranBulanan);
      $iuranBulananSubsidi = str_replace("Rp ", "", $this->input->post("iuranBulananSubsidi"));
      $iuranBulananSubsidi = str_replace(",", "", $iuranBulananSubsidi);
      $iuranTahunan = str_replace("Rp ", "", $this->input->post("iuranTahunan"));
      $iuranTahunan = str_replace(",", "", $iuranTahunan);

      if ($iuranBulanan == "" || $iuranBulananSubsidi == "" || $iuranTahunan == "" || $iuranBulanan == "0" || $iuranBulananSubsidi == "0" || $iuranTahunan == "0") {
        $this->session->set_flashdata('actionMsg', "$iuranBulanan, $iuranBulananSubsidi, $iuranTahunan");
        redirect("admin/kelas");
      } else {
        $data = [
          'kodeKelas' => $this->input->post('kodeKelas'),
          'iuranBulanan' => $iuranBulanan,
          'iuranBulananSubsidi' => $iuranBulananSubsidi,
          'iuranTahunan' => $iuranTahunan
        ];
        if ($this->AdminModel->editKelas($data)) {
          $this->session->set_flashdata('suksesMsg', 'Sukses mengubah informasi kelas : ' . $data["kodeKelas"] . '.');
          redirect("admin/kelas");
        } else if (!$this->AdminModel->editKelas($data)) {
          $this->session->set_flashdata('actionMsg', 'Kelas dengan kode "' . $data["kodeKelas"] . '" telah ada. Silahkan periksa kembali.');
          redirect("admin/editKelas?kode_kelas=" . $data["kodeKelas"]);
        } else {
          $this->session->set_flashdata('actionMsg', 'Gagal mengubah informasi kelas.');
          redirect("admin/editKelas?kode_kelas=" . $data["kodeKelas"]);
        }
      }
    } else {
      $kode_kelas = str_replace("%20", " ", $this->input->get("kode_kelas"));

      $data = [
        "kelas" => $this->AdminModel->getKelasByKodeKelas($kode_kelas),
        "content" => "admin/pages/editKelas",
        "jsFiles" => ["cleave.min.js"]
      ];

      $this->load->view('admin/index', $data);
    }
  }
  public function hapusKelas()
  {
    $kode_kelas = str_replace("%20", " ", $this->input->get("kode_kelas"));
    if ($this->AdminModel->hapusKelas($kode_kelas) > 0) {
      $this->session->set_flashdata('suksesMsg', 'Sukses menghapus kelas : ' . $kode_kelas . '.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus kelas.');
    }
    redirect("admin/kelas");
  }

  public function importSiswa()
  {
    $namaFile = $this->input->get("file");
    if ($namaFile != "") {

      $namaFile = str_replace("%20", " ", $namaFile);
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
      $reader->setReadDataOnly(TRUE);
      $readXlsx = $reader->load("assets/file/" . $namaFile);

      $xls = $readXlsx->getActiveSheet();

      $x = 2;
      $siswa = [];

      for ($i = 2; $i < 105; $i++) {
        $end = (string) $xls->getCell("A" . $i)->getValue();
        // echo $end === 1;
        if ($end != "#" && $end != null && $end != "") {
          array_push($siswa, [
            'sttb' => $xls->getCell("B" . $i)->getValue(),
            'nama' => $xls->getCell("C" . $i)->getValue(),
            'jenis_kelamin' => $xls->getCell("D" . $i)->getValue(),
            'status' => $xls->getCell("E" . $i)->getValue()
          ]);
        } else {
          break;
        }
      }

      $import = $this->AdminModel->addSiswaImport($siswa);

      if ($import[0]) {

        $data = [
          "content" => 'admin/pages/importSiswa',
          "siswa" => $import[1],
          "jsFiles" => ["datatables.min.js"],
          "cssFiles" => ["datatables.min.css"]
        ];
        $this->load->view('admin/index', $data);
      }
      // 
      else {
        $data = [
          "content" => 'admin/pages/importSiswa'
        ];
        $this->load->view('admin/index', $data);
      }
    }
    // 
    else {
      $data = [
        "content" => 'admin/pages/importSiswa'
      ];
      $this->load->view('admin/index', $data);
    }
  }
  public function downloadTemplate()
  {
    $this->load->helper("download");

    force_download("assets/file/TEMPLATE.xlsx", NULL);
  }
  public function uploadFileTemplate()
  {
    $config['upload_path'] = './assets/file';
    $config['allowed_types'] = 'xlsx';
    $config['overwrite'] = TRUE;

    $this->upload->initialize($config);

    // GAGAL
    if (!$this->upload->do_upload('customFile')) {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('actionMsg', $error);
      redirect("admin/importSiswa");
    }
    // BERHASIL
    else {
      $data = array('upload_data' => $this->upload->data());
      $this->session->set_flashdata('suksesMsg', 'Sukses menambahkan file');
      redirect("admin/importSiswa?file=" . $data["upload_data"]["file_name"]);
    }
  }

  public function pembagianKelas()
  {
    $data = [
      "kelass" => $this->AdminModel->getAllKelas(),
      "content" => "admin/pages/pembagianKelas",
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"],
      "siswas" => $this->AdminModel->getAllSiswaBelumAdaKelas()
    ];

    $this->load->view('admin/index', $data);
  }
  public function pembagianKelasAction()
  {
    if ($this->input->post("simpanSiswa")) {
      $listToAdd = $this->input->post("sttb");
      $kelas = $this->input->post("kelas");

      $this->AdminModel->updateKelasSiswaBulk($listToAdd, $kelas);
      $this->session->set_flashdata("suksesMsg", "Berhasil menambahkan siswa pada kelas " . $kelas);
      redirect("admin/pembagianKelas");
    }
  }

  public function test()
  {
    $array = [];

    array_push($array, ['sttb' => 'bacot', 'nama' => 'test']);
    echo $array[0]['sttb'];
    var_dump($array);
  }
}
