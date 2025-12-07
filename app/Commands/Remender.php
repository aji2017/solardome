<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Api;


class Remender extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'remender:cron';
    protected $description = 'Mengirimkan data sensor ke WhatsApp broadcasting.';

    public function run(array $params)
    {
        date_default_timezone_set('Asia/Makassar');
        
        $apiModel = new Api();
        $dataList = $apiModel->getSensorData();

        if (!is_array($dataList) || empty($dataList[0])) {
            CLI::error("❌ Data sensor tidak ditemukan atau kosong.");
            return;
        }

        $sensorData = $dataList[0]; // Ambil data terbaru (baris pertama)

        $suhu       = floatval($sensorData['suhu'] ?? 0);
        $kelembapan = floatval($sensorData['kelembapan'] ?? 0);
        $co2        = floatval($sensorData['co2'] ?? 0);
        $tegangan   = $sensorData['tegangan'] ?? '-';
        $arus       = $sensorData['arus'] ?? '-';
        $daya       = $sensorData['power'] ?? '-';

        // Cek jika semua data 0/kosong, skip pengiriman
        if ($suhu == 0 && $kelembapan == 0 && $co2 == 0) {
            CLI::write("⚠️ Data sensor masih nol, tidak mengirim pesan.", 'yellow');
            return;
        }

        $timestamp = date('d-m-Y H:i:s');
        $message = "*[Monitoring $timestamp]*\n";
        $message .= "Suhu: {$suhu}°C\nKelembapan: {$kelembapan}%\nCO2: {$co2} ppm\nTegangan: {$tegangan} V\nArus: {$arus} A\nDaya: {$daya} W";

        if ($suhu > 40 || $kelembapan > 70 || $co2 > 400) {
            $message .= "\n⚠️ *PERINGATAN:* Harap segera cek penjemuran!";
        }

        $this->sendWA('6285251565171', $message);
        CLI::write("✅ Pesan dikirim:\n" . $message, 'green');
    }

    private function sendWA($no_wa, $message)
    {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target'  => $no_wa,
                'message' => $message,
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: hotUqJqAzrMC9oh7xLsw'
            ],
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            CLI::error("❌ Gagal mengirim pesan: " . curl_error($curl));
        }
    }
}