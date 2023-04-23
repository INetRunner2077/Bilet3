<?php
//echo $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH. "/header.php";
IncludeModuleLangFile(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("MyClass", "OnBeforeIBlockElementUpdateHandler"));

AddEventHandler("main", "OnEpilog", array("MyClass", "OnEpilog"));

class MyClass
{


    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == '2' and $arFields['ACTIVE'] == 'N') //echo '<pre>'; print_r($arFields); echo '</pre>';
        {
            $arSelect = array();
            $arFilter = array("IBLOCK_ID" => 2, "ID" => $arFields["ID"]);
            $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields2 = $ob->GetFields();
                $count = $arFields2['SHOW_COUNTER'];
                echo '<pre>';
                print_r($count);
                echo '</pre>';
            }

            if ((int)$count > 2) {
                global $APPLICATION;
                $text = GetMessage('ERROR', array('#COUNT#' => $count));
                $APPLICATION->throwException($text);
                return false;
            }
        }
    }

    public static function OnEpilog()
    {
        if(defined('ERROR_404') and ERROR_404 == 'Y')
        {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH. "/header.php";
            include $_SERVER["DOCUMENT_ROOT"]."/404.php";
            include $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH. "/footer.php";

        CEventLog::Add(array(
       "SEVERITY" => "INFO",
       "AUDIT_TYPE_ID" => "404",
       "MODULE_ID" => "main",
       "DESCRIPTION" => $APPLICATION->GetCurPage(),
       ));

        }


    }




}
