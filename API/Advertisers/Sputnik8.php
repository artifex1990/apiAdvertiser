<?

namespace API\Advertisers;

/**
 * Class Sputnik8
 * @package API\Advertisers
 *
 * Класс для работы с API рекламодателя Sputnik8
 */
class Sputnik8 extends Advertiser{

    /**
     * Sputnik8 constructor.
     * @param $resource ресурс где будем искать по параметрам(Например 'experiences' - ресурс с экскурсиями)
     * @param array $parameters параметры для выборки и сортировки в определенном ресурсе
     */
    function __construct($resource, array $parameters = array()) {
        self::init();

        $config = parent::getConfigAdvertiser();

        $query_string = http_build_query($parameters);

        self::setRequestString("https://api.sputnik8.com/v1/$resource?api_key={$config['token']}&username={$config['username']}&$query_string");
    }
}