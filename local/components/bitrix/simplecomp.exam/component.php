<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}

//echo '<pre>'; print_r($arParams); echo '</pre>';

if (!isset($arParams['CLASSIF_IBLOCK_ID'])) {
    $arParams['CLASSIF_IBLOCK_ID'] = '6';
}
if (!isset($arParams['PRODUCTS_IBLOCK_ID'])) {
    $arParams['PRODUCTS_IBLOCK_ID'] = '2';
}
if (!isset($arParams['PROPERTY_CODE'])) {
    $arParams['PROPERTY_CODE'] = 'FIRMA';
}
if (!isset($arParams['TEMPLATE'])) {
    $arParams['TEMPLATE'] = '#SITE_DIR#/products/#SECTION_ID#/#ID#/';
}
if (!isset($arParams['CACHE_TIME'])) {
    $arParams['PRODUCTS_IBLOCK_ID'] = '36000000';
}
$arClassifId = [];
$arClassif = [];
if($this->StartResultCache(false, $USER->GetGroups())) {
    $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = array(
        "IBLOCK_ID" => $arParams['CLASSIF_IBLOCK_ID'],
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
        "ACTIVE" => "Y"
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 50), $arSelect);
    while ($ob = $res->GetNext()) {
        $arClassif[$ob['ID']] = $ob;
        $arClassifId[] = $ob['ID'];
    }
//print_r($arClassif);

    $arSelect = array(
        "NAME",
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        'PROPERTY_' . $arParams['PROPERTY_CODE'] . '',
        "PROPERTY_PRICE",
     "PROPERTY_MATERIAL",
        "DETAIL_PAGE_URL",
        "PROPERTY_ARTNUMBER",
    );
    $arFilter = array(
        "IBLOCK_ID" => $arParams['PRODUCTS_IBLOCK_ID'],
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
        "ACTIVE" => "Y",
        'PROPERTY_' . $arParams['PROPERTY_CODE'] . '' => $arClassifId,
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 50), $arSelect);
    $i = 0;
    while ($ob = $res->GetNext()) {
      // echo '<pre>'; print_r($ob); echo '</pre>';
          foreach ($arClassif as $key => $value) {
            if($value['ID'] == $ob['PROPERTY_' . $arParams['PROPERTY_CODE'] . '_VALUE']) {

                $tovar[$value['NAME']][$i]['NAME'] = $ob['NAME'];
                $tovar[$value['NAME']][$i]['PRICE'] = $ob['PROPERTY_PRICE_VALUE'];
                $tovar[$value['NAME']][$i]['MATERIAL'] = $ob['PROPERTY_MATERIAL_VALUE'];
                $tovar[$value['NAME']][$i]['ARTNUMBER'] = $ob['PROPERTY_ARTNUMBER_VALUE'];
                $tovar[$value['NAME']][$i]['DETAIL_PAGE_URL'] = $ob['DETAIL_PAGE_URL'];
                $i++;
            }
          }
    }
    $arResult['TOVAR'] = $tovar;
    $arResult['COUNT'] = count($arResult['TOVAR']);
   $this->SetResultCacheKeys(array('COUNT'));
    $this->includeComponentTemplate();
}



$APPLICATION->SetTitle(GetMessage('COUNTS'). $arResult['COUNT']);


?>