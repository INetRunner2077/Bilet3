<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент 71");
?><?$APPLICATION->IncludeComponent(
	"bitrix:simplecomp.exam",
	"",
	Array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CLASSIF_IBLOCK_ID" => "6",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PROPERTY_CODE" => "FIRMA",
		"TEMPLATE" => "#SITE_DIR#/products/#SECTION_ID#/#ID#/"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>