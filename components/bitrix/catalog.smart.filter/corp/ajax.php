<?php

use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Text\Encoding;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$APPLICATION->RestartBuffer();
unset($arResult["COMBO"]);

if (!empty($_GET['filter_prop_id']) && array_key_exists('filter_value', $_GET))
{
	// filytr znacheniy svoystva
	$srcPropId = $_GET['filter_prop_id'];
	CUtil::JSPostUnescape();
	$findPropValue = ToUpper($_GET['filter_value']);
	$result = [];
	if (is_array($arResult['ITEMS']))
	{
		$limit = 50; // max iems
		$props = array_filter($arResult['ITEMS'], function ($prop) use ($srcPropId) {
			return $prop['ID'] == $srcPropId;
		});
		if ($prop = reset($props))
		{
			$values = $prop['VALUES'] ?: [];
			if ($findPropValue)
			{
				$values = array_filter($values, function ($value) use ($findPropValue) {
					return mb_strpos($value['UPPER'], $findPropValue) !== false;
				});
			}
			$result = array_values(array_slice($values, 0, $limit));
		}
	}
	echo Json::encode($result);

	return;
}

echo CUtil::PHPToJSObject($arResult, true);