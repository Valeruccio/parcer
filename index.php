<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Парсинг цены товара</title>
</head>
<body>
<form action="index.php" method="post">
    <label for="productUrl">Ссылка на товар:</label>
    <input type="text" id="productUrl" name="productUrl" required>
    <button type="submit">Получить цену</button>
</form>

<?php
//Получаем через POST запрос ссылку на товар
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productUrl = $_POST['productUrl'];
    //Подключаем контроллер
    require_once 'controllers/PriceController.php';
    $priceController = new PriceController();
    //Запускаем метод getPrice и передаем ему ссылку на товар
    $priceController->getPrice($productUrl);
}
?>
</body>
</html>