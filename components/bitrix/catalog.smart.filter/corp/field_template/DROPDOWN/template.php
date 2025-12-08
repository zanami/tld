<?

/**
 * Dropdown template
 * @var $arItem;
 */

use Bitrix\Main\Localization\Loc;

?>

<? if ($arItem['DISPLAY_TYPE'] == 'S') : ?>
    <div class="sfltr-label" onclick="smartFilter.toggleValues(this, event)">
        <div class="bxx-select__search">
            <input type="text" class="bxx-select__search-input" data-prop-id="<?= $arItem['ID'] ?>" onkeyup="smartFilter.<?= ($arItem['USE_AJAX'] ? 'searchDropdownItemAjax' : 'searchDropdownItem') ?>(event, this)" placeholder="<?= $arItem["NAME"] ?>">
            <i class="bxx-select__search-icon fa fa-search" aria-hidden="true"></i>
        </div>
        <span class="sfltr-label_close"><i class="icon-close" aria-hidden="true"></i></span>
    </div>
<? else : ?>
    <div class="sfltr-label" onclick="smartFilter.toggleValues(this, event)">
        <span class="sfltr-label_name"><?= $arItem["NAME"] ?></span><?= $arItem['HINT'] ? ', ' . $arItem['HINT'] : '' ?>
        <span class="sfltr-label_value"></span>
        <span class="sfltr-label_close"><i class="icon-close" aria-hidden="true"></i></span>
    </div>
<? endif; ?>
<div class="sfltr-values">
    <div class="bxx-select">
        <div class="bxx-select__items-wrapper">
            <? foreach ($arItem["VALUES"] as $val => $ar) : ?>
                <label class="bxx-select__item <?= $ar["DISABLED"] ? 'disabled' : '' ?> <?= ($ar["DISABLED"] && !$ar["CHECKED"]) ? 'no-clicked' : '' ?>" onclick="smartFilter.clickLabel(event, this)">
                    <input class="bxx-select__item-input" type="checkbox" name="<?= $ar["CONTROL_NAME"] ?>" id="<?= $ar["CONTROL_ID"] ?>" value="<? echo $ar["HTML_VALUE"] ?>" <?= $ar["CHECKED"] ? 'checked="checked"' : '' ?> data-name="<?= $ar["VALUE"] ?>" />
                    <span class="filter-checkmark"></span>
                    <span class="bxx-select__item-name no-select"><?= $ar["VALUE"] ?></span>
                </label>
            <? endforeach; ?>
        </div>

    </div>
</div>