<?

header('Content-Type: text/xml; charset=windows-1251');

$doman = 'http://atletera.ru';
$protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
$adress = $protocol.'://'.$_SERVER['SERVER_NAME'];


$yandex = file_get_contents(__DIR__.'/bitrix/catalog_export/yandex_goods.php');


$search = '<!DOCTYPE';


$pos = strpos($yandex, $search);

$yandex = substr()

echo $yandex;
die();


$yandex = str_replace($doman, $adress ,$yandex);	


//header('Content-Type: text/xml');

echo $yandex;
die();