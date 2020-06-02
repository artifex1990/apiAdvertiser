<?
namespace API\Senders;

/**
 * Class CurlSender
 * @package API\Senders
 *
 * Класс предназначе для отправки запроса с помощью curl
 */
class CurlSender {
    private $advertiser; //поле хранящее в данные по рекламодателю
  
    public function __construct($advertiser) {
        $this->advertiser = $advertiser;
    }
  
    // GET-запрос на получение данных от рекламодателя
    public function get() {
        $curl = curl_init($this->advertiser->getRequestString());

        $curl_option = [CURLOPT_RETURNTRANSFER => true];

        if($this->advertiser->getConfigAdvertiser()['headerAuth']) {
            $curl_option[] = [
                CURLOPT_HTTPHEADER => [
                    'Authorization: Token ' . $this->advertiser->getConfigAdvertiser()['token'],
                    'Content-Type: application/json'
                ]
            ];
        }
        
        curl_setopt_array($curl, $curl_option);
  
        // Получаем данные и закрывааем соединение
        $results = curl_exec($curl);
        curl_close($curl);
  
        // Декодируем полученный json
        // параметр true для возвращения ассоциативного массива вместо объекта
        return json_decode($results, true);
    }
}