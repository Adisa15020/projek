<?php
ob_start();
include "koneksi.php"; // Pastikan ini menyertakan file koneksi yang benar

$gejala = '';
$events = '';

if (isset($_POST['gejala'])) {
    $selectors = htmlentities(implode(',', $_POST['gejala']));
    // $events = htmlentities(implode('', $_POST['bobot']));
    $data = $selectors;
    echo "$selectors<br>";

    $input = $data;
    $pecah = explode("\r\n\r\n", $input);
    $text = "";
    for ($i = 0; $i <= count($pecah) - 1; $i++) {
        $part = str_replace($pecah[$i], "<p>".$pecah[$i]."</p>", $pecah[$i]);
        $text .= $part;
    }
    echo $text;

    // Hapus data dari tabel tmp_gejala
    mysqli_query($koneksi, "DELETE FROM tmp_gejala") or die(mysqli_error($koneksi));

    // Insert data ke tabel tmp_gejala
    $text_line = explode(",", $data);
    $posisi = 0;
    foreach ($text_line as $baris) {
        $sql = "INSERT INTO tmp_gejala (kd_gejala) VALUES ('$baris')";
        mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
        echo $baris . "<br>";
        $posisi++;
    }

    ob_start();
    echo "<meta http-equiv='refresh' content='0; url=index.php?top=proses_diagnosa.php&id=1'>";
}
?>
