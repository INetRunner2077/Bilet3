<?php
if(isset($arParams['CANONICAL'])) {

    $arSelect = Array("PROPERTY_GET", "*");
    $arFilter = Array("IBLOCK_ID"=>$arParams['CANONICAL'], "PROPERTY_GET"=>$arResult['ID']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->GetNextElement()){

        $arResult['NAME_CANONICAL'] = ($ob->GetFields()['NAME']);
      $this->__component->SetResultCacheKeys(array('NAME_CANONICAL'));
    }


}