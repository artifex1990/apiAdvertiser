<?

namespace API\Advertisers;

/**
 * Class Tripster
 * @package API\Advertisers
 *
 * Класс рекламодателя Tripster
 */
class Tripster extends Advertiser{

    function __construct($resource, array $parameters = array()) {
        self::init();
        
        $query_string = http_build_query($parameters);

        self::setRequestString("https://experience.tripster.ru/api/$resource/?$query_string");
    }
}