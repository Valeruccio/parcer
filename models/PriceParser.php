<?php
//Собстенно модель нашего парсера
class PriceParser {
    public function getPrice($productUrl) {
        //Запускаем curl
        $curl = curl_init($productUrl);

        //Настраиваем curl так, чтобы ничего лишнего не выводилось
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //Запускаем curl и сохраняем в переменную весь html со страницы
        $html = curl_exec($curl);

        //Завершаем curl
        curl_close($curl);

        //Создаем объект dom
        $dom = new DOMDocument;
        //Отключаем вывод ошибок
        libxml_use_internal_errors(true);

        //Загружаем в dom наш html
        $dom->loadHTML($html);

        //XPath для поиска по дереву
        $xpath = new DOMXPath($dom);

        //Получаем все элементы с вхождением price в класс
        $priceElements = $xpath->query('//*[contains(@class, "price")]');
        $priceElement = false;

        foreach ($priceElements as $element) {
            //Получаем контент их элемента
            $textContent = $element->textContent;
            //Чистим элемент от любых символов кроме цифровых
            $clean = preg_replace('/\D/', '', $textContent);
            //Если хоть что то осталось от строки - скорее всего это цена
            if ($clean) {
                //Бывает так, что ловится мусорный элемент, проверяем чтобы он был больше нуля, ведь товары не бывают бесплатными
                if ((int)$clean > 0) {
                    //Судя по всему это то что нам надо
                    $priceElement = $clean;
                }
            }
        }
        //Есть элемент? Возвращаем его
        if ($priceElement) {
            // Получение текстового содержимого элемента с ценой
            $price = $priceElement;

            return $price . ' ₽';
        } else {
            return 'Цена не найдена';
        }
    }
}