<?
namespace API\Senders;

/**
 * Class CurlSender
 * @package API\Senders
 *
 * Класс предназначен для отправки запроса с помощью curl
 */
class CurlSender {
    private $advertiser; //поле хранящее определенного рекламодателя
    private $curl_option;

    /**
     * CurlSender constructor.
     * @param $advertiser рекламодатель
     */
    public function __construct($advertiser) {
        $this->advertiser = $advertiser;

        $this->curl_option = [CURLOPT_RETURNTRANSFER => true];

        if($this->advertiser->getHeaderAuth()) {
            $this->curl_option[] = [
                CURLOPT_HTTPHEADER => [
                    'Authorization: Token ' . $this->advertiser->getToken(),
                    'Content-Type: application/json'
                ]
            ];
        }
    }

    /**
     * Функция для получения данных от рекламодателей
     *
     * @return mixed возвращает дессириализованный json ответ от Api рекламодателя
     */
    public function get() {
        $curl = curl_init($this->advertiser->getRequestString());
        
        curl_setopt_array($curl, $this->curl_option);
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        curl_close($curl);
  
        // Декодируем полученный json
        // параметр true для возвращения ассоциативного массива вместо объекта
        return json_decode($results, true);
    }
}