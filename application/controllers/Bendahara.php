<?php

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
      ->setFormatCode('Rp#,##0');

    $xls->getActiveSheet()->getStyle('E2:E' . $i)
      ->getNumberFormat()
      ->setFormatCode('Rp#,##0');

    $xls->getActiveSheet()->getStyle('F2:F' . $i)
      ->getNumberFormat()
      ->setFormatCode('Rp#,##0');

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
      ->setFormatCode('Rp#,##0');

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
}
