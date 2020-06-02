<?

namespace API\Advertisers;

/**
 * Class Tripster
 * @package API\Advertisers
 *
 * Класс для работы с API рекламодателя Tripster
 */
class Tripster extends Advertiser{

    /**
     * Tripster constructor.
     * @param $resource ресурс где будем искать по параметрам(Например 'experiences' - ресурс с экскурсиями)
     * @param array $parameters параметры для выборки и сортировки в определенном ресурсе
     */
    function __construct($resource, array $parameters = array()) {
        self::init();
        
        $query_string = http_build_query($parameters);

        self::setRequestString("https://experience.tripster.ru/api/$resource/?$query_string");
    }
}