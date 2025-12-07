<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Repositories\MemoryRepository;
use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\Commands;
use CodeIgniter\CLI\CLI;

class Ketentuan extends BaseCommand
{
    protected $group       = 'set';
    protected $name        = 'set:config';
    protected $description = 'Konfigurasi Ketetapan suhu, kelembapan, dan CO2 ke MQTT';

    public function run(array $params)
    {
        date_default_timezone_set('Asia/Makassar');

        $configFile = WRITEPATH . 'set_config.json';

        // Inisialisasi file jika belum ada
        if (!file_exists($configFile)) {
            file_put_contents($configFile, json_encode([
                'suhu' => 0,
                'kelembapan' => 0,
                'co2' => 0
            ]));
            CLI::write("🆕 File konfigurasi dibuat.\n", 'green');
        }

        $mqtt = new MqttClient(
            'n047f167.ala.us-east-1.emqxsl.com',
            8883,
            'solardome-config-' . uniqid(),
            MqttClient::MQTT_3_1,
            new MemoryRepository()
        );

        $settings = (new ConnectionSettings)
            ->setUsername('admin')
            ->setPassword('admin')
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false)
            ->setKeepAliveInterval(60)
            ->setConnectTimeout(10);

        try {
            CLI::write("🔌 Menghubungkan ke broker MQTT...", 'yellow');
            $mqtt->connect($settings, true);
            CLI::write("✅ Terhubung ke broker.\n", 'light_green');

            // Loop terus menerus
            while (true) {
                if (!file_exists($configFile)) {
                    CLI::write("⚠️  File konfigurasi tidak ditemukan!", 'red');
                    sleep(5);
                    continue;
                }

                $data = json_decode(file_get_contents($configFile), true);
                if (!is_array($data)) {
                    CLI::write("❌ Data konfigurasi tidak valid!", 'red');
                    sleep(5);
                    continue;
                }

                $mqtt->publish('solardome/config/suhu', $data['suhu'], 0);
                $mqtt->publish('solardome/config/kelembapan', $data['kelembapan'], 0);
                $mqtt->publish('solardome/config/co2', $data['co2'], 0);

                CLI::write(date('H:i:s') . " ✅ Konfigurasi dikirim:");
                CLI::write("  Suhu       : {$data['suhu']}");
                CLI::write("  Kelembapan : {$data['kelembapan']}");
                CLI::write("  CO2        : {$data['co2']}\n");

                // Delay 10 detik (bisa kamu ubah)
                sleep(10);
            }

        } catch (\Throwable $e) {
            CLI::error("❌ Gagal koneksi MQTT: " . $e->getMessage());
        }
    }
}
