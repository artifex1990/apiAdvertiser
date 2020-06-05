<?php
include '../functions.php';

$excursionAdvertiser = json_decode($_POST['excursion']);
$excursionSearch = json_decode($_POST['search']);

$advertiserExcursion = [
    'Tripster' => [],
    'Sputnik8' => []
];

if($excursionAdvertiser->Tripster->id != null) {
    $advertiserExcursion['Tripster'] = getResource('Tripster', 'experiences',['page_size' => 100, 'page' => 1, 'city' => $excursionAdvertiser->Tripster->id], 'page', 'results');
}

if($excursionAdvertiser->Sputnik8->id != null) {
    $advertiserExcursion['Sputnik8'] = getResource('Sputnik8', 'products',['limit' => 100, 'page' => 1, 'city_id' => $excursionAdvertiser->Sputnik8->id], 'page');
}

$searchAdvertiserExcursion = [
    'Tripster' => [],
    'Sputnik8' => []
];

if($excursionSearch !== '') {

    foreach ($advertiserExcursion as $key => $excursies) {
        foreach ($excursies as $num => $excursion) {
            if($key == 'Tripster') {
                if(stripos($excursion['title'], $excursionSearch) !== false ||
                    stripos($excursion['tagline'], $excursionSearch) !== false) {
                    $searchAdvertiserExcursion[$key][] = $excursion;
                }
            }

            if($key == 'Sputnik8') {
                if(stripos($excursion['title'], $excursionSearch) !== false ||
                    stripos($excursion['description'], $excursionSearch) !== false) {
                    $searchAdvertiserExcursion[$key][] = $excursion;
                }
            }
        }
    }

    $advertiserExcursion = $searchAdvertiserExcursion;
}

echo json_encode($advertiserExcursion);
