<?php

IncludeModuleLangFile(__FILE__);

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", array("MyClass", "OnBeforeIBlockElementUpdateHandler"));

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


}
