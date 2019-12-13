<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Главная страница");
?><div class="notice">
<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
        "AREA_FILE_SHOW" => "sect",
        "AREA_FILE_SUFFIX" => "inc_kem",
        "AREA_FILE_RECURSIVE" => "Y",
        "EDIT_TEMPLATE" => ""
    )
);?>
</div>
<h2>Новинки</h2>
 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"",
	Array(
		"VIEW_MODE" => "BANNER",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"ROTATE_TIMER" => "30",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"IBLOCK_TYPE" => "xmlcatalog",
		"IBLOCK_ID" => "45",
		"DATA_SUFFIX" => "new",
		"ELEMENT_SORT_FIELD" => "timestamp_x",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER2" => "desc",
		"SECTION_URL" => "/kem/e-store/#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "/kem/e-store/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array("CML2_ATTRIBUTES","CML2_TASTE","MAX_PRICE"),
		"OFFERS_FIELD_CODE" => array("NAME",""),
		"OFFERS_PROPERTY_CODE" => array("CML2_TASTE",""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "500",
		"PRICE_CODE" => array($_GLOBALS['CURRENT_CITY']['PROPERTIES']['PRICETYPE']['VALUE']),
	    "ALLOW_SALE" => $_GLOBALS['CURRENT_CITY']['PROPERTIES']['SALEALLOW']['VALUE_XML_ID'],
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array("CML2_TASTE"),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
        "HIDE_EMPTY" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"OFFERS_CART_PROPERTIES" => array("CML2_TASTE"),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"FILTER_NAME" => "",
		"CACHE_FILTER" => "N"
	)
);?>
<h2>Акция</h2>
 <?
 $arrFilter = array('PROPERTY_CML2_PRICEGROUP'=>1223);
 $APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	".default",
	array(
		"VIEW_MODE" => "BANNER",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"ROTATE_TIMER" => "30",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"IBLOCK_TYPE" => "xmlcatalog",
		"IBLOCK_ID" => "45",
		"DATA_SUFFIX" => "customers",
		"ELEMENT_SORT_FIELD" => "shows",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER2" => "desc",
		"SECTION_URL" => "/kem/e-store/#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "/kem/e-store/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
        "ALLOW_SALE" => $_GLOBALS['CURRENT_CITY']['PROPERTIES']['SALEALLOW']['VALUE_XML_ID'],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "CML2_ATTRIBUTES",
			1 => "CML2_TASTE",
			2 => "MAX_PRICE",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_TASTE",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "50",
		"PRICE_CODE" => array(
			0 => $_GLOBALS['CURRENT_CITY']['PROPERTIES']['PRICETYPE']['VALUE'],
		),
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "CML2_ATTRIBUTES",
		),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "1800",
		"CACHE_GROUPS" => "Y",
        "HIDE_EMPTY" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "CML2_TASTE",
		),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"FILTER_NAME" => "arrFilter",
		"CACHE_FILTER" => "N"
	),
	false
);?>
<h2>Распродажа</h2>
 <?php
 $arrFilter = array('PROPERTY_CML2_PRICEGROUP'=>1221);
 $APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"",
	Array(
		"VIEW_MODE" => "BANNER",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"ROTATE_TIMER" => "30",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"IBLOCK_TYPE" => "xmlcatalog",
		"IBLOCK_ID" => "45",
		"DATA_SUFFIX" => "sale",
		"ELEMENT_SORT_FIELD" => "timestamp_x",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER2" => "desc",
		"SECTION_URL" => "/kem/e-store/#SECTION_CODE_PATH#/",
		"DETAIL_URL" => "/kem/e-store/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array("CML2_ATTRIBUTES","CML2_TASTE","MAX_PRICE"),
		"OFFERS_FIELD_CODE" => array("NAME",""),
		"OFFERS_PROPERTY_CODE" => array("CML2_TASTE",""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "timestamp_x",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "50",
		"PRICE_CODE" => array($_GLOBALS['CURRENT_CITY']['PROPERTIES']['PRICETYPE']['VALUE']),
        "ALLOW_SALE" => $_GLOBALS['CURRENT_CITY']['PROPERTIES']['SALEALLOW']['VALUE_XML_ID'],
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_PROPERTIES" => array("CML2_ATTRIBUTES","CML2_TASTE"),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "1800",
		"CACHE_GROUPS" => "Y",
        "HIDE_EMPTY" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"OFFERS_CART_PROPERTIES" => array("CML2_TASTE"),
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"FILTER_NAME" => "arrFilter",
		"CACHE_FILTER" => "N"
	)
);?>

<div class="profit-block">
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "incbottom",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => "standard.php"
	),
	false
);?>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>