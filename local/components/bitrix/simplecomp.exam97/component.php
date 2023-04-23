<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

if (!Loader::includeModule("iblock")) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}
if (empty($arParams['NEWS_IBLOCK_ID'])) {
    return 'ошибка';
}
if (empty($arParams['EXAM2_PRORERTY'])) {
    return 'ошибка';
}
if (empty($arParams['PROPERTY_UF'])) {
    return 'ошибка';
}

if ($USER->IsAuthorized()) {
    $arResult['COUNT'] = 0;
    $currentUserId = $USER->GetID();
    $currentUserType = CUser::GetList(
        'id',
        'asc',
        array(
            "ID" => $USER->GetID(),
        ),
        array(
            "SELECT" => array(
                $arParams['PROPERTY_UF'],
            ),
        )
    )->Fetch()[$arParams['PROPERTY_UF']];


    if ($this->StartResultCache(false, array($currentUserId, $currentUserType))) {
        $arOrderUser = array("id");
        $sortOrder = "desc";

        $arResult["USERS"] = array();
        $rsUsers = CUser::GetList(
            $arOrderUser,
            $sortOrder,
            array($arParams['PROPERTY_UF'] => $currentUserType),
            array('SELECT' => array('LOGIN', 'ID'))
        ); // выбираем пользователей

        while ($arUser = $rsUsers->GetNext()) {
            $userList[$arUser['ID']] = array('LOGIN' => $arUser['LOGIN']);
            $userListId[] = $arUser['ID'];
        }

        $arNewsAuthor = [];
        $arNewsList = [];
        $arResult["ELEMENTS"] = array();
        $rsElements = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
                'PROPERTY_' . $arParams['EXAM2_PRORERTY'] => $userListId,
            ),
            false,
            false,
            array(
                'NAME',
                'ACTIVE_FROM',
                'ID',
                'IBLOCK_ID',
                'PROPERTY_' . $arParams['EXAM2_PRORERTY'],
            ),
        );

        $arNewsId = [];
        while ($arElement = $rsElements->Fetch()) {
            $arNewsAuthor[$arElement['ID']][] = $arElement['PROPERTY_' . $arParams['EXAM2_PRORERTY'] . "_VALUE"];

            if (empty($arNewsList[$arElement['ID']])) {
                $arNewsList[$arElement['ID']] = $arElement;
            }

            if ($arElement['PRORERTY_' . $arParams['EXAM2_PRORERTY'] . "_VALUE"] != $currentUserId) {
                $arNewsList[$arElement['ID']]['AUTHORS'][] = $arElement['PROPERTY_' . $arParams['EXAM2_PRORERTY'] . "_VALUE"];
            }
        }

        foreach ($arNewsList as $key => $value) {
            if (in_array($currentUserId, $arNewsAuthor[$value['ID']])) {
                continue;
            }

            foreach ($value['AUTHORS'] as $authorId) {
                $userList[$authorId]['NEWS'][] = $value;
                $arNewsId[$value['ID']] = $value['ID'];
            }
        }

        $arResult['AUTHORS'] = $userList;
        $arResult['COUNT'] = count($arNewsId);
        $this->SetResultCacheKeys(array('COUNT'));
        $this->includeComponentTemplate();
    }

    $APPLICATION->SetTitle('Выбранных новостей ' . $arResult['COUNT']);
}
?>