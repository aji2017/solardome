<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Api;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        date_default_timezone_set('Asia/Makassar');
        $apiModel = new \App\Models\Api(); // pastikan namespace benar
        $sensorData = $apiModel->getSensorData();

        // Default status
        $statusKontaktor = 'Tidak aktif';
        $warnaStatus = 'danger';

        // Ambil status dari file JSON
        $file = WRITEPATH . 'status_kontaktor.json';
        if (file_exists($file)) {
            $json = json_decode(file_get_contents($file), true);
            if (isset($json['status']) && $json['status'] === 'ESP-SolarDome Online!') {
                $statusKontaktor = 'Aktif';
                $warnaStatus = 'success';
            }
        }

        $data = [
            'nama_page'        => 'Dashboard',
            'isi'              => 'resource/beranda/beranda',
            'sensor_data'      => $sensorData,
            'kontaktor_status' => $statusKontaktor,
            'kontaktor_warna'  => $warnaStatus
        ];

        echo view('resource/layout/wrapper', $data);
    }
}
