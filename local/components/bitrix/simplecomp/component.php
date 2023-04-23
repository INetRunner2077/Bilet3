<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}

if (!isset($arParams['PRODUCTS_IBLOCK_ID'])) {
    $arParams['PRODUCTS_IBLOCK_ID'] = '0';
}
if (!isset($arParams['NEWS_IBLOCK_ID'])) {
    $arParams['NEWS_IBLOCK_ID'] = '0';
}
if (!isset($arParams['CACHE_TIME'])) {
    $arParams['PRODUCTS_IBLOCK_ID'] = '36000000';
}

if($this->StartResultCache())
{
    $arNews = array();
    $arNewsId = array();
    $objNews = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
            'ACTIVE' => 'Y'
        ),
        false,
        false,
        array(
            'NAME',
            'ACTIVE_FROM',
            'ID'
        ),
    );

    while($ar_fields = $objNews->GetNext())
    {
        $arNewsId[] = $ar_fields['ID'];
        $arNews[$ar_fields['ID']] = $ar_fields;
    }

    $arSections = array();
    $arSectionId = array();

    $objSection = CIBlockSection::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            $arParams['PRODUCTS_IBLOCK_ID_PROPERTY'] => $arNewsId,
        ),
        true,
        array(
            'NAME',
            'IBLOCK_ID',
            'ID',
            $arParams['PRODUCTS_IBLOCK_ID_PROPERTY'],
        ),
        false,
    );

    while($arSectionCatalog = $objSection->GetNext())
    {
        $arSectionId[] = $arSectionCatalog['ID'];
        $arSections[$arSectionCatalog['ID']] = $arSectionCatalog;
    }

    $arProduct = array();
    $arProductId = array();
    $objProduct = CIBlockElement::getList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            'SECTION_ID' => $arSectionId,
        ),
        false,
        false,
        array(
            'NAME',
            'IBLOCK_SECTION_ID',
            'PROPERTY_ARTNUMBER',
            'PROPERTY_PRICE',
            'PROPERTY_MATERIAL',
            'ACTIVE_FROM',
            'ID'
        ),
    );
    $arResult['PRODUCT_CNT'] = 0;
    while($arProduct = $objProduct->GetNext())
    {
        $arResult['PRODUCT_CNT'] ++;
        foreach ($arSections[$arProduct['IBLOCK_SECTION_ID']][$arParams['PRODUCTS_IBLOCK_ID_PROPERTY']] as $list)
        {
            $arNews[$list]['PRODUCTS'][] = $arProduct;
        }
    }
    //echo '<pre>'; print_r($arNews);  echo '<pre>';

    foreach ($arSections as $arSection){
        foreach ($arSection[$arParams['PRODUCTS_IBLOCK_ID_PROPERTY']] as $id) {
            $arNews[$id]['SECTIONS'][] = $arSection['NAME'];
        }

    }

    $arResult['NEWS'] = $arNews;
    $this->SetResultCacheKeys(array('PRODUCT_CNT'));
    $this->includeComponentTemplate();

}
$APPLICATION->SetTitle(GetMessage('COUNT'). $arResult['PRODUCT_CNT']);

?>