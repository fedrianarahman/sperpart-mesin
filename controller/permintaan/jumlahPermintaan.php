<?php
include '../conn.php';

$getDataPermintaan  = mysqli_query($conn, "SELECT * FROM tb_permintaan ORDER BY created_at DESC");

$arr_data = [];

if (mysqli_num_rows($getDataPermintaan) > 0) {
    while ($data = mysqli_fetch_array($getDataPermintaan)) {
        array_push($arr_data, ['createdAt' => $data['created_at']]);
    }
    header("Content-type: application/json");
    echo json_encode(['data' => $arr_data]);
} else {
    echo json_encode(['error' => 'No data available.']);
}
?>
