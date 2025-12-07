<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Repositories\MemoryRepository;
use Psr\Log\LoggerInterface;
use CodeIgniter\CLI\Commands;

class Kontrol extends BaseCommand
{
    protected $group       = 'kontrol';
    protected $name        = 'kontrol:push';
    protected $description = 'Kontrol ON/OFF melalui MQTT';

    private $statusFile;

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->statusFile = WRITEPATH . 'relay_status.json';
    }

    public function run(array $params)
    {
        date_default_timezone_set('Asia/Makassar');
        
        $server   = 'n047f167.ala.us-east-1.emqxsl.com';
        $port     = 8883;
        $clientId = 'solardome_kontrol-' . uniqid(); // Client ID unik dan tetap
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
            ->setKeepAliveInterval(60); // 🟢 Keep alive aktif

        try {
            echo "🔌 Connecting to MQTT broker...\n";
            $mqtt->connect($settings, true);
            echo "✅ Connected as client ID: $clientId\n";
        } catch (\Throwable $e) {
            echo "❌ Failed to connect: " . $e->getMessage() . "\n";
            return;
        }

        $lastState = [];

        echo "🚀 Starting relay status monitoring loop...\n";

        while (true) {
            try {
                if (!file_exists($this->statusFile)) {
                    echo "⚠️  relay_status.json not found!\n";
                    sleep(3);
                    continue;
                }

                $currentState = json_decode(file_get_contents($this->statusFile), true);

                if (!is_array($currentState)) {
                    echo "❌ JSON invalid or empty\n";
                    sleep(3);
                    continue;
                }

                if ($lastState !== $currentState) {
                    foreach ($currentState as $relay => $status) {
                        if (!isset($lastState[$relay]) || $lastState[$relay] !== $status) {
                            $topic = "solardome/cntrl/{$relay}";
                            $mqtt->publish($topic, $status, 0);
                            echo "📤 [$topic] => $status\n";
                        }
                    }
                    $lastState = $currentState;
                }

            } catch (\Throwable $e) {
                echo "❌ Error in loop: " . $e->getMessage() . "\n";
            }

            sleep(3);
        }

        // Tidak perlu disconnect karena ini loop permanen
    }
}
