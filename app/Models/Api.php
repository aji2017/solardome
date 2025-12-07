<?php

namespace App\Models;
use DOMDocument;
use DOMXPath;
use DateTime;
use CodeIgniter\Model;


class Api extends Model
{
    public function getSensorData(): array
{
    $loginUrl = 'https://domesamarinda.iotmu.id/login_proses.php';
    $dataUrl  = 'https://domesamarinda.iotmu.id/datasensor.php';

    $postFields = [
        'username' => 'Admin',
        'password' => 'Admin5758'
    ];

    $cookieFile = tempnam(sys_get_temp_dir(), 'cookie');

    $ch = curl_init();

    // Login
    curl_setopt_array($ch, [
        CURLOPT_URL            => $loginUrl,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($postFields),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_COOKIEJAR      => $cookieFile,
        CURLOPT_COOKIEFILE     => $cookieFile,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $loginResult = curl_exec($ch);
    if ($loginResult === false) {
        unlink($cookieFile);
        return ['error' => 'Login gagal: ' . curl_error($ch)];
    }

    if (stripos($loginResult, 'Silahkan Login') !== false) {
        unlink($cookieFile);
        return ['error' => 'Login gagal, username/password salah atau session tidak terbawa'];
    }

    // Ambil data HTML tabel
    curl_setopt_array($ch, [
        CURLOPT_URL        => $dataUrl,
        CURLOPT_HTTPGET    => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_COOKIEFILE => $cookieFile,
    ]);

    $dataResult = curl_exec($ch);
    curl_close($ch);
    unlink($cookieFile);

    if ($dataResult === false) {
        return ['error' => 'Gagal mengambil data sensor'];
    }

    // Parsing HTML menggunakan DOMDocument dan DOMXPath
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($dataResult);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);

    // Query semua <tr> di tbody tabel sensor, kecuali header
    $rows = $xpath->query('//table[contains(@class,"table")]/tbody/tr');

    if ($rows->length === 0) {
        return ['error' => 'Data sensor tidak ditemukan dalam HTML'];
    }

    $filtered = [];
    foreach ($rows as $row) {
        $cols = $row->getElementsByTagName('td');
        if ($cols->length < 8) continue; // Pastikan kolom cukup

        $filtered[] = [
            'tanggal'    => trim($cols->item(0)->textContent),
            'waktu'      => trim($cols->item(1)->textContent),
            'suhu'       => str_replace(',', '.', trim($cols->item(2)->textContent)), // ganti koma jadi titik desimal
            'kelembapan' => str_replace(',', '.', trim($cols->item(3)->textContent)),
            'co2'        => trim($cols->item(4)->textContent),
            'tegangan'   => str_replace(',', '.', trim($cols->item(5)->textContent)),
            'arus'       => str_replace(',', '.', trim($cols->item(6)->textContent)),
            'power'      => str_replace(',', '.', trim($cols->item(7)->textContent)),
        ];
    }

    return $filtered;
}

}