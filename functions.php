<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

spl_autoload_register(function (string $classname) {
    include __DIR__ . '\\' . $classname . '.php';
});

use API\Senders\BitrixSender;
use API\Advertisers\Sputnik8;
use API\Advertisers\Tripster;

function getResource($advertiser, $resource, $parameters, $paginationKey, $valRes = '') {
    $queryAdvertiser = [];
    $advertiser = 'API\Advertisers' . '\\' . $advertiser;

    while (true) {
        $advertiserRequest = new $advertiser($resource, $parameters);
        $advertiserGet = (new BitrixSender($advertiserRequest))->get();
        $advertiserGet = ($valRes != '') ? $advertiserGet[$valRes] : $advertiserGet;
        if (count($advertiserGet) == 0) {
            break;
        } else {
            $queryAdvertiser = array_merge($queryAdvertiser, $advertiserGet);
            $parameters[$paginationKey]++;
        }
    }

    return $queryAdvertiser;
}