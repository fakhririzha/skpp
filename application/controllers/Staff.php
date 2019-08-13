<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("StaffModel");
    if ($this->session->jabatan == "admin") {
      redirect("admin");
    } else if ($this->session->jabatan == "bendahara") {
      redirect("bendahara");
    } elseif ($this->session->jabatan != "staff") {
      redirect("");
    }
  }

  public function index()
  {
    $data = [
      "content" => 'staff/pages/main',
      "jumlahAkun" => $this->StaffModel->getJumlahAkun(),
      "jumlahSiswa" => $this->StaffModel->getJumlahSiswa(),
      "jumlahSiswi" => $this->StaffModel->getJumlahSiswi(),
      "headingPanel" => true
    ];
    $this->load->view('staff/index', $data);
  }

  public function bulanan()
  {
    if ($this->input->post("filterKelas")) {
      $kelas = $this->input->post("kelas");

      $data = [
        "kelass" => $this->StaffModel->getAllKelas(),
        "content" => "staff/pages/bulanan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"],
        "siswas" => $this->StaffModel->getSiswaByKelas($kelas)
      ];
    } else {
      $data = [
        "kelass" => $this->StaffModel->getAllKelas(),
        "content" => "staff/pages/bulanan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"]
      ];
    }

    $this->load->view('staff/index', $data);
  }
  public function bayarBulanan()
  {
    if ($this->input->post("bayarBulanan")) {
      $sttb = $this->input->post("sttb_x");
      $data = [
        "sttb" => $sttb,
        "nama" => $this->input->post("nama"),
        "tahunAkademik" => $this->input->post("tahunAkademik"),
        "semester" => $this->input->post("semester"),
        "tanggal" => $this->input->post("tanggalBayar"),
        "nominal" => $this->input->post("nominalBayar"),
        "bulanBayar" => $this->input->post("bulanBayar"),
        "idPetugas" => $this->session->id
      ];

      if ($this->StaffModel->addBayarBulanan($data)) {
        $this->session->set_flashdata('suksesMsg', 'Pembayaran iuran bulanan siswa : ' . $data["nama"] . ' dengan No. STTB ' . $data["sttb"] . ' SUKSES.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal memasukkan iuran bulanan. Anda mungkin telah membayar untuk bulan tersebut.');
      }
      redirect("staff/historiBulanan?sttb=$sttb");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'staff/pages/bayarBulanan',
        "siswa" => $this->StaffModel->getSiswaBySttb($sttb),
        "nominalBayar" => $this->StaffModel->getNominalBayar($sttb),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["gijgo.min.js"]
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function hapusBulanan()
  {
    $sttb = $this->input->get("sttb");
    $no_ref = $this->input->get("no_ref");

    if ($this->StaffModel->hapusTransaksiBulananBySttbId($sttb, $no_ref)) {
      $this->session->set_flashdata('suksesMsg', 'Hapus iuran bulanan dengan No. STTB :' . $sttb . ' SUKSES.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus iuran bulanan.');
    }
    redirect("staff/historiBulanan?sttb=$sttb");
  }

  public function tahunan()
  {
    if ($this->input->post("filterKelas")) {
      $kelas = $this->input->post("kelas");

      $data = [
        "kelass" => $this->StaffModel->getAllKelas(),
        "content" => "staff/pages/tahunan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"],
        "siswas" => $this->StaffModel->getSiswaByKelas($kelas)
      ];
    } else {
      $data = [
        "kelass" => $this->StaffModel->getAllKelas(),
        "content" => "staff/pages/tahunan",
        "cssFiles" => ["datatables.min.css"],
        "jsFiles" => ["datatables.min.js"]
      ];
    }

    $this->load->view('staff/index', $data);
  }
  public function bayarTahunan()
  {
    if ($this->input->post("bayarTahunan")) {
      $nominal = $this->input->post("nominalBayar");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      $sttb = $this->input->post("sttb_x");
      $data = [
        "sttb" => $sttb,
        "nama" => $this->input->post("nama"),
        "tahunAkademik" => $this->input->post("tahunAkademik"),
        "tanggal" => $this->input->post("tanggalBayar"),
        "nominal" => $nominal,
        "idPetugas" => $this->session->id
      ];

      if ($this->StaffModel->addBayarTahunan($data)) {
        $this->session->set_flashdata('suksesMsg', 'Pembayaran iuran tahunan siswa : ' . $data["nama"] . ' dengan No. STTB ' . $data["sttb"] . ' SUKSES.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal memasukkan iuran tahunan karena nominal yang anda masukkan melebihi total tagihan.');
      }
      redirect("staff/historiTahunan?sttb=$sttb");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'staff/pages/bayarTahunan',
        "siswa" => $this->StaffModel->getSiswaBySttb($sttb),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function hapusTahunan()
  {
    $sttb = $this->input->get("sttb");
    $no_ref = $this->input->get("no_ref");

    if ($this->StaffModel->hapusTransaksiTahunanBySttbId($sttb, $no_ref)) {
      $this->session->set_flashdata('suksesMsg', 'Hapus iuran tahunan dengan No. STTB :' . $sttb . ' SUKSES.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus iuran tahunan.');
    }
    redirect("staff/historiTahunan?sttb=$sttb");
  }

  public function pemasukanLainnya()
  {
    if ($this->input->post("addPemasukanLainnya")) {
      $nominal = $this->input->post("nominalTransaksi");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      if ($this->input->post("kodeTransaksi") != "4A") {
        $data = [
          "kodeTransaksi" => $this->input->post("kodeTransaksi"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => $this->input->post("tanggalTransaksi"),
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      } else {
        $data = [
          "kodeTransaksi" => $this->input->post("kodeTransaksi"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => "1970-01-01",
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      }

      if ($this->StaffModel->addPemasukanLainnya($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil menambah pemasukan.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambahkan pemasukan. Silahkan coba lagi.');
      }
      redirect("staff/pemasukanLainnya");
    } else {
      $data = [
        "content" => 'staff/pages/pemasukanLainnya',
        "jsFiles" => ["cleave.min.js"]
      ];
      $this->load->view('staff/index', $data);
    }
  }

  public function pengeluaran()
  {

    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'staff/pages/pengeluaran',
      "siswa" => $this->StaffModel->getSiswaBySttb($sttb),
      "kodeTransaksi" => $this->StaffModel->getAllKodeTransaksi(),
      "cssFiles" => ["gijgo.min.css"],
      "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
    ];
    $this->load->view('staff/index', $data);
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

      if ($this->StaffModel->addPengeluaran($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil menambah pengeluaran.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal menambah pengeluaran');
      }
      redirect("staff/histori");
    }
  }

  public function histori()
  {
    $data = [
      "content" => 'staff/pages/histori',
      "historiTransaksi" => $this->StaffModel->getAllTransaksi(),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('staff/index', $data);
  }
  public function historiBulanan()
  {
    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'staff/pages/historiBulanan',
      "historiTransaksi" => $this->StaffModel->getTransaksiBulananBySttb($sttb),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('staff/index', $data);
  }
  public function historiTahunan()
  {
    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'staff/pages/historiTahunan',
      "historiTransaksi" => $this->StaffModel->getTransaksiTahunanBySttb($sttb),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('staff/index', $data);
  }

  public function laporan()
  {
    $data = [
      "content" => 'staff/pages/laporan'
    ];
    $this->load->view('staff/index', $data);
  }
  public function laporanSpp()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanSPP($filterRentang);
    } else {
      $data = [
        "content" => 'staff/pages/laporanSpp'
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function laporanKeuangan()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanKeuangan($filterRentang);
    } else {
      $data = [
        "content" => 'staff/pages/laporanKeuangan'
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function laporanPengeluaran()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanPengeluaran($filterRentang);
    } else {
      $data = [
        "content" => 'staff/pages/laporanPengeluaran'
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function laporanDetail()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanDetail($filterRentang);
    } else {
      $data = [
        "content" => 'staff/pages/laporanDetail'
      ];
      $this->load->view('staff/index', $data);
    }
  }
  public function laporanKategori()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanKategori($filterRentang);
    } else {
      $data = [
        "content" => 'staff/pages/laporanKategori'
      ];
      $this->load->view('staff/index', $data);
    }
  }
}
