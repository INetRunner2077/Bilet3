<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "PRODUCTS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "NEWS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_NEWS"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "PRODUCTS_IBLOCK_ID_PROPERTY" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_SECTION"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
    ),
);