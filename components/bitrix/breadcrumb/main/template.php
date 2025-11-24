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
		<ul class="flex flex-wrap items-center text-slate-500">
			<li class="crumz__item">
				<a href="' . SITE_DIR . '">
					' . Loc::getMessage("BREADCRUMBS_MAIN_PAGE") . '
				</a>
			</li>
';

foreach ($arResult as $index => $arItem) {
	if (($arResult[$index]["LINK"] <> "")) {
		$strReturn .= '
			<li class="crumz__item">
				<a href="' . $arItem['LINK'] . '">
					' . $arItem['TITLE'] . '
				</a>
			</li>
		';
	} else {
		$strReturn .= '
			<li class="crumz__item">
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
