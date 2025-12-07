<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Api;
use App\Models\Kontrol;
use CodeIgniter\HTTP\ResponseInterface;

class Pengaturan extends BaseController
{
    protected $statusFile;

    public function __construct()
    {
        $this->statusFile = WRITEPATH . 'relay_status.json';
        $this->statusalatFile = WRITEPATH . 'alat_status.json';
        $this->espFile = WRITEPATH . 'restart_esp.json';
        $this->plcFile = WRITEPATH . 'restart_plc.json';
        $this->configFile = WRITEPATH . 'set_config.json';
    }

    public function historidata()
    {
        date_default_timezone_set('Asia/Makassar');
        $apiModel = new Api();
        $sensorData = $apiModel->getSensorData();
    
        $perPage = 100;
        $currentPage = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($currentPage - 1) * $perPage;
    
        if (isset($sensorData['error'])) {
            $data = [
                'nama_page' => 'Histori Data',
                'sensor_data' => $sensorData,
                'pager' => null,
                'isi' => 'resource/pengaturan/histori',
            ];
            return view('resource/layout/wrapper', $data);
        }
    
        $total = count($sensorData);
        $paginatedData = array_slice($sensorData, $offset, $perPage);
    
        $data = [
            'nama_page' => 'Histori Data',
            'sensor_data' => $paginatedData,
            'pager' => [
                'total' => $total,
                'perPage' => $perPage,
                'currentPage' => $currentPage,
                'totalPages' => ceil($total / $perPage),
            ],
            'isi' => 'resource/pengaturan/histori',
        ];
    
        return view('resource/layout/wrapper', $data);
    }

    public function kontrol()
    {
        $status = [
            'rly1' => 'true',
            'rly2' => 'true',
        ];

        // Load existing status
        if (file_exists($this->statusFile)) {
            $json = file_get_contents($this->statusFile);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $status = array_merge($status, $decoded);
            }
        }

        $data = [
            'nama_page' => 'Kontrol On/Off Kipas',
            'isi'       => 'resource/pengaturan/pengaturan2',
            'status'    => $status,
        ];
        return view('resource/layout/wrapper', $data);
    }

    public function aturkipas()
    {
        $request = service('request');

        $status = [
            'rly1' => $request->getPost('exhaust_status') ? 'false' : 'true',
            'rly2' => $request->getPost('sirkulasi_status') ? 'false' : 'true',
        ];

        file_put_contents($this->statusFile, json_encode($status));

        return redirect()->back();
    }

    public function alat()
    {
        $status = [
            'alat' => 'false',
        ];

        // Load existing status
        if (file_exists($this->statusalatFile)) {
            $json = file_get_contents($this->statusalatFile);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $status = array_merge($status, $decoded);
            }
        }

        $data = [
            'nama_page' => 'Kontrol On/Off Sistem Alat',
            'isi'       => 'resource/pengaturan/pengaturan',
            'status'    => $status,
        ];
        return view('resource/layout/wrapper', $data);
    }
    public function aturalat()
    {
        $request = service('request');

        $status = [
            'alat' => $request->getPost('alat') === '1' ? 'false' : 'true', // Checkbox ON = relay OFF
        ];

        file_put_contents($this->statusalatFile, json_encode($status));

        return redirect()->back();
    }
    public function restart1()
    {
        $status = [
            'esp' => 'false',
        ];

        // Load existing status
        if (file_exists($this->espFile)) {
            $json = file_get_contents($this->espFile);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $status = array_merge($status, $decoded);
            }
        }

        $data = [
            'nama_page' => 'Restart ESP',
            'isi'       => 'resource/pengaturan/restart1',
            'status'    => $status,
        ];
        return view('resource/layout/wrapper', $data);
    }
    public function restartesp()
    {
        $request = service('request');

        file_put_contents($this->espFile, json_encode(['esp' => 'true']));
        return redirect()->back();
    }
    public function restart2()
    {
        $status = [
            'plc' => 'false',
        ];

        // Load existing status
        if (file_exists($this->plcFile)) {
            $json = file_get_contents($this->plcFile);
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $status = array_merge($status, $decoded);
            }
        }

        $data = [
            'nama_page' => 'Restart PLC',
            'isi'       => 'resource/pengaturan/restart2',
            'status'    => $status,
        ];
        return view('resource/layout/wrapper', $data);
    }
    public function restartplc()
    {
        $request = service('request');

        file_put_contents($this->plcFile, json_encode(['plc' => 'true']));
        return redirect()->back();
    }

    public function set()
    {
        $config = file_exists($this->configFile)
            ? json_decode(file_get_contents($this->configFile), true)
            : ['suhu' => 0, 'kelembapan' => 0, 'co2' => 0];

        $data = [
            'nama_page' => 'Setting Ketentuan',
            'isi' => 'resource/pengaturan/ketentuan',
            'suhu' => $config['suhu'],
            'kelembapan' => $config['kelembapan'],
            'co2' => $config['co2']
        ];

        return view('resource/layout/wrapper', $data);
    }

    private function saveConfig($key, $value)
    {
        $config = file_exists($this->configFile)
            ? json_decode(file_get_contents($this->configFile), true)
            : [];

        $config[$key] = $value;
        file_put_contents($this->configFile, json_encode($config));
    }

    public function atursuhu()
    {
        $value = $this->request->getPost('suhu');
        $this->saveConfig('suhu', $value);
        return redirect()->to(base_url('set'));
    }

    public function aturkelembapan()
    {
        $value = $this->request->getPost('kelembapan');
        $this->saveConfig('kelembapan', $value);
        return redirect()->to(base_url('set'));
    }

    public function aturco2()
    {
        $value = $this->request->getPost('co2');
        $this->saveConfig('co2', $value);
        return redirect()->to(base_url('set'));
    }

    public function statusesp()
    {
        $status = '{}';
        $file = WRITEPATH . 'status_kontaktor.json';

        if (file_exists($file)) {
            $status = file_get_contents($file);
        }

        $data = [
            'nama_page' => 'Status Kontaktor',
            'isi'       => 'resource/pengaturan/statusesp',
            'status'    => json_decode($status, true),
        ];
        return view('resource/layout/wrapper', $data);
    }

    public function ota(){
        $data = [
            'nama_page' => 'OTA',
            'isi'       => 'resource/pengaturan/ota',
        ];
        return view('resource/layout/wrapper', $data);
    }
}
