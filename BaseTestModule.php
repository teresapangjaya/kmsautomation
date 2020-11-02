<?php
namespace Facebook\WebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

class BaseTestModule {
    const HOST                  = "http://127.0.0.1:4444/wd/hub";
    public $target;
    public $authPassword;
    public $username;
    public $password;

    protected $driver;
    protected $connectionTimeout;
    protected $requestTimeout;

    protected $smallDelay       = 1;
    protected $mediumDelay      = 3;
    protected $largeDelay       = 5;

    public function __construct($target, $connectionTimeout = 60, $requestTimeout = 60)
    {
        $this->writeLine("Preparing test module...");
        $this->target               = $target;

        $capabilities               = DesiredCapabilities::firefox();
        $this->connectionTimeout    = $connectionTimeout * 1000;
        $this->requestTimeout       = $requestTimeout * 1000;
        $this->driver               = RemoteWebDriver::create(self::HOST, $capabilities, $this->connectionTimeout, $this->requestTimeout);
        $this->writeLine("Open: ".$this->target);
        $this->driver->get($this->target);
    }

    protected function quit(){
        $this->driver->quit();
    }

    protected function writeLine($message){
        echo $message.PHP_EOL;
    }

    protected function addSmallDelay(){
        sleep($this->smallDelay);
    }

    protected function addMediumDelay(){
        sleep($this->mediumDelay);
    }

    protected function addLargeDelay(){
        sleep($this->largeDelay); // kasi delay 5 detik
    }

    protected function executeScript($script){
        $this->driver->executeScript($script); // execute script biaseanya untuk jquery atau javascript
    }

    protected function switchToFrameId($frame_id){
        $this->driver->switchTo()
            ->frame($this->driver->findElement(WebDriverBy::id($frame_id))); // ganti selenium ke frame yang ada di dalem web, gunanya untuk akses element2 yang ada di dalem frame. Ini berdasarkan ID dari frame
    }

    protected function switchToFrameName($frame_id){
        $this->driver->switchTo()  // ganti selenium ke frame yang ada di dalem web, gunanya untuk akses element2 yang ada di dalem frame. Ini berdasarkan Nama
            ->frame($this->driver->findElement(WebDriverBy::name($frame_id)));
    }

    protected function switchToDefaultContent(){
        $this->driver->switchTo()->defaultContent(); // Ganti ke default content
    }

    protected function openDropdown($element){
        $this->driver->getMouse()->mouseMove($this->driver->findElement($element)->getCoordinates()); // untuk bikin efek mouse untuk ngebuka sebuah dropdown (navigation menu)
    }

    protected function clickElementById($text){
        $this->driver->findElement(WebDriverBy::id($text))->click(); // ngebuat efek klik pada element berdasarkan id dari element yang mau di klik
    }

    protected function clickElementByName($text){
        $this->driver->findElement(WebDriverBy::name($text))->click(); // ngebuat efek klik pada element berdasarkan nama dari element yang mau di klik
    }

    protected function fillInputById($text, $value){
        $this->driver->findElement(WebDriverBy::id($text))->sendKeys($value); // isi sebuah input berdasarkan id dari input tersebut
    }

    protected function fillInputByName($text, $value){
        $this->driver->findElement(WebDriverBy::name($text))->sendKeys($value); // isi sebuah input berdasarkan nama dari input tersebut
    }

    protected function chooseDropdownById($text, $value){
        $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::id($text))); // pilih sebuah options pada element select berdasarkan id (input)
        $select->selectByValue($value);
    }

    protected function chooseDropdownByName($text, $value){
        $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::name($text))); // pilih sebuah options pada element select berdasarkan nama (input)
        $select->selectByValue($value);
    }
}