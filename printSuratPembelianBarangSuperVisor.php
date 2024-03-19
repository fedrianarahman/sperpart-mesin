<?php
date_default_timezone_set('Asia/Jakarta');
require_once('./tcpdf/examples/tcpdf_include.php');
include './controller/conn.php';

// query data

$iduser = $_GET['id_supervisor'];
$query = mysqli_query($conn, "SELECT * FROM pembelian_barang WHERE id_superVisor = '$iduser' AND status = 'A-'");


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
<h1 style="font-size:20px; ">Surat Permintaan Pembelian Barang </h1>
EOD;
$ptSanbe = <<<EOD
<h2 style="font-size:15px;">PT Sanbe Farma</h2>
EOD;
$alamat = <<<EOD
<p style="font-size:10px;">Jl. Tamansari No.10, Tamansari, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40116</p>
EOD;
$daftarBarang = <<<EOD
<p style="font-size:10px;">Daftar Barang :</p>
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
    width:30%;
}
</style>
<table>
<thead>
<tr>
<th class="no">No</th>
<th>Kode Barang</th>
<th class="nama_barang">Nama Barang</th>
<th>Nama Suplier</th>
<th>No Suplier</th>
<th>Jumlah Masuk</th>
</tr>
</thead>
<tbody>';
$no = 1;
while ($data = mysqli_fetch_array($query)) {
    $tabel.='
    <tr>
    <td class="no">'.$no++.'</td>
    <td>'.$data['kode_barang'].'</td>
    <td class="nama_barang">'.$data['nama_barang'].'</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';
}

$tabel.='</tbody>
</table>';
$pdf->writeHTMLCell(0, 0, 55, '', $judul, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 85, 17, $ptSanbe, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 45, 24, $alamat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 15, 40, $daftarBarang, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 15, 50, $tabel, 0, 1, 0, true, '', true);


$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0))); // Mengatur lebar garis menjadi 0.2mm (sekitar 1 piksel)
$pdf->Line(15, 30, 200, 30); // Menggambar garis dengan koordinat x1=15, y1=55, x2=200, y2=55
$pdf->Output('surat-permintaan-pembelian-barang.pdf', 'I');
