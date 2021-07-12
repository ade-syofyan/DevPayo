<?php
// File untuk function yg akan dipakai secara general.
function Ribuan($angka)
{
    if ($angka == 0 | empty($angka)) {
        $ribuan = 0;
    } else {
        $ribuan = number_format(round($angka, 0, PHP_ROUND_HALF_UP), 0, ',', '.');
    }
    return $ribuan;
}

function RibuanPpn($angka)
{
    if ($angka == 0 | empty($angka)) {
        $ribuan = 0;
    } else {
        $ppn = $angka * (1 / 100);
        $angka = $angka + $ppn;
        $ribuan = number_format(round($angka, 0, PHP_ROUND_HALF_UP), 0, ',', '.');
    }
    return $ribuan;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
    $nama_bulan = array(
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
        "September", "Oktober", "November", "Desember"
    );
    $tahun = substr($tgl, 0, 4);
    $bulan = $nama_bulan[(int)substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text = "";
    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text .= $hari . ", ";
    }
    $text .= $tanggal . " " . $bulan . " " . $tahun;
    return $text;
}

function tgl_indo($tgl, $tampil_hari = true)
{
    $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
    $nama_bulan = array(
        1 => "Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agus",
        "Sept", "Okt", "Nov", "Des"
    );
    $tahun = substr($tgl, 0, 4);
    $bulan = $nama_bulan[(int)substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text = "";
    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text .= $hari . ", ";
    }
    $text .= $tanggal . " " . $bulan . " " . $tahun;
    return $text;
}

?>
