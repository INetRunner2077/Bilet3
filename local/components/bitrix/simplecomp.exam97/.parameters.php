<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
            'PARENT' => 'BASE',
		),
        "EXAM2_PRORERTY" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_PRORERTY"),
            "TYPE" => "STRING",
            'PARENT' => 'BASE',
        ),
        "PROPERTY_UF" => array(
            "NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_PROPERTY_UF"),
            "TYPE" => "STRING",
            'PARENT' => 'BASE',
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),

	),
);