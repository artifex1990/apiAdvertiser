<?
namespace API\Senders;

use Bitrix\Main\Web\HttpClient;

/**
 * Class CurlSender
 * @package API\Senders
 *
 * Класс предназначен для отправки запроса с помощью HttpClient
 */
class BitrixSender {
    private $advertiser; //поле хранящее определенного рекламодателя
    private $httpClient;

    /**
     * CurlSender constructor.
     * @param $advertiser рекламодатель
     */
    public function __construct($advertiser) {
        $this->advertiser = $advertiser;

        $this->httpClient = new HttpClient();

        if($this->advertiser->getHeaderAuth()) {
            $this->httpClient->setHeader('Authorization', $this->advertiser->getToken(), true);
        }

        $this->httpClient->setHeader('Content-Type', 'application/json', true);
    }

    /**
     * Функция для получения данных от рекламодателей
     *
     * @return mixed возвращает дессириализованный json ответ от Api рекламодателя
     */
    public function get() {
        return json_decode($this->httpClient->get($this->advertiser->getRequestString()), true);
    }
}