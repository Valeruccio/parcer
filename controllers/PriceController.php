<?php
//Подключаем модель PriceParser
require_once 'models/PriceParser.php';

class PriceController {
    /**
     * @param $productUrl string ссылка на товар
     */
    public function getPrice($productUrl) {
        //Собственно передаем в модель парсера ссылку на товар
        $priceParser = new PriceParser();
        //Переменная price будет использоваться для вывода в подключенном документе view
        $price = $priceParser->getPrice($productUrl);

        include 'views/view.php';
    }
}