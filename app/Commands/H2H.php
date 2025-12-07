<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Api;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class H2H extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'mqtt:stream';
    protected $description = 'Kirim data sensor secara realtime ke MQTT';

    public function run(array $params)
    {
        date_default_timezone_set('Asia/Makassar');

        $apiModel = new Api();

        // Inisialisasi koneksi MQTT
        $host     = 'n047f167.ala.us-east-1.emqxsl.com';
        $port     = 8883; // Gunakan 8883 untuk koneksi TLS
        $clientId = 'solardome-' . uniqid();

        // Autentikasi dan TLS settings
        $settings = (new ConnectionSettings)
            ->setUsername('admin')
            ->setPassword('admin')
            ->setUseTls(true) // Wajib untuk port 8883
            ->setTlsSelfSignedAllowed(true) // Jika sertifikat bukan dari CA resmi
            ->setKeepAliveInterval(60)
            ->setConnectTimeout(10);

        $mqtt = new MqttClient($host, $port, $clientId);

        try {
            $mqtt->connect($settings, true);
        } catch (\Throwable $e) {
            CLI::error("Gagal koneksi ke MQTT Broker: " . $e->getMessage());
            return;
        }

        $lastData = null;

        while (true) {
            $sensorData = $apiModel->getSensorData();

            if (isset($sensorData['error'])) {
                CLI::error("Gagal ambil data: " . $sensorData['error']);
                sleep(10);
                continue;
            }

            $latest = $sensorData[0] ?? null;

            if (!$latest) {
                CLI::error("Data kosong.");
                sleep(10);
                continue;
            }

            $jsonPayload = json_encode([
                'tanggal'    => $latest['tanggal'],
                'waktu'      => $latest['waktu'],
                'suhu'       => floatval($latest['suhu']),
                'kelembapan' => floatval($latest['kelembapan']),
                'co2'        => intval($latest['co2']),
                'tegangan'   => floatval($latest['tegangan']),
                'arus'       => floatval($latest['arus']),
                'daya'       => floatval($latest['power']),
            ]);

            // Kirim hanya jika ada perubahan
            if ($jsonPayload !== $lastData) {
                try {
                    $mqtt->publish('solardome/data', $jsonPayload, 0);
                    CLI::write("✅ Data dikirim: " . $jsonPayload, 'green');
                    $lastData = $jsonPayload;
                } catch (\Throwable $e) {
                    CLI::error("❌ Gagal publish: " . $e->getMessage());
                }
            } else {
                CLI::write("⏳ Tidak ada perubahan data.", 'yellow');
            }

            sleep(10); // Delay antar pengiriman
        }

    }
}