<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

global $APPLICATION;

echo 'HELLOOOOOOOO';
//delayed function must return a string
if (empty($arResult)) {
	return '';
}

$itemSize = count($arResult);

$strReturn = '
<div class="crumz crumz_gray" id="navigation">
	<div class="w">
		<ul class="crumz__wrap">
			<li class="crumz__item">
				<a href="' . SITE_DIR . '" class="crumz__link">
					<span class="crumz__text">' . Loc::getMessage("BREADCRUMBS_MAIN_PAGE") . '</span>
				</a>
			</li>
';

foreach ($arResult as $index => $arItem) {
	if (($arResult[$index]["LINK"] <> "") && ($index != $itemSize - 1)) {
		$strReturn .= '
			<li class="crumz__item">
				<a href="' . $arItem['LINK'] . '" class="crumz__link">
					<span class="crumz__text">' . $arItem['TITLE'] . '</span>
				</a>
			</li>
		';
	} else {
		$strReturn .= '
			<li class="crumz__item crumz__item_current">
				<span class="crumz__text crumz__text_current">' . $arItem['TITLE'] . '</span>
			</li>
		';
	}
}

$strReturn .= '
		</ul>
	</div>
</div>
';

return $strReturn;
