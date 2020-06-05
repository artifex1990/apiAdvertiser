<?php
include '../functions.php';

$countriesAdvertiser = json_decode($_POST['cities']);

$advertiserCity = [
    'Tripster' => [],
    'Sputnik8' => []
];

if($countriesAdvertiser->Tripster->id != null) {
    $advertiserCity['Tripster'] = getResource('Tripster', 'cities',['page_size' => 100, 'page' => 1, 'country' => $countriesAdvertiser->Tripster->id], 'page', 'results');
}

if($countriesAdvertiser->Sputnik8->id != null) {
    $advertiserCity['Sputnik8'] = getResource('Sputnik8', 'cities',['limit' => 100, 'page' => 1, 'country_id' => $countriesAdvertiser->Sputnik8->id], 'page');
}


$citySelect = [];
foreach ($advertiserCity as $advertiser => $cities) {
    foreach ($cities as $city) {
        if($advertiser == 'Sputnik8') {
            $citySelect[$city['name']][$advertiser]['id'] = $city['id'];
        }
        if($advertiser == 'Tripster') {
            $citySelect[$city['name_ru']][$advertiser]['id'] = $city['id'];
        }
    }
}

echo json_encode($citySelect);