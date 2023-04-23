<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<?
//echo '<pre>'; print_r($arResult['TOVAR']); echo '</pre>';
if((is_countable($arResult['TOVAR'])) && (count($arResult['TOVAR']) > 0)) { ?>
    <ul>

        <? foreach ($arResult['TOVAR'] as $key => $tovar) { ?>

                <li>
                    <b> <?= $key ?> </b>
                </li>
            <? if(count($arResult['TOVAR'][$key]) > 0 ) { ?>
                <ul>
                    <? foreach ($arResult['TOVAR'][$key] as $arTovar) { ?>
                        <li>
                            <?= $arTovar['NAME']; ?> -
                            <?= $arTovar['PRICE'] ?> -
                            <?= $arTovar['MATERIAL'] ?>
                            <?= $arTovar['ARTNUMBER'] ?>
                            <?= '<a href = "'.$arTovar['DETAIL_PAGE_URL'].'"> Детальная страница</a>'; ?>
                        </li>

                    <? } ?>
                </ul>
            <? } ?>
        <? } ?>
    </ul>

<? } ?>
