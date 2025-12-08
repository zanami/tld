<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arItem */

$limitSearch = 10;
$limitSearchAjax = 100;

$count = count($arItem["VALUES"]);
$arItem['DISPLAY_TYPE'] = $count >= $limitSearch ? 'S' : $arItem['DISPLAY_TYPE'];
$arItem['USE_AJAX'] = $count >= $limitSearchAjax;

\Bitrix\Main\Type\Collection::sortByColumn($arItem['VALUES'], ['CHECKED' => SORT_DESC, 'SORT' => SORT_ASC], null, false, true);
if ($arItem['DISPLAY_TYPE'] === 'S')
{
	$arItem['VALUES'] = array_slice($arItem['VALUES'], 0, $limitSearchAjax, true);
}