<?php

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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

      if ($this->BendaharaModel->addBayarBulanan($data)) {
        $this->session->set_flashdata('suksesMsg', 'Pembayaran iuran bulanan siswa : ' . $data["nama"] . ' dengan No. STTB ' . $data["sttb"] . ' SUKSES.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal memasukkan iuran bulanan. Anda mungkin telah membayar untuk bulan tersebut.');
      }
      redirect("bendahara/historiBulanan?sttb=$sttb");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'bendahara/pages/bayarBulanan',
        "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
        "nominalBayar" => $this->BendaharaModel->getNominalBayar($sttb),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["gijgo.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function hapusBulanan()
  {
    $sttb = $this->input->get("sttb");
    $no_ref = $this->input->get("no_ref");

    if ($this->BendaharaModel->hapusTransaksiBulananBySttbId($sttb, $no_ref)) {
      $this->session->set_flashdata('suksesMsg', 'Hapus iuran bulanan dengan No. STTB :' . $sttb . ' SUKSES.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus iuran bulanan.');
    }
    redirect("bendahara/historiBulanan?sttb=$sttb");
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
      $sttb = $this->input->post("sttb_x");
      $data = [
        "sttb" => $sttb,
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
      redirect("bendahara/historiTahunan?sttb=$sttb");
    } else {
      $sttb = $this->input->get("sttb");

      $data = [
        "content" => 'bendahara/pages/bayarTahunan',
        "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function hapusTahunan()
  {
    $sttb = $this->input->get("sttb");
    $no_ref = $this->input->get("no_ref");

    if ($this->BendaharaModel->hapusTransaksiTahunanBySttbId($sttb, $no_ref)) {
      $this->session->set_flashdata('suksesMsg', 'Hapus iuran tahunan dengan No. STTB :' . $sttb . ' SUKSES.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus iuran tahunan.');
    }
    redirect("bendahara/historiTahunan?sttb=$sttb");
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
  public function aturPemasukan()
  {
    $data = [
      "content" => 'bendahara/pages/aturPemasukan',
      "historiPemasukan" => $this->BendaharaModel->getHistoriPemasukan(),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }
  public function ubahPemasukanLainnya()
  {
    if ($this->input->post("ubahPemasukanLainnya")) {
      $nominal = $this->input->post("nominalTransaksi");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      if ($this->input->post("kodeTransaksi") != "4A") {
        $data = [
          "noRef" => $this->input->post("noRef"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => $this->input->post("tanggalTransaksi"),
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      } else {
        $data = [
          "noRef" => $this->input->post("noRef"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => "1970-01-01",
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      }

      if ($this->BendaharaModel->ubahPemasukanLainnya($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil mengubah pemasukan.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal mengubah pemasukan. Silahkan coba lagi.');
      }
      redirect("bendahara/aturPemasukan");
    } else {
      $no_ref = $this->input->get("no_ref");

      $data = [
        "content" => 'bendahara/pages/ubahPemasukanLainnya',
        "pemasukan" => $this->BendaharaModel->getPemasukanByNoRef($no_ref),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function hapusPemasukanLainnya()
  {
    $no_ref = $this->input->get("no_ref");

    if ($this->BendaharaModel->hapusPemasukanLainnya($no_ref) > 0) {
      $this->session->set_flashdata('suksesMsg', 'Sukses menghapus transaksi pemasukan dengan No. Ref : ' . $no_ref . '.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus transaksi pemasukan. Silahkan coba lagi.');
    }
    redirect("bendahara/aturPemasukan");
  }

  public function pengeluaran()
  {

    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'bendahara/pages/pengeluaran',
      "siswa" => $this->BendaharaModel->getSiswaBySttb($sttb),
      "kodeTransaksi" => $this->BendaharaModel->getAllKodeTransaksi(),
      "cssFiles" => ["gijgo.min.css"],
      "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
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
      redirect("bendahara/histori");
    }
  }
  public function aturPengeluaran()
  {
    $data = [
      "content" => 'bendahara/pages/aturPengeluaran',
      "historiPemasukan" => $this->BendaharaModel->getHistoriPengeluaran(),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }
  public function ubahPengeluaran()
  {
    if ($this->input->post("ubahPemasukanLainnya")) {
      $nominal = $this->input->post("nominalTransaksi");
      $nominal = str_replace("Rp ", "", $nominal);
      $nominal = str_replace(",", "", $nominal);
      if ($this->input->post("kodeTransaksi") != "4A") {
        $data = [
          "noRef" => $this->input->post("noRef"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => $this->input->post("tanggalTransaksi"),
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      } else {
        $data = [
          "noRef" => $this->input->post("noRef"),
          "keterangan" => $this->input->post("keterangan"),
          "tanggalTransaksi" => "1970-01-01",
          "nominalTransaksi" => $nominal,
          "status" => 'bukabuku',
          "idPetugas" => $this->session->id
        ];
      }

      if ($this->BendaharaModel->ubahPemasukanLainnya($data)) {
        $this->session->set_flashdata('suksesMsg', 'Berhasil mengubah pemasukan.');
      } else {
        $this->session->set_flashdata('actionMsg', 'Gagal mengubah pemasukan. Silahkan coba lagi.');
      }
      redirect("bendahara/aturPemasukan");
    } else {
      $no_ref = $this->input->get("no_ref");

      $data = [
        "content" => 'bendahara/pages/ubahPemasukanLainnya',
        "pemasukan" => $this->BendaharaModel->getPemasukanByNoRef($no_ref),
        "cssFiles" => ["gijgo.min.css"],
        "jsFiles" => ["cleave.min.js", "gijgo.min.js"]
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function hapusPengeluaran()
  {
    $no_ref = $this->input->get("no_ref");

    if ($this->BendaharaModel->hapusPemasukanLainnya($no_ref) > 0) {
      $this->session->set_flashdata('suksesMsg', 'Sukses menghapus transaksi pemasukan dengan No. Ref : ' . $no_ref . '.');
    } else {
      $this->session->set_flashdata('actionMsg', 'Gagal menghapus transaksi pemasukan. Silahkan coba lagi.');
    }
    redirect("bendahara/aturPemasukan");
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
  public function historiTahunan()
  {
    $sttb = $this->input->get("sttb");

    $data = [
      "content" => 'bendahara/pages/historiTahunan',
      "historiTransaksi" => $this->BendaharaModel->getTransaksiTahunanBySttb($sttb),
      "cssFiles" => ["datatables.min.css"],
      "jsFiles" => ["datatables.min.js"]
    ];
    $this->load->view('bendahara/index', $data);
  }

  public function laporan()
  {
    $data = [
      "content" => 'bendahara/pages/laporan'
    ];
    $this->load->view('bendahara/index', $data);
  }
  public function laporanSpp()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanSPP($filterRentang);
    } else {
      $data = [
        "content" => 'bendahara/pages/laporanSpp'
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function laporanKeuangan()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanKeuangan($filterRentang);
    } else {
      $data = [
        "content" => 'bendahara/pages/laporanKeuangan'
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function laporanPengeluaran()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanPengeluaran($filterRentang);
    } else {
      $data = [
        "content" => 'bendahara/pages/laporanPengeluaran'
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function laporanDetail()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanDetail($filterRentang);
    } else {
      $data = [
        "content" => 'bendahara/pages/laporanDetail'
      ];
      $this->load->view('bendahara/index', $data);
    }
  }
  public function laporanKategori()
  {
    if ($this->input->post("filterRentang")) {
      $filterRentang = $this->input->post("tahun") . "-" . $this->input->post("bulan") . "-01";
      $this->generateLaporanKategori($filterRentang);
    } else {
      $data = [
        "content" => 'bendahara/pages/laporanKategori'
      ];
      $this->load->view('bendahara/index', $data);
    }
  }

  public function generateLaporanSPP($filterRentang)
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

    $pemasukanLainnya = $this->BendaharaModel->getPemasukanLainnya($tanggalAsli, $sebulan);
    $laporanSPP = $this->BendaharaModel->getLaporanSPP($tanggalAsli, $sebulan);

    $data = [
      "pemasukanLainnya" => $pemasukanLainnya,
      "laporanSPP" => $laporanSPP,
      "tanggal" => $tanggal,
      "bulan" => Carbon::parse($tanggal)->locale("id_ID")->monthName,
      "tahun" => Carbon::createFromFormat("Y-m-d H:i:s", $tanggal)->format("Y"),
      "awal" => (int) Carbon::parse($tanggalAsli)->format("d"),
      "akhir" => (int) Carbon::parse($sebulan)->format("d"),
      "cssFiles" => ["laporan.css", "print.min.css"],
      "jsFiles" => ["print.min.js"]
    ];

    $this->load->view("bendahara/pages/laporanSPP_export", $data);
  }
  public function generateLaporanKeuangan($filterRentang = '2019-07-01')
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

    $sebulanSebelum = Carbon::parse($tanggal)->format("Y-m-d");
    $sebulanSebelum = Carbon::createFromFormat("Y-m-d", $sebulanSebelum)->subMonth(1)->lastOfMonth();

    $pemasukan = $this->BendaharaModel->getPemasukan($sebulanSebelum->format("Y-m-d"))->pemasukan;
    $pengeluaran = $this->BendaharaModel->getPengeluaran($sebulanSebelum->format("Y-m-d"))->pengeluaran;

    $saldoAwal = $pemasukan - $pengeluaran;
    $laporanKeuangan = $this->BendaharaModel->getLaporanKeuangan($tanggalAsli, $sebulan);
    $pemasukanLainnya = $this->BendaharaModel->getPemasukanLainnya($tanggalAsli, $sebulan);

    $data = [
      "pemasukan" => $pemasukan,
      "pengeluaran" => $pengeluaran,
      "saldoAwal" => $saldoAwal,
      "laporanKeuangan" => $laporanKeuangan,
      "pemasukanLainnya" => $pemasukanLainnya,
      "tanggal" => $tanggal,
      "tahun" => Carbon::createFromFormat("Y-m-d H:i:s", $tanggal)->format("Y"),
      "bulan" => Carbon::parse($tanggal)->locale("id_ID")->monthName,
      "awal" => (int) Carbon::parse($tanggalAsli)->format("d"),
      "akhir" => (int) Carbon::parse($sebulan)->format("d"),
      "cssFiles" => ["laporan.css", "print.min.css"],
      "jsFiles" => ["print.min.js"]
    ];

    $this->load->view("bendahara/pages/laporanKeuangan_export", $data);
  }
  public function generateLaporanPengeluaran($filterRentang = '2019-07-01')
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

    $laporanPengeluaran = $this->BendaharaModel->getLaporanPengeluaran($tanggalAsli, $sebulan);


    $data = [
      "laporanPengeluaran" => $laporanPengeluaran,
      "tanggal" => $tanggal,
      "tahun" => Carbon::createFromFormat("Y-m-d H:i:s", $tanggal)->format("Y"),
      "bulan" => Carbon::parse($tanggal)->locale("id_ID")->monthName,
      "awal" => (int) Carbon::parse($tanggalAsli)->format("d"),
      "akhir" => (int) Carbon::parse($sebulan)->format("d"),
      "cssFiles" => ["laporan.css", "print.min.css"],
      "jsFiles" => ["print.min.js"]
    ];

    $this->load->view("bendahara/pages/laporanPengeluaran_export", $data);
  }
  public function generateLaporanDetail($filterRentang = '2019-07-01')
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal->subMonth(1);

    $sebulanSebelum = Carbon::parse($tanggal)->format("Y-m-d");
    $sebulanSebelum = Carbon::createFromFormat("Y-m-d", $sebulanSebelum)->subMonth(1)->lastOfMonth();

    $pemasukan = $this->BendaharaModel->getPemasukan($sebulanSebelum->format("Y-m-d"))->pemasukan;
    $pengeluaran = $this->BendaharaModel->getPengeluaran($sebulanSebelum->format("Y-m-d"))->pengeluaran;

    $saldoAwal = $pemasukan - $pengeluaran;

    $start = $sebulanSebelum->addDay(1)->format("d");
    $end = $sebulanSebelum->lastOfMonth()->format("d");
    $startBln = $tanggal->format("m");
    $startThn = (int) $tanggal->format("Y");

    $laporanPengeluaran = [];
    $laporanPemasukanLainnya = [];
    $laporanSPP = [];

    array_push($laporanPengeluaran, "");
    array_push($laporanPemasukanLainnya, "");
    array_push($laporanSPP, "");

    for ($i = (int) $start; $i <= (int) $end; $i++) {
      $hari = ($i < 10) ? "0" . $i : $i;
      $tgl = $hari . '/' . $startBln . '/' . $startThn;

      $luar = $this->BendaharaModel->getLaporanPengeluaranDetail($startThn . '-' . $startBln . '-' . $hari);
      array_push($laporanPengeluaran, ["tanggal" => $tgl, "laporanPengeluaran" => $luar]);

      $masukLain = $this->BendaharaModel->getPemasukanLainnyaDetail($startThn . '-' . $startBln . '-' . $hari);
      array_push($laporanPemasukanLainnya, ["tanggal" => $tgl, "laporanPemasukanLainnya" => $masukLain]);

      $masukSPP = $this->BendaharaModel->getPenerimaanSPPDetail($startThn . '-' . $startBln . '-' . $hari);
      array_push($laporanSPP, ["tanggal" => $tgl, "laporanSPP" => $masukSPP]);
    }

    if ($saldoAwal < 1) {
      $saldoAwal = 0;
    }

    $data = [
      "saldoAwal" => $saldoAwal,
      "laporanPengeluaran" => $laporanPengeluaran,
      "laporanPemasukanLainnya" => $laporanPemasukanLainnya,
      "laporanSPP" => $laporanSPP,
      "tanggal" => $tanggal,
      "tahun" => Carbon::createFromFormat("Y-m-d H:i:s", $tanggal)->format("Y"),
      "bulan" => Carbon::parse($tanggal)->locale("id_ID")->monthName,
      "awal" => (int) Carbon::parse($tanggalAsli)->format("d"),
      "akhir" => (int) Carbon::parse($sebulan)->format("d"),
      "cssFiles" => ["laporan.css", "print.min.css"],
      "jsFiles" => ["print.min.js"]
    ];

    // var_dump([$start, $end, $pemasukan, $pengeluaran, $saldoAwal, $laporanPengeluaran, $laporanPemasukanLainnya, $laporanSPP]);
    // var_dump($laporanPengeluaran);

    $this->load->view("bendahara/pages/laporanDetail_export", $data);
  }
  public function generateLaporanKategori($filterRentang = '2019-07-01')
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1)->subMonth(1)->lastOfMonth();

    $pemasukan = $this->BendaharaModel->getPemasukan($tanggal->format("Y-m-d"))->pemasukan;
    $pengeluaran = $this->BendaharaModel->getPengeluaran($tanggal->format("Y-m-d"))->pengeluaran;

    $saldoAwal = $pemasukan - $pengeluaran;

    $startThn = (int) $tanggal->format("Y");

    // PENERIMAAN
    $penerimaanPutra = $this->BendaharaModel->getPenerimaanPutra($tanggalAsli, $sebulan);
    $penerimaanPutri = $this->BendaharaModel->getPenerimaanPutri($tanggalAsli, $sebulan);
    $pemasukanLainnya = $this->BendaharaModel->getPemasukanLainnya($tanggalAsli, $sebulan);

    // PENGELUARAN
    $pimpinan = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '1B');
    $sekretaris = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '2B');
    $bendahara = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '3B');
    $kmi = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '4B');
    $pengasuhan = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '5B');
    $dapur = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '6B');
    $pembangunan = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '7B');
    $listrik = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '8B');
    $kesejahteraan = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '9B');
    $lainLain = $this->BendaharaModel->getPengeluaranByKode($tanggalAsli, $sebulan, '10B');

    $data = [
      "penerimaanPutra" => $penerimaanPutra,
      "penerimaanPutri" => $penerimaanPutri,
      "pemasukanLainnya" => $pemasukanLainnya,
      "pimpinan" => $pimpinan,
      "sekretaris" => $sekretaris,
      "bendahara" => $bendahara,
      "kmi" => $kmi,
      "pengasuhan" => $pengasuhan,
      "dapur" => $dapur,
      "pembangunan" => $pembangunan,
      "listrik" => $listrik,
      "kesejahteraan" => $kesejahteraan,
      "lainLain" => $lainLain,
      "saldoAwal" => $saldoAwal,
      "tanggal" => $tanggal,
      "tahun" => $startThn,
      "bulan" => Carbon::parse($tanggal)->locale("id_ID")->monthName,
      "awal" => (int) Carbon::parse($tanggalAsli)->format("d"),
      "akhir" => (int) Carbon::parse($sebulan)->format("d"),
      "cssFiles" => ["laporan.css", "print.min.css"],
      "jsFiles" => ["print.min.js"]
    ];


    $this->load->view("bendahara/pages/laporanPerKategori_export", $data);
  }
}
