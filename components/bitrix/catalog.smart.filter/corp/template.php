<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}

?>

<div class="sf-duplicate hidden container mx-auto px-4" id="sf-duplicate"></div>

<section class="filter sfltr-wrapper container mx-auto px-4">
    <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get" class="filter-form sfltr row row-clear" id="smartfilter">
        <? foreach ($arResult["HIDDEN"] as $arItem) : ?>
            <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["HTML_VALUE"] ?>" />
        <? endforeach; ?>

<!--        --><?// if ($arResult["SHOW_EXPANDED"]) : ?>
<!--            <div class="sf-openerWrap">-->
<!--                <a class="butnLink sf-opener" href="javascript:void(0)" data-open="--><?php //= Loc::getMessage("STR_FILTER_OPEN") ?><!--" data-close="--><?php //= Loc::getMessage("STR_FILTER_CLOSE") ?><!--" onclick="smartFilter.toggleExpanded()">--><?php //= Loc::getMessage("STR_FILTER_OPEN") ?><!--</a>-->
<!--            </div>-->
<!--        --><?// endif ?>

        <div class="sfltr__fields-block flex flex-wrap gap-4">
            <?
            $ITEMS_COUNTER = 0;
            foreach ($arResult["ITEMS"] as $blockId => $arItem) :
                $ITEMS_COUNTER++;

                if ($arItem["TEMPLATE"]["PATH"] && file_exists($arItem["TEMPLATE"]["PATH"] . 'result_modifier.php')) {
                    include $arItem["TEMPLATE"]["PATH"] . 'result_modifier.php';
                }

            ?>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 sm:flex-1 max-w-96 min-w-64 <?//= $ITEMS_COUNTER > $arParams['MAX_ITEMS_COUNT'] ? 'sfltr-more' : '' ?> sfltr__item">
                    <div class="sfltr-field sfltr-field_<?= $arItem['TEMPLATE']['NAME'] ?> sfltr-field_<?= $arItem["DISPLAY_TYPE"] ?>" data-display-type="<?= $arItem["DISPLAY_TYPE"] ?>" data-property-code="<?= $arItem["CODE"]; ?>" data-template="<?= $arItem['TEMPLATE']['NAME'] ?>" data-combine="<?= $arItem['IS_COMBINE'] ?>" data-name="<?= $arItem["NAME"] ?>">
                        <?
                        if ($arItem["TEMPLATE"]["PATH"]) {
                            //set in result_modifier.php
                            include $arItem["TEMPLATE"]["PATH"] . 'template.php';
                        } else {
                            echo '<pre>';
                            echo 'TEMPLATE FILE NOT FOUND: <nobr><b>' . $arItem["TEMPLATE"]['NAME'] . '</b></nobr>';
                            echo '</pre>';
                        } ?>
                    </div>
                </div>
            <?
            endforeach;
            ?>
        </div>

        <div class="sfltr__button-block hidden">
            <button type="submit" class="sfltr__button _submit" id="set_filter" name="set_filter">
                <span class="sfltr__button-label"><?= Loc::getMessage("STR_FILTER_FILTER_BUTTON") ?></span>
                <div class="sfltr-values_result px-4 py-2" data-value="<?= (int)$arResult["ELEMENT_COUNT"] ?>"><?= Loc::getMessage("STR_FILTER_FILTERED_LABEL") ?>: <span id="modef_num"><?= (int)$arResult["ELEMENT_COUNT"] ?></span></div>
            </button>
            <? if ($arResult["SHOW_EXPANDED"]) : ?>
                <a class="sfltr__button sf-opener" href="javascript:void(0)" data-open="<?= Loc::getMessage("STR_FILTER_OPEN") ?>" data-close="<?= Loc::getMessage("STR_FILTER_CLOSE") ?>" onclick="smartFilter.toggleExpanded()"><?= Loc::getMessage("STR_FILTER_OPEN") ?></a>
            <? endif ?>
            <button type="submit" class="sfltr__button _reset" id="del_filter" name="del_filter"><?= Loc::getMessage("STR_FILTER_FILTER_RESET_BUTTON") ?></button>
        </div>
    </form>
</section>
<script>
    <?
    $arResult["JS_FILTER_PARAMS"]["LANG"] = array(
        'FROM' => Loc::getMessage('CT_BCSF_FILTER_FROM'),
        'TO' => Loc::getMessage('CT_BCSF_FILTER_TO'),
        'VALUES' => Loc::getMessage('STR_FILTER_RESULT_VALUES'),
        'COUNT_PLURAL' => Loc::getMessage('STR_FILTER_COUNT_PLURAL')
    );
    ?>
    /**
     * smart filter object
     * @type {JCSmartFilter}
     */
    var smartFilter;
    (function() {

        function init() {
            smartFilter = new JCSmartFilter('<? echo CUtil::JSEscape($arResult["FORM_ACTION"]) ?>', 'vertical', <?= CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"]) ?>);
        }

        init();
        BX.addCustomEvent('onComponentAjaxHistorySetState', init);

    })();
</script>