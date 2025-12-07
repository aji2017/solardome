<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Repositories\MemoryRepository;
use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\Commands;
use CodeIgniter\CLI\CLI;

class Statusesp extends BaseCommand
{
    protected $group       = 'statusesp';
    protected $name        = 'esp:status';
    protected $description = 'Status ESP Kontaktor';

    public function run(array $params)
    {
        $clientId = 'solardome_statuskontaktor-' . uniqid();
        $mqttHost = 'n047f167.ala.us-east-1.emqxsl.com';
        $mqttPort = 8883;

        $mqtt = new MqttClient(
            $mqttHost,
            $mqttPort,
            $clientId,
            MqttClient::MQTT_3_1,
            new MemoryRepository()
        );

        $settings = (new ConnectionSettings)
            ->setUsername('admin')
            ->setPassword('admin')
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false)
            ->setConnectTimeout(10)
            ->setKeepAliveInterval(60);

        CLI::write("🔄 Menyiapkan koneksi MQTT...", 'yellow');

        while (true) {
            try {
                if (!$mqtt->isConnected()) {
                    CLI::write("🔌 Menghubungkan ke broker MQTT...", 'blue');
                    $mqtt->connect($settings, true);

                    $mqtt->subscribe('solardome/status/esp', function (string $topic, string $message) {
                        file_put_contents(WRITEPATH . 'status_kontaktor.json', $message);
                        CLI::write("✅ Diterima dari [$topic]: $message", 'green');
                    }, 0);
                }

                // loop dengan delay 1 detik agar tidak overload CPU
                $mqtt->loop(true, true);
                sleep(1);

            } catch (\Throwable $e) {
                CLI::error("❌ Terjadi kesalahan: " . $e->getMessage());
                sleep(5); // coba ulang setelah 5 detik jika gagal
            }
        }
    }
}
