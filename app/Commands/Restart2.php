<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Repositories\MemoryRepository;
use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\Commands;
use CodeIgniter\CLI\CLI;

class Restart2 extends BaseCommand
{
    protected $group       = 'plc';
    protected $name        = 'plc:restart';
    protected $description = 'Kontrol Restart PLC melalui MQTT';

    private $statusFile;

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->statusFile = WRITEPATH . 'restart_plc.json';
    }

    public function run(array $params)
    {
        date_default_timezone_set('Asia/Makassar'); 
        
        $server   = 'n047f167.ala.us-east-1.emqxsl.com';
        $port     = 8883;
        $clientId = 'solardome_restart_plc-' . uniqid();
        $username = 'admin';
        $password = 'admin';

        $repository = new MemoryRepository();
        $mqtt = new MqttClient($server, $port, $clientId, MqttClient::MQTT_3_1, $repository);

        $settings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false)
            ->setConnectTimeout(10)
            ->setKeepAliveInterval(60);

        try {
            echo "🔌 Connecting to MQTT broker...\n";
            $mqtt->connect($settings, true);
            echo "✅ Connected as client ID: $clientId\n";
        } catch (\Throwable $e) {
            echo "❌ Failed to connect: " . $e->getMessage() . "\n";
            return;
        }

        echo "🚀 Monitoring aktif untuk restart_plc.json...\n";

        while (true) {
            try {
                if (!file_exists($this->statusFile)) {
                    echo "⚠️  File tidak ditemukan, membuat file baru...\n";
                    file_put_contents($this->statusFile, json_encode(['plc' => 'false']));
                }

                $currentState = json_decode(file_get_contents($this->statusFile), true);

                if (!is_array($currentState) || !isset($currentState['plc'])) {
                    echo "❌ Format JSON tidak valid. Reset file...\n";
                    file_put_contents($this->statusFile, json_encode(['plc' => 'false']));
                    continue;
                }

                if ($currentState['plc'] === 'true') {
                    $topic = 'solardome/cntrl/restart/alat';
                    $mqtt->publish($topic, 'true', 0);
                    echo "📤 Dikirim: [$topic] => true\n";

                    // Reset kembali ke false
                    file_put_contents($this->statusFile, json_encode(['plc' => 'false']));
                    echo "🔁 Status dikembalikan ke false.\n";
                }

            } catch (\Throwable $e) {
                echo "❌ Error: " . $e->getMessage() . "\n";
            }

            sleep(3);
        }

        // Tidak pernah disconnect karena loop aktif
    }
}
