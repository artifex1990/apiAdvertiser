<?php
include  '../functions.php';

$advertiserCountry = [
    'Tripster' => getResource('Tripster', 'countries',['page_size' => 100, 'page' => 1], 'page', 'results'),
    'Sputnik8' => getResource('Sputnik8', 'countries',['limit' => 100, 'page' => 1], 'page')
];

/**
 * Получаем все страны с двух Api
 */
$countriesSelect = [];
foreach ($advertiserCountry as $advertiser => $countries) {
    foreach ($countries as $country) {
        if($advertiser == 'Sputnik8') {
            $countriesSelect[$country['name']][$advertiser]['id'] = $country['id'];
        }
        if($advertiser == 'Tripster') {
            $countriesSelect[$country['name_ru']][$advertiser]['id'] = $country['id'];
        }
    }
}

echo json_encode($countriesSelect);
