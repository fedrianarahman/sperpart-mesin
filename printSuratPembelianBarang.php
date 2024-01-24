<?php
date_default_timezone_set('Asia/Jakarta');
require_once('./tcpdf/examples/tcpdf_include.php');
include './controller/conn.php';

// query data

$idPembelian = $_GET['idPembelian'];
$query = mysqli_query($conn, "SELECT 
pembelian_barang.nama_barang AS nama_barang,
pembelian_barang.kode_barang AS kode_barang,
pembelian_barang.status AS status,
pembelian_barang.created_at AS tanggal_permintaan,
pembelian_barang.updated_at AS tanggal_penyetujuan,
pembelian_barang.id AS id_pembelian,
tb_barang.jumlah_masuk AS stock,
tb_barang.photo AS photo,
u1.nama AS nama_staff,
u1.tanda_tangan AS photo_staff,
u2.nama AS nama_manager,
u2.tanda_tangan AS photo_manager
FROM pembelian_barang INNER JOIN tb_barang ON tb_barang.kode_barang  = pembelian_barang.kode_barang LEFT JOIN user u1 ON u1.id = pembelian_barang.requester LEFT JOIN user u2 ON u2.id = pembelian_barang.accepter WHERE pembelian_barang.created_at = '$idPembelian'
");

$queryBarang = mysqli_query($conn, "SELECT 
pembelian_barang.nama_barang AS nama_barang,
pembelian_barang.kode_barang AS kode_barang,
pembelian_barang.status AS status,
pembelian_barang.created_at AS tanggal_permintaan,
pembelian_barang.updated_at AS tanggal_penyetujuan,
pembelian_barang.id AS id_pembelian,
tb_barang.jumlah_masuk AS stock,
tb_barang.photo AS photo,
u1.nama AS nama_staff,
u2.nama AS nama_manager
FROM pembelian_barang INNER JOIN tb_barang ON tb_barang.kode_barang  = pembelian_barang.kode_barang LEFT JOIN user u1 ON u1.id = pembelian_barang.requester LEFT JOIN user u2 ON u2.id = pembelian_barang.accepter WHERE pembelian_barang.created_at = '$idPembelian'");
$data = mysqli_fetch_array($query);
$datatanggal1 = formatTanggal($data['tanggal_permintaan']);
$dataNoSurat = $data['kode_barang'] .''. formatTanggalKop($data['tanggal_permintaan']);
$dataPemohon1 = $data['nama_staff'];
$dataBarang1 = $data['nama_barang'];
$dataKodeBarang1 = $data['kode_barang'];
$dataStatus1 = "";
$ttdStaff = $data['photo_staff'];
$ttdManager = $data['photo_manager'];
if ($data['status']=='P') {
    $dataStatus1 = 'Menunggu Persetujuan';
} else {
    $dataStatus1 = 'Disetujui';
}
$dataPenyetuju1 = $data['nama_manager'];

function formatTanggal($param)
{
    $newFormat = strtotime($param);
    return date('d F Y', $newFormat);
}
function formatTanggalKop($param)
{
    $newFormat = strtotime($param);
    return date('/d/m/y', $newFormat);
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
<h1 style="font-size:20px; ">Surat Permintaan Pembelian Barang</h1>
EOD;
$ptSanbe = <<<EOD
<h2 style="font-size:15px;">PT Sanbe Farma</h2>
EOD;
$alamat = <<<EOD
<p style="font-size:10px;">Jl. Tamansari No.10, Tamansari, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40116</p>
EOD;
$tanggalSurat =<<<EOD
<p style="font-size:13px;">Tanggal : $datatanggal1</p>
EOD; 
$noSurat = <<<EOD
<p style="font-size:13px;">N0</p>
EOD; 
$perihal = <<<EOD
<p style="font-size:13px;">Perihal</p>
EOD;
$titikNoSurat = <<<EOD
<p style="font-size:13px;">:</p>
EOD;
$titikPerihalSurat = <<<EOD
<p style="font-size:13px;">:</p>
EOD;   
$dataNosurat = <<<EOD
<p style="font-size:13px;">$dataNoSurat</p>
EOD; 
$dataPerihal = <<<EOD
<p style="font-size:13px;">Pembelian Barang</p>
EOD;
$kepadayth = <<<EOD
<p style="font-size:13px;">Kepada Yth,<br/>Manager PT SANBE FARMA</p>
EOD;  
$sehubungan = <<<EOD
<p style="font-size:13px;">Sehubungan dengan mengurangnya Stock Barang Di Gudang, Dengan surat ini Saya Mengajukan Pembelian Barang. Detail Permohonan :</p>
EOD;

$pemohon = <<<EOD
<p style="font-size:13px;">Pemohon</p>
EOD;
$titikPemohon = <<<EOD
<p style="font-size:13px;">:</p>
EOD;
$dataPemohon =<<<EOD
<p style="font-size:13px;"> $dataPemohon1 (Staff Gudang)</p>
EOD;

$status = <<<EOD
<p style="font-size:13px;">Status</p>
EOD;
$titikStatus = <<<EOD
<p style="font-size:13px;">:</p>
EOD;
$dataStatus = <<<EOD
<p style="font-size:13px;">$dataStatus1</p>
EOD;

$demikian = <<<EOD
<p style="font-size:13px;">Demikian Surat permintaan pembelian barang ini dibuat guna untuk memenuhi kebutuhan barang yang mengalami pengurangan stok di gudang. Atas perhatianya saya ucapkan terimakasih .</p>
EOD;
$pemohonTandaTangan =<<<EOD
<p style="font-size:13px;">Pemohon</p>
EOD;
$namaPemohon =  <<<EOD
<p style="font-size:13px;">$dataPemohon1</p>
EOD;
$jabatanPemohon = <<<EOD
<p style="font-size:10px;">(Staff Gudang)</p>
EOD;
$penyetujuTangdaTangan = <<<EOD
<p style="font-size:13px;">Penyetuju</p>
EOD;
$namaPenyetuju = <<<EOD
<p style="font-size:13px;">$dataPenyetuju1</p>
EOD;
$jabatanPenyetuju = <<<EOD
<p style="font-size:13px;">(Manager)</p>
EOD;

$table = '
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
.stock{
    width : 10%;
}
.nama_barang {
    width:35%;
}
</style>
<table>
<thead>
<tr>
<th class="no">No</th>
<th>Nama Barang</th>
<th>Kode Barang</th>
<th class="stock">Stok</th>
</tr>
</thead>
<tbody>
';
$no =1;
while ($dataBarang = mysqli_fetch_array($queryBarang)) {
    $table.='
    <tr>
    <td class="no">'.$no++.'</td>
    <td>'.$dataBarang['nama_barang'].'</td>
    <td>'.$dataBarang['kode_barang'].'</td>
    <td class="stock">'.$dataBarang['stock'].'</td>
    </tr>';
}
$table.='</tbody>
</table>';

$pdf->writeHTMLCell(0, 0, 55, '', $judul, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 85, 17, $ptSanbe, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 45, 24, $alamat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 150, 35, $tanggalSurat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 40, $noSurat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 46, $perihal, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 30, 40, $titikNoSurat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 30, 46, $titikPerihalSurat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 33, 40, $dataNosurat, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 33, 46, $dataPerihal, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 60, $kepadayth, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 75, $sehubungan, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 90, $pemohon, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 33, 90, $titikPemohon, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 35, 90, $dataPemohon, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 95,  $status, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 33, 95,  $titikStatus, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 35, 95,  $dataStatus, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 105,  $table, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 13, 175,  $demikian, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 25, 195,  $pemohonTandaTangan, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 220,  $namaPemohon, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 20, 225,  $jabatanPemohon, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 150, 195,  $penyetujuTangdaTangan, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 150, 220,  $namaPenyetuju, 0, 1, 0, true, '', true);
$pdf->writeHTMLCell(0, 0, 150, 225,  $jabatanPenyetuju, 0, 1, 0, true, '', true);


// image
$pdf->Image('images/ttd/' . $ttdStaff, 20, 200, 20, 20, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);
$pdf->Image('images/ttd/' .$ttdManager, 150, 200, 20, 20, 'PNG', 'http://www.tcpdf.org', '', false, 150, '', false, false, 1, false, false, false);
$pdf->SetLineStyle(array('width' => 0.2, 'color' => array(0, 0, 0))); // Mengatur lebar garis menjadi 0.2mm (sekitar 1 piksel)
$pdf->Line(15, 30, 200, 30); // Menggambar garis dengan koordinat x1=15, y1=55, x2=200, y2=55
$pdf->Output('surat-permintaan-pembelian-barang.pdf', 'I');
