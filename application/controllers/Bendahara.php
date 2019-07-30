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

  public function bulanan()
  {
    if ($this->input->post("filterKelas")) {
      $kelas = $this->input->post("kelas");

      $data = [
        "kelass" => $this->BendaharaModel->getAllKelas(),
        "content" => "bendahara/pages/bulanan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"],
        "siswas" => $this->BendaharaModel->getSiswaByKelas($kelas)
      ];
    } else {
      $data = [
        "kelass" => $this->BendaharaModel->getAllKelas(),
        "content" => "bendahara/pages/bulanan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"]
      ];
    }

    $this->load->view('bendahara/index', $data);
  }
  public function bayarBulanan()
  {
    if ($this->input->post("bayarBulanan")) {
      $data = [
        "sttb" => $this->input->post("sttb_x"),
        "nama" => $this->input->post("nama"),
        "tahunAkademik" => $this->input->post("tahunAkademik"),
        "semester" => $this->input->post("semester"),
        "tanggal" => $this->input->post("tanggalBayar"),
        "nominal" => $this->input->post("nominalBayar"),
        "bulanBayar" => $this->input->post("bulanBayar"),
        "idPetugas" => $this->session->id
      ];

      if ($this->BendaharaModel->addBayarBulanan($data)) {
        $this->session->set_flashdata('suksesMsg', 'Pembayaran iuran bulanan siswa : ' . $data["nama"] . ' dengan No. STTB ' . $data["sttb"] . ' SUKSES.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal memasukkan iuran bulanan. Anda mungkin telah membayar untuk bulan tersebut.');
      }
      redirect("bendahara/bulanan");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'bendahara/pages/bayarBulanan',
        "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
        "nominalBayar" => $this->BendaharaModel->getNominalBayar($sttb)
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function hapusBulanan()
  {
    $sttb = $this->input->get("sttb");
    $id = $this->input->get("id");

    if ($this->BendaharaModel->hapusTransaksiBulananBySttbId($sttb, $id)) {
      $this->session->set_flashdata('suksesMsg', 'Hapus iuran bulanan dengan No. STTB :' . $sttb . ' SUKSES.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus iuran bulanan.');
    }
    redirect("bendahara/bulanan");
  }

  public function tahunan()
  {
    if ($this->input->post("filterKelas")) {
      $kelas = $this->input->post("kelas");

      $data = [
        "kelass" => $this->BendaharaModel->getAllKelas(),
        "content" => "bendahara/pages/tahunan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"],
        "siswas" => $this->BendaharaModel->getSiswaByKelas($kelas)
      ];
    } else {
      $data = [
        "kelass" => $this->BendaharaModel->getAllKelas(),
        "content" => "bendahara/pages/tahunan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"]
      ];
    }

    $this->load->view('bendahara/index', $data);
  }
  public function bayarTahunan()
  {
    if ($this->input->post("bayarTahunan")) {
      $nominal = $this->input->post("nominalBayar");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      $data = [
        "sttb" => $this->input->post("sttb_x"),
        "nama" => $this->input->post("nama"),
        "tahunAkademik" => $this->input->post("tahunAkademik"),
        "tanggal" => $this->input->post("tanggalBayar"),
        "nominal" => $nominal,
        "idPetugas" => $this->session->id
      ];

      if ($this->BendaharaModel->addBayarTahunan($data)) {
        $this->session->set_flashdata('suksesMsg', 'Pembayaran iuran tahunan siswa : ' . $data["nama"] . ' dengan No. STTB ' . $data["sttb"] . ' SUKSES.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal memasukkan iuran tahunan karena nominal yang anda masukkan melebihi total tagihan.');
      }
      redirect("bendahara/tahunan");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'bendahara/pages/bayarTahunan',
        "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
        "jsFiles" => ["cleave.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }

  public function pemasukanLainnya()
  {
    if ($this->input->post("addPemasukanLainnya")) {
      $nominal = $this->input->post("nominalTransaksi");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      $data = [
        "kodeTransaksi" => $this->input->post("kodeTransaksi"),
        "keterangan" => $this->input->post("keterangan"),
        "tanggalTransaksi" => $this->input->post("tanggalTransaksi"),
        "nominalTransaksi" => $nominal,
        "status" => 'bukabuku',
        "idPetugas" => $this->session->id
      ];

      if ($this->BendaharaModel->addPemasukanLainnya($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil menambah pemasukan.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambahkan pemasukan. Silahkan coba lagi.');
      }
      redirect("bendahara/pemasukanLainnya");
    } else {
      $data = [
        "content" => 'bendahara/pages/pemasukanLainnya',
        "jsFiles" => ["cleave.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }

  public function pengeluaran()
  {

    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'bendahara/pages/pengeluaran',
      "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
      "kodeTransaksi" => $this->BendaharaModel->getAllKodeTransaksi(),
      "jsFiles" => ["cleave.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }
  public function addPengeluaran()
  {
    if ($this->input->post("addPengeluaran")) {
      $nominal = $this->input->post("nominalTransaksi");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      $data = [
        "kodeTransaksi" => $this->input->post("kodeTransaksi"),
        "keterangan" => $this->input->post("keterangan"),
        "tanggalTransaksi" => $this->input->post("tanggalTransaksi"),
        "nominalTransaksi" => $nominal,
        "status" => 'bukabuku',
        "idPetugas" => $this->session->id,
      ];

      if ($this->BendaharaModel->addPengeluaran($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil menambah pengeluaran.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambah pengeluaran');
      }
      redirect("bendahara/pengeluaran");
    }
  }

  public function histori()
  {
    $data = [
      "content" => 'bendahara/pages/histori',
      "historiTransaksi" => $this->BendaharaModel->getAllTransaksi(),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }
  public function historiBulanan()
  {
    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'bendahara/pages/historiBulanan',
      "historiTransaksi" => $this->BendaharaModel->getTransaksiBulananBySttb($sttb),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }
}
