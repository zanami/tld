<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
	return '';
}

$itemSize = count($arResult);

$strReturn = '
<nav aria-label="Breadcrumb">
	<div class="w">
		<ul class="crumz__wrap flex flex-wrap items-center text-sm text-slate-500">
			<li class="crumz__item">
				<a href="' . SITE_DIR . '" class="crumz__link">
					' . Loc::getMessage("BREADCRUMBS_MAIN_PAGE") . '
				</a>
			</li>
';

foreach ($arResult as $index => $arItem) {
	if (($arResult[$index]["LINK"] <> "")) {
		$strReturn .= '
			<li class="crumz__item">
				<a href="' . $arItem['LINK'] . '" class="crumz__link">
					' . $arItem['TITLE'] . '
				</a>
			</li>
		';
	} else {
		$strReturn .= '
			<li class="crumz__item crumz__item_current">
				' . $arItem['TITLE'] . '
			</li>
		';
	}
}

$strReturn .= '
		</ul>
</nav>
';

return $strReturn;
