<?

namespace API\Advertisers;
/**
 * Class Advertiser
 * @package API\Advertisers
 *
 * Общий шаблон для классов рекламодателей
 */
abstract class Advertiser{
    private $request;
    private $classname;
    private $config;

    protected function init() {
        $this->classname = (new \ReflectionClass(get_class($this)))->getShortName();
        $this->config = (include(__DIR__ . '/../../config.php'))[$this->classname];
    }

    protected function getConfigAdvertiser() {
        return $this->config;
    }

    public function getToken() {
        return $this->config['token'];
    }

    public function getHeaderAuth() {
        return $this->config['headerAuth'];
    }

    public function getRequestString() {
        return $this->request;
    }

    protected function setRequestString(string $req) {
        $this->request = $req;
    }
}