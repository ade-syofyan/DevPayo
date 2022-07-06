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

function formatRupiah($angka)
{

    if (is_numeric($angka)) {
        $format_rupiah = 'Rp ' . number_format($angka, '2', ',', '.');
        return $format_rupiah;
    } else {
        echo "$angka" . " bukan angka yang valid!" . "\n";
    }
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

function bulanIndo($angka_bulan)
{
    $hasil = array(
        "01" => "Januari",
        "02" => "Februari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "Oktober",
        "11" => "November",
        "12" => "Desember",
        "1" => "Januari",
        "2" => "Februari",
        "3" => "Maret",
        "4" => "April",
        "5" => "Mei",
        "6" => "Juni",
        "7" => "Juli",
        "8" => "Agustus",
        "9" => "September"
    );
    return $hasil[$angka_bulan];
}
