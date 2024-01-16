<?php
require_once('./tcpdf/examples/tcpdf_include.php');
include './controller/conn.php';

// query data
$tglAwal = $_GET['tgl_awal'];
$tglAkhir = $_GET['tgl_akhir'];
$tanggalSaatIni = "";
if ($tglAwal == null && $tglAkhir == null) {
    $tanggalSaatIni = date(' F Y');
    $query = mysqli_query($conn, "SELECT
    riwayat_barang_masuk.kd_barang AS kode_barang,
    riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
    riwayat_barang_masuk.created_at AS tanggal_masuk,
    tb_barang.nama_barang AS nama_barang
    FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE DATE_FORMAT(riwayat_barang_masuk.created_at, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') ORDER BY riwayat_barang_masuk.id");
} else {
    $tanggalSaatIni = formatTanggal($tglAwal) . " - " . formatTanggal($tglAkhir);
    $query = mysqli_query($conn, "SELECT
    riwayat_barang_masuk.kd_barang AS kode_barang,
    riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
    riwayat_barang_masuk.created_at AS tanggal_masuk,
    tb_barang.nama_barang AS nama_barang
    FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE riwayat_barang_masuk.created_at BETWEEN '$tglAwal' AND DATE_ADD('$tglAkhir', INTERVAL 1 DAY) ORDER BY riwayat_barang_masuk.id");
}



function formatTanggal($param)
{
    $newFormat = strtotime($param);
    return date('d F Y', $newFormat);
}


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


// content
$judul = <<<EOD
<h1 style="font-size:20px; ">Riwayat Data Barang Masuk</h1>
EOD;
$ptSanbe = <<<EOD
<h2 style="font-size:18px;">PT Sanbe Farma</h2>
EOD;
$periode = <<<EOD
<p style="font-size:10px;">Periode $tanggalSaatIni</p>
EOD;
$alamat = <<<EOD
<p style="font-size:10px;">Jl. Tamansari No.10, Tamansari, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40116</p>
EOD;

$tabel = '
<style>
table {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-collapse: collapse; /* Menggabungkan garis tabel */
    width: 100%;
    
}
th {
    background-color: #E4E9FF; /* Menambahkan latar belakang biru pada header */
    color: #000; /* Mengubah warna teks menjadi putih */
    border: 1px solid black;
}
td{
    border: 1px solid black; 
}
.no{
    width : 5%;
}
.nama_barang {
    width:35%;
}
</style>
<table>
<tr>
<th class="no">NO</th>
<th>Kode Barang</th>
<th class="nama_barang">Nama Barang</th>
<th>Jumlah</th>
<th>Tanggal</th>
</tr>';

$no =1;
while ($data = mysqli_fetch_array($query)) {
    $tabel.='
    <tr>
    <td class="no">'.$no++.'</td>
    <td>'.$data['kode_barang'].'</td>
    <td class="nama_barang">'.$data['nama_barang'].'</td>
    <td>'.$data['jumlah_barang'].'</td>
    <td>'.formatTanggal($data['tanggal_masuk']).'</td>
    </tr>';
}

$tabel.='</table>';

$pdf->writeHTMLCell(0, 0, 65, '', $judul, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 85, 17, $ptSanbe, 0, 1, 0, true, '', true);
if ($tglAwal != null && $tglAkhir != null) {
    $pdf->writeHTMLCell(0, 0, 75, 25, $periode, 0, 1, 0, true, '', true);
} else {
    $pdf->writeHTMLCell(0, 0, 90, 25, $periode, 0, 1, 0, true, '', true);
}
$pdf->writeHTMLCell(0, 0, 45, 30, $alamat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 15, 40, $tabel, 0, 1, 0, true, '', true);


$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0))); // Mengatur lebar garis menjadi 0.2mm (sekitar 1 piksel)
$pdf->Line(15, 37, 200, 37); // Menggambar garis dengan koordinat x1=15, y1=55, x2=200, y2=55
$pdf->Output('surat-permintaan.pdf', 'I');
