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

    $xls = new Spreadsheet();

    // SET PROPERTIES
    $xls->getProperties()
      ->setCreator('Ponpes Mawaridussalam')
      ->setLastModifiedBy($this->session->username)
      ->setTitle('Laporan SPP Bulanan')
      ->setSubject('Laporan SPP Bulanan');

    // SET DATA DI DOKUMEN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A1', 'NO.')
      ->setCellValue('B1', 'TANGGAL')
      ->setCellValue('C1', 'HARI')
      ->setCellValue('D1', 'PENERIMAAN PUTRA')
      ->setCellValue('E1', 'PENERIMAAN PUTRI')
      ->setCellValue('F1', 'JUMLAH');

    $i = 2;
    $num = 1;
    foreach ($laporanSPP as $data) {
      $hari = Carbon::parse($data->tanggal);
      $hari = $hari->locale('id_ID')->dayName;
      $tanggal = DateTime::createFromFormat("Y-m-d", $data->tanggal)->format("d/m/Y");
      $xls->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, $num)
        ->setCellValue('B' . $i, $tanggal)
        ->setCellValue('C' . $i, strtoupper($hari))
        ->setCellValue('D' . $i, $data->jlhPutra)
        ->setCellValue('E' . $i, $data->jlhPutri)
        ->setCellValue('F' . $i, $data->jumlah);
      $i++;
      $num++;
    }

    $lainnya = $pemasukanLainnya->pemasukanLainnya;
    if ($pemasukanLainnya->pemasukanLainnya == "") {
      $lainnya = 0;
    }

    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'LAIN-LAIN')
      ->setCellValue('C' . $i, '-')
      ->setCellValue('D' . $i, '-')
      ->setCellValue('E' . $i, '-')
      ->setCellValue('F' . $i, $lainnya);
    $i++;

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A' . $i . ':C' . $i)
      ->setCellValue('A' . $i, 'TOTAL PENERIMAAN')
      ->setCellValue('D' . $i, '=SUM(D2:D' . ($i - 1) . ')')
      ->setCellValue('E' . $i, '=SUM(E2:E' . ($i - 1) . ')')
      ->setCellValue('F' . $i, '=SUM(D' . $i . ':E' . $i . ')+F' . ($i - 1));

    $xls->getActiveSheet()
      ->getStyle('A' . $i)
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('A1:F1')
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('A2:A' . ($i - 1))
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('B2:B' . ($i - 1))
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('C2:C' . ($i - 1))
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('D' . ($i - 1))
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('E' . ($i - 1))
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('D2:D' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    $xls->getActiveSheet()->getStyle('E2:E' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    $xls->getActiveSheet()->getStyle('F2:F' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    foreach (range('A', 'F') as $columnID) {
      $xls->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
    }

    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
          'color' => ['rgb' => '000000'],
        ],
      ],
    ];

    $bulan = Carbon::parse($filterRentang);
    $bulan = $bulan->locale('id_ID')->monthName;


    $xls->getActiveSheet()->getStyle('A1:F' . $i)->applyFromArray($styleArray);
    $xls->getActiveSheet()->setTitle('Report SPP');
    $xls->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Report SPP Bulan ' . $bulan . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($xls, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
  public function generateLaporanKeuangan($filterRentang)
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

    $pemasukan = $this->BendaharaModel->getPemasukan($tanggal->format("Y-m-d"))->pemasukan;
    $pengeluaran = $this->BendaharaModel->getPengeluaran($tanggal->format("Y-m-d"))->pengeluaran;

    $saldoAwal = $pemasukan - $pengeluaran;
    $laporanKeuangan = $this->BendaharaModel->getLaporanKeuangan($tanggalAsli, $sebulan);
    $pemasukanLainnya = $this->BendaharaModel->getPemasukanLainnya($tanggalAsli, $sebulan);

    $xls = new Spreadsheet();

    $xls->getProperties()
      ->setCreator('Ponpes Mawaridussalam')
      ->setLastModifiedBy($this->session->username)
      ->setTitle('Laporan Keuangan Bulanan')
      ->setSubject('Laporan Keuangan Bulanan');

    // SET DATA DI DOKUMEN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A1', 'NO.')
      ->setCellValue('B1', 'TANGGAL')
      ->setCellValue('C1', 'HARI')
      ->setCellValue('D1', 'DEBET')
      ->setCellValue('E1', 'KREDIT')
      ->setCellValue('F1', 'SALDO');

    $i = 2;
    $num = 1;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, '')
      ->setCellValue('C' . $i, '')
      ->setCellValue('D' . $i, '')
      ->setCellValue('E' . $i, '')
      ->setCellValue('F' . $i, $saldoAwal);
    $i++;

    $saldo = $saldoAwal;

    foreach ($laporanKeuangan as $data) {
      $hari = Carbon::parse($data->tanggal);
      $hari = $hari->locale('id_ID')->dayName;
      $tanggal = DateTime::createFromFormat("Y-m-d", $data->tanggal)->format("d/m/Y");

      $saldo = $saldo + ($data->jlhDebit - $data->jlhKredit);

      $xls->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, $num)
        ->setCellValue('B' . $i, $tanggal)
        ->setCellValue('C' . $i, strtoupper($hari))
        ->setCellValue('D' . $i, $data->jlhDebit)
        ->setCellValue('E' . $i, $data->jlhKredit)
        ->setCellValue('F' . $i, $saldo);
      $i++;
      $num++;
    }
    $lainnya = $pemasukanLainnya->pemasukanLainnya;
    if ($pemasukanLainnya->pemasukanLainnya == "") {
      $lainnya = 0;
    }
    $saldoSkrg = $lainnya + $saldo;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'LAIN-LAIN')
      ->setCellValue('C' . $i, '')
      ->setCellValue('D' . $i, $lainnya)
      ->setCellValue('E' . $i, '')
      ->setCellValue('F' . $i, $saldoSkrg);
    // ->setCellValue('F' . $i, '=SUM(F2:F' . ($i - 1) . ')');
    $i++;

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A' . $i . ':C' . $i)
      ->setCellValue('A' . $i, 'TOTAL KESELURUHAN')
      ->setCellValue('D' . $i, '=SUM(D2:D' . ($i - 1) . ')')
      ->setCellValue('E' . $i, '=SUM(E2:E' . ($i - 1) . ')')
      ->setCellValue(
        'F' . $i,
        $saldoSkrg
      );

    $xls->getActiveSheet()
      ->getStyle('A1:F1')
      ->getAlignment('A1:F1')
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $xls->getActiveSheet()
      ->getStyle('A2:C' . ($i - 1))
      ->getAlignment('A2:C' . ($i - 1))
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('D3:F' . $i)
      ->getNumberFormat()
      ->setFormatCode('Rp#,##0');
    $xls->getActiveSheet(0)->getStyle('F2')
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    foreach (range('A', 'F') as $columnID) {
      $xls->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
    }

    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
          'color' => ['rgb' => '000000'],
        ],
      ],
    ];
    $xls->getActiveSheet()->getStyle('A1:F' . $i)->applyFromArray($styleArray);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Keuangan.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($xls, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
  public function generateLaporanPengeluaran($filterRentang)
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

    $laporanPengeluaran = $this->BendaharaModel->getLaporanPengeluaran($tanggalAsli, $sebulan);

    $xls = new Spreadsheet();

    // $drawing = new Drawing();
    // $drawing->setName('Logo');
    // $drawing->setDescription('Logo');
    // $drawing->setPath('captcha/1564542478.9699.jpg'); // put your path and image here
    // $drawing->setCoordinates('A1');
    // $drawing->setWorksheet($xls->getActiveSheet());

    $xls->getProperties()
      ->setCreator('Ponpes Mawaridussalam')
      ->setLastModifiedBy($this->session->username)
      ->setTitle('Laporan Pengeluaran')
      ->setSubject('Laporan Pengeluaran');

    // SET DATA DI DOKUMEN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A1', 'NO.')
      ->setCellValue('B1', 'TANGGAL')
      ->setCellValue('C1', 'HARI')
      ->setCellValue('D1', 'PENGELUARAN');

    $i = 2;
    $num = 1;

    foreach ($laporanPengeluaran as $data) {
      $hari = Carbon::parse($data->tanggal);
      $hari = $hari->locale('id_ID')->dayName;
      $tanggal = DateTime::createFromFormat("Y-m-d", $data->tanggal)->format("d/m/Y");

      $xls->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, $num)
        ->setCellValue('B' . $i, $tanggal)
        ->setCellValue('C' . $i, strtoupper($hari))
        ->setCellValue('D' . $i, $data->pengeluaran);
      $i++;
      $num++;
    }

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A' . $i . ':C' . $i)
      ->setCellValue('A' . $i, 'TOTAL KESELURUHAN')
      ->setCellValue('D' . $i, '=SUM(D2:D' . ($i - 1) . ')');

    $xls->getActiveSheet()
      ->getStyle('A1:D1')
      ->getAlignment('A1:D1')
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $xls->getActiveSheet()
      ->getStyle('A2:C' . ($i - 1))
      ->getAlignment('A2:C' . ($i - 1))
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('D2:D' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    foreach (range('A', 'D') as $columnID) {
      $xls->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
    }

    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
          'color' => ['rgb' => '000000'],
        ],
      ],
    ];
    $xls->getActiveSheet()->getStyle('A1:D' . $i)->applyFromArray($styleArray);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Pengeluaran.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($xls, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
  public function generateLaporanDetail($filterRentang)
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal->subDay(1);

    $pemasukan = $this->BendaharaModel->getPemasukan($tanggal->format("Y-m-d"))->pemasukan;
    $pengeluaran = $this->BendaharaModel->getPengeluaran($tanggal->format("Y-m-d"))->pengeluaran;

    $saldoAwal = $pemasukan - $pengeluaran;

    $start = $tanggal->subMonth(1)->addDay(1)->format("d");
    $end = $tanggal->addMonth(1)->subDay(1)->format("d");
    $startBln = $tanggal->format("m");
    $startThn = (int) $tanggal->format("Y");

    // echo Carbon::parse($tanggal)->locale('id_ID')->getTranslatedMonthName();
    // die;

    $xls = new Spreadsheet();

    $xls->getProperties()
      ->setCreator('Ponpes Mawaridussalam')
      ->setLastModifiedBy($this->session->username)
      ->setTitle('Laporan Keuangan Detail Bulanan')
      ->setSubject('Laporan Keuangan Detail Bulanan');

    // SET DATA DI DOKUMEN

    $xls->setActiveSheetIndex(0)
      ->setCellValue('A1', '')
      ->setCellValue('B1', '')
      ->setCellValue('C1', 'BULAN ' . strtoupper(Carbon::parse($tanggal)->locale('id_ID')->getTranslatedMonthName()) . ' ' . $startThn)
      ->setCellValue('D1', '')
      ->setCellValue('E1', '')
      ->setCellValue('F1', '');

    $xls->setActiveSheetIndex(0)
      ->setCellValue('A2', 'TANGGAL')
      ->setCellValue('B2', 'KODE')
      ->setCellValue('C2', 'KETERANGAN')
      ->setCellValue('D2', 'DEBIT')
      ->setCellValue('E2', 'KREDIT')
      ->setCellValue('F2', 'SALDO');

    $i = 3;

    if ($saldoAwal < 1) {
      $saldoAwal = 0;
    }
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, '')
      ->setCellValue('C' . $i, '')
      ->setCellValue('D' . $i, '')
      ->setCellValue('E' . $i, '')
      ->setCellValue('F' . $i, $saldoAwal);
    $i++;

    for ($tgl = (int) $start; $tgl <= (int) $end; $tgl++) {
      if ($tgl < 10) {
        $tgl = '0' . $tgl;
      }
      $jlhDataPerHari = 0;
      $pengeluaran = $this->BendaharaModel->getLaporanPengeluaranDetail($startThn . '-' . $startBln . '-' . $tgl);
      if (count($pengeluaran) > 0) {
        for ($x = 0; $x < count($pengeluaran); $x++) {
          $xls->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, (int) $tgl)
            ->setCellValue('B' . $i, $pengeluaran[$x]->kode)
            ->setCellValue('C' . $i, $pengeluaran[$x]->keterangan)
            ->setCellValue('D' . $i, 0)
            ->setCellValue('E' . $i, $pengeluaran[$x]->nominal)
            ->setCellValue('F' . $i, '');
          $i++;
          $jlhDataPerHari++;
        }
      } else {
        $xls->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, (int) $tgl)
          ->setCellValue('B' . $i, '')
          ->setCellValue('C' . $i, '')
          ->setCellValue('D' . $i, 0)
          ->setCellValue('E' . $i, 0)
          ->setCellValue('F' . $i, 0);
        $i++;
        $jlhDataPerHari++;
      }
      $pemasukan = $this->BendaharaModel->getPemasukanLainnyaDetail($startThn . '-' . $startBln . '-' . $tgl);
      for ($x = 0; $x < count($pemasukan); $x++) {
        $xls->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, (int) $tgl)
          ->setCellValue('B' . $i, $pemasukan[$x]->kode)
          ->setCellValue('C' . $i, $pemasukan[$x]->keterangan)
          ->setCellValue('D' . $i, 0)
          ->setCellValue('E' . $i, $pemasukan[$x]->nominal)
          ->setCellValue('F' . $i, '');
        $i++;
        $jlhDataPerHari++;
      }
      $pemasukanSPP = $this->BendaharaModel->getPenerimaanSPPDetail($startThn . '-' . $startBln . '-' . $tgl);
      for ($x = 0; $x < count($pemasukanSPP); $x++) {
        $xls->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, (int) $tgl)
          ->setCellValue('B' . $i, '1A')
          ->setCellValue('C' . $i, 'Penerimaan Putra')
          ->setCellValue('D' . $i, $pemasukanSPP[$x]->penerimaanPutra)
          ->setCellValue('E' . $i, 0)
          ->setCellValue('F' . $i, '');
        $i++;
        $jlhDataPerHari++;

        $xls->setActiveSheetIndex(0)
          ->setCellValue('A' . $i, (int) $tgl)
          ->setCellValue('B' . $i, '2A')
          ->setCellValue('C' . $i, 'Penerimaan Putri')
          ->setCellValue('D' . $i, $pemasukanSPP[$x]->penerimaanPutri)
          ->setCellValue('E' . $i, 0)
          ->setCellValue('F' . $i, '');
        $i++;
        $jlhDataPerHari++;
      }

      $xls->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, '')
        ->setCellValue('B' . $i, '')
        ->setCellValue('C' . $i, '')
        ->setCellValue('D' . $i, '=SUM(D' . ($i - $jlhDataPerHari) . ':D' . ($i - 1) . ')')
        ->setCellValue('E' . $i, '=SUM(E' . ($i - $jlhDataPerHari) . ':E' . ($i - 1) . ')');

      $penerimaanHariIni = (int) $xls->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
      $pengeluaranHariIni = (int) $xls->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();

      // echo $penerimaanHariIni . $pengeluaranHariIni;
      // die;

      $saldo = $saldoAwal + ($penerimaanHariIni - $pengeluaranHariIni);
      $saldoAwal = $saldo;

      $xls->getActiveSheet()
        ->setCellValue('F' . $i, $saldo);

      $i += 2;
    }

    $xls->getActiveSheet()
      ->getStyle('A3:B' . $i)
      ->getAlignment('A3:B' . $i)
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('D3:F' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    foreach (range('A', 'F') as $columnID) {
      $xls->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
    }

    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
          'color' => ['rgb' => '000000'],
        ],
      ],
    ];
    $headingStyleArray = [
      'font' => [
        'bold' => true
      ]
    ];
    $xls->getActiveSheet()->getStyle('A1:F2')->applyFromArray($headingStyleArray);
    $xls->getActiveSheet()->getStyle('A1:F' . $i)->applyFromArray($styleArray);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Keuangan Detail.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($xls, 'Xlsx');
    $writer->save('php://output');
    exit;

    // $data = $this->BendaharaModel->getLaporanDetailPenerimaan($tanggalAsli, $sebulan);
    // foreach ($data as $data) {
    //   echo $data->penerimaanPutra;
    //   echo "+";
    //   echo $data->penerimaanPutri;
    //   echo "<br>";
    // }
  }
  public function generateLaporanKategori($filterRentang)
  {
    $tanggal = Carbon::createFromFormat("Y-m-d", $filterRentang);
    $tanggalAsli = $tanggal->format("Y-m-d");
    $sebulan = Carbon::createFromFormat("Y-m-d H:i:s", $tanggal->addMonth(1)->subDay(1))->format("Y-m-d");
    $tanggal = $tanggal->subDay(1);

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

    $xls = new Spreadsheet();

    $xls->getProperties()
      ->setCreator('Ponpes Mawaridussalam')
      ->setLastModifiedBy($this->session->username)
      ->setTitle('Laporan Per Kategori')
      ->setSubject('Laporan Per Kategori');

    // SET HEADING DI DOKUMEN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A1', '')
      ->setCellValue('B1', '')
      ->setCellValue('C1', '');

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A2:C2')
      ->setCellValue('A2', 'LAPORAN KEUANGAN');

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A3:C3')
      ->setCellValue('A3', 'BULAN ' . strtoupper(Carbon::parse($tanggal)->locale('id_ID')->getTranslatedMonthName()) . ' ' . $startThn);

    $xls->setActiveSheetIndex(0)
      ->setCellValue('A4', '')
      ->setCellValue('B4', '')
      ->setCellValue('C4', '');
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A5', '')
      ->setCellValue('B5', '')
      ->setCellValue('C5', '');

    $i = 6;
    $num = 1;

    // HEADING PENERIMAAN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, 'A')
      ->setCellValue('B' . $i, 'PENERIMAAN')
      ->setCellValue('C' . $i, '');
    $headingPenerimaan = $i;
    $i++;

    // IURAN SANTRI
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, 'IURAN SANTRI')
      ->setCellValue('C' . $i, '');
    $i++;

    // DATA PENERIMAAN
    $jlhData = 0;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Penerimaan Putra')
      ->setCellValue('C' . $i, $penerimaanPutra->putra > 0 ? $penerimaanPutra->putra : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Penerimaan Putri')
      ->setCellValue('C' . $i, $penerimaanPutri->putri > 0 ? $penerimaanPutri->putri : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Penerimaan Lainnya')
      ->setCellValue('C' . $i, $pemasukanLainnya->pemasukanLainnya > 0 ? $pemasukanLainnya->pemasukanLainnya : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, 'TOTAL PENERIMAAN')
      ->setCellValue('C' . $i, '=SUM(C' . ($i - $jlhData) . ':C' . ($i - 1) . ')');
    $barisPenerimaan = $i;
    $i += 2;
    $num = 1;

    // HEADING PENGELUARAN
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, 'B')
      ->setCellValue('B' . $i, 'PENGELUARAN')
      ->setCellValue('C' . $i, '');
    $headingPengeluaran = $i;
    $i++;

    // DATA PENGELUARAN
    $jlhData = 0;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Pimpinan')
      ->setCellValue('C' . $i, $pimpinan->jumlah > 0 ? $pimpinan->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Sekretaris')
      ->setCellValue('C' . $i, $sekretaris->jumlah > 0 ? $sekretaris->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Bendahara')
      ->setCellValue('C' . $i, $bendahara->jumlah > 0 ? $bendahara->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'KMI')
      ->setCellValue('C' . $i, $kmi->jumlah > 0 ? $kmi->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Pengasuhan')
      ->setCellValue('C' . $i, $pengasuhan->jumlah > 0 ? $pengasuhan->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Dapur')
      ->setCellValue('C' . $i, $dapur->jumlah > 0 ? $dapur->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Pembangunan')
      ->setCellValue('C' . $i, $pembangunan->jumlah > 0 ? $pembangunan->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Listrik')
      ->setCellValue('C' . $i, $listrik->jumlah > 0 ? $listrik->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Kesejahteraan')
      ->setCellValue('C' . $i, $kesejahteraan->jumlah > 0 ? $kesejahteraan->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, $num)
      ->setCellValue('B' . $i, 'Lain-Lain')
      ->setCellValue('C' . $i, $lainLain->jumlah > 0 ? $lainLain->jumlah : 0);
    $i++;
    $num++;
    $jlhData++;

    $xls->setActiveSheetIndex(0)
      ->mergeCells('A' . $i . ':B' . $i)
      ->setCellValue('A' . $i, 'TOTAL PENGELUARAN')
      ->setCellValue('C' . $i, '=SUM(C' . ($i - $jlhData) . ':C' . ($i - 1) . ')');
    $barisPengeluaran = $i;
    $i += 2;
    $num = 1;

    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, 'Saldo Bulan Ini')
      ->setCellValue('C' . $i, '=C' . $barisPenerimaan . '-C' . $barisPengeluaran);
    $i++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, 'Saldo Bulan Lalu')
      ->setCellValue('C' . $i, $saldoAwal);
    $i++;
    $xls->setActiveSheetIndex(0)
      ->setCellValue('A' . $i, '')
      ->setCellValue('B' . $i, 'Saldo Akhir')
      ->setCellValue('C' . $i, '=C' . ($i - 2) . '-C' . ($i - 1));
    $i++;

    $xls->getActiveSheet()
      ->getStyle('B' . $headingPenerimaan)
      ->getAlignment('B' . $headingPenerimaan)
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $xls->getActiveSheet()
      ->getStyle('B' . $headingPengeluaran)
      ->getAlignment('B' . $headingPengeluaran)
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    // $xls->getActiveSheet()
    //   ->getStyle('A2:C' . ($i - 1))
    //   ->getAlignment('A2:C' . ($i - 1))
    //   ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    //   ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    $xls->getActiveSheet()->getStyle('C8:C' . $i)
      ->getNumberFormat()
      ->setFormatCode('_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)');

    foreach (range('A', 'C') as $columnID) {
      $xls->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
    }

    $styleArray = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
          'color' => ['rgb' => '000000'],
        ],
      ],
    ];
    $xls->getActiveSheet()->getStyle('A1:C' . ($i - 1))->applyFromArray($styleArray);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Pengeluaran.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $writer = IOFactory::createWriter($xls, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
}
