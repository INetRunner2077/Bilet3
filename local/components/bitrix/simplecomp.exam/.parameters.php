<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "PRODUCTS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "CLASSIF_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_CLASSIF"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "TEMPLATE" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_TEMPLATE"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("CODE"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BN_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
    ),
);