<?
    spl_autoload_register(function (string $classname) {
        require __DIR__ . '\\' . $classname . '.php';
    });
    
    use API\Senders\CurlSender;
    use API\Advertisers\Sputnik8;
    use API\Advertisers\Tripster;

    $tripsterApi = new Tripster('experiences');
    $sputnikv8Api = new Sputnik8('products');
    $curlTripsterSender = new CurlSender($tripsterApi);
    $curlSputnikV8Sender = new CurlSender($sputnikv8Api);
    $arr = array_merge_recursive($curlTripsterSender->get(), $curlSputnikV8Sender->get());
    var_dump($arr);
