<?php
require_once('./tcpdf/examples/tcpdf_include.php');
include './controller/conn.php';

$idPermintaan = $_GET['id'];
$getDetailPermintaan = mysqli_query($conn, "SELECT
tb_permintaan.nama_barang AS nama_barang,
tb_permintaan.status AS status,
tb_permintaan.id AS id_permintaan,
tb_permintaan.jumlah_barang AS jumlah_barang,
tb_permintaan.created_at AS tgl_permintaan,
tb_barang.photo AS photo,
tb_barang.kode_barang AS kode_barang,
u1.nama AS nama_teknisi,
u2.nama AS nama_staff ,
u3.nama AS nama_operator
FROM tb_permintaan
INNER JOIN user u1 ON u1.id = tb_permintaan.id_user
LEFT JOIN user u2 ON u2.id = tb_permintaan.accepter
LEFT JOIN user u3 ON u3.id = tb_permintaan.operator
INNER JOIN tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang
WHERE tb_permintaan.id = '$idPermintaan'");
$data = mysqli_fetch_array($getDetailPermintaan);
// data
$dataNamaTeknisi = $data['nama_teknisi'];
$dataNamaBarang = $data['nama_barang'];
$dataJumlah = $data['jumlah_barang'];
$dataTanggalPermintaan0 = strtotime($data['tgl_permintaan']);
$dataTanggalPermintaan = date('d F Y', $dataTanggalPermintaan0);
$dataKodeBarang = $data['kode_barang'];
$dataNamaStaff = $data['nama_staff'];
$dataNamaOPerator = $data['nama_operator']; 

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES . '';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



$judul = <<<EOD
<h1 style="font-size:20px; ">Surat Persetujuan Permintaan Barang</h1>
EOD;
$ptSanbe = <<<EOD
<h2 style="font-size:17px;">PT Sanbe Farma</h2>
EOD;
$alamat = <<<EOD
<p style="font-size:10px;">Jl. Tamansari No.10, Tamansari, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40116</p>
EOD;
$namaTeknisi = <<<EOD
<p>Nama Teknisi</p>
EOD;
$jenisBarang = <<<EOD
<p>Jenis Barang</p>
EOD;
$kodeBarang = <<<EOD
<p>Kode Barang</p>
EOD;
$jumlahBanyak = <<<EOD
<p>Jumlah Banyak</p>
EOD;
$tglPermintaan = <<<EOD
<p>Tanggal Permintaan</p>
EOD;

// titik
$titik1 = <<<EOD
<p>:</p>
EOD;
$titik2 = <<<EOD
<p>:</p>
EOD;
$titik3 = <<<EOD
<p>:</p>
EOD;
$titik4 = <<<EOD
<p>:</p>
EOD;
$titik5 = <<<EOD
<p>:</p>
EOD;

// data
$namaTeknisi1 = <<<EOD
<p>$dataNamaTeknisi</p>
EOD;
$jenisBarang1 = <<<EOD
<p>$dataNamaBarang</p>
EOD;
$kodeBarang1 = <<<EOD
<p>$dataKodeBarang</p>
EOD;
$jumlahBanyak1 =<<<EOD
<p>$dataJumlah</p>
EOD;
$tglPermintaan1 = <<<EOD
<p>$dataTanggalPermintaan</p>
EOD;

// disetujui
$disetujuiOleh = <<<EOD
<p>Disetujui Oleh :</p>
EOD;
$namaStaffGudang = <<<EOD
<p>$dataNamaStaff</p>
EOD;
$staffGudang = <<<EOD
<p>Staff Gudang</p>
EOD;
$namaManager = <<<EOD
<p>Raihan Fadilah</p>
EOD;
$manager = <<<EOD
<p>Manager</p>
EOD;
$namaOperator = <<<EOD
<p>Ahmad Baihaqi</p>
EOD;
$operator = <<<EOD
<p>Operator Gudang</p>
EOD;

$pdf->writeHTMLCell(0, 0, 50, '', $judul, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 80, 20, $ptSanbe, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 45, 30, $alamat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 50, $namaTeknisi, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 58, $jenisBarang, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 66, $kodeBarang, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 74, $jumlahBanyak, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 82, $tglPermintaan, 0, 1, 0, true, '', true);

// titik
$pdf->writeHTMLCell(0, 0, 70, 50, $titik1, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 70, 58, $titik2, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 70, 66, $titik3, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 70, 74, $titik3, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 70, 82, $titik3, 0, 1, 0, true, '', true);

// data
$pdf->writeHTMLCell(0, 0, 75, 50, $namaTeknisi1, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 75, 58, $jenisBarang1, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 75, 66, $kodeBarang1, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 75, 74, $jumlahBanyak1, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 75, 82, $tglPermintaan1, 0, 1, 0, true, '', true);

// disetujui oleh
$pdf->writeHTMLCell(0, 0, 75, 100, $disetujuiOleh, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 110, $namaStaffGudang, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 145, $staffGudang, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 75, 110, $namaManager, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 77, 145, $manager, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 130, 110, $namaOperator, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 130, 145, $operator, 0, 1, 0, true, '', true);
$pdf->Image('images\ttd\1702101318_staff_ttd.png', 20, 118, 25, 25, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);
$pdf->Image('./images/ttd/ttd1.png', 75, 118, 25, 25, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);
$pdf->Image('images\ttd\1702101363_operator_ttd.png', 130, 118, 25, 25, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);



  



$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0))); // Mengatur lebar garis menjadi 0.2mm (sekitar 1 piksel)
$pdf->Line(15, 37, 200, 37); // Menggambar garis dengan koordinat x1=15, y1=55, x2=200, y2=55
$pdf->Output('surat-permintaan.pdf', 'I');
?>