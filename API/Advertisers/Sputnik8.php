<?

namespace API\Advertisers;

/**
 * Class Sputnik8
 * @package API\Advertisers
 *
 * Класс рекламодателя Sputnik8
 */
class Sputnik8 extends Advertiser{

    function __construct($resource, array $parameters = array()) {
        self::init();

        $config = parent::getConfigAdvertiser();

        $query_string = http_build_query($parameters);

        self::setRequestString("https://api.sputnik8.com/v1/$resource?api_key={$config['token']}&username={$config['username']}&$query_string");
    }
}