<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('beranda', 'Home::index');
$routes->get('histori', 'Pengaturan::historidata');
$routes->get('kontrol', 'Pengaturan::kontrol');
$routes->post('kontrol/atur', 'Pengaturan::aturkipas');
$routes->post('kontrol/atur1', 'Pengaturan::aturkipas');
$routes->get('alat', 'Pengaturan::alat');
$routes->post('alat/aturalat', 'Pengaturan::aturalat');
$routes->get('esp', 'Pengaturan::restart1');
$routes->get('plc', 'Pengaturan::restart2');
$routes->post('esp/restart', 'Pengaturan::restartesp');
$routes->post('plc/restart', 'Pengaturan::restartplc');
$routes->get('set', 'Pengaturan::set');
$routes->post('set/suhu', 'Pengaturan::atursuhu');
$routes->post('set/kelembapan', 'Pengaturan::aturkelembapan');
$routes->post('set/co2', 'Pengaturan::aturco2');
$routes->get('statkon', 'Pengaturan::statusesp');
$routes->get('ota', 'Pengaturan::ota');