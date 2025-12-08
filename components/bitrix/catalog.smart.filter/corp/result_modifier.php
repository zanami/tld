<?php
/**
 * @var $arParams
 * @var $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\IO\File;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;

Loc::loadMessages(__DIR__ . '/template.php');

if ($arParams["FORM_ACTION_ON_SECTION_PAGE"] === "Y" && $arParams["SECTION_CODE"] || $arParams['SECTION_ID'])
{
	$sectionId = CIBlockFindTools::GetSectionID($arParams["SECTION_ID"], $arParams["SECTION_CODE"], [
		'IBLOCK_ID' => $arParams["IBLOCK_ID"],
	]);
	$rsSection = CIBlockSection::GetList(
		Array("SORT" => "ASC"),
		array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ID" => $sectionId,
		),
		$bIncCnt = false,
		$arSelectFields = Array("ID", "SECTION_PAGE_URL"),
		array('nTopCount' => 1)
	);
	if ($arSection = $rsSection->GetNext())
	{
		$arResult["FORM_ACTION"] = $arSection["SECTION_PAGE_URL"];
	}
}

$numExpanded = count(array_filter($arResult['ITEMS'], function ($item) {
	return $item['DISPLAY_EXPANDED'] == 'Y';
}));

$arParams["MAX_ITEMS_COUNT"] = min($numExpanded, $arParams["MAX_ITEMS_COUNT"] ? $arParams["MAX_ITEMS_COUNT"] : 6);


//filter empty fields

$arResult["ITEMS"] = array_filter($arResult["ITEMS"], function($arItem){
	if (isset($arItem["VALUES"]["MAX"]) && !isset($arItem["VALUES"]["MAX"]["VALUE"]))
	{
		return false;
	}
	if (isset($arItem["VALUES"]["MIN"]) && !isset($arItem["VALUES"]["MIN"]["VALUE"]))
	{
		return false;
	}
	return $arItem['ID'] && !empty($arItem["VALUES"]) &&
				!( $arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) );
});
$arResult["SHOW_EXPANDED"] = count($arResult["ITEMS"]) > $arParams["MAX_ITEMS_COUNT"];

$arResult["ELEMENT_COUNT"] = CIBlockElement::GetList(array(), $this->__component->makeFilter($arParams['FILTER_NAME']), array(), false);

$getTemplateData = function ($templateName) use (&$arResult) {
	$template = array('NAME' => $templateName);

	$template['PATH'] = \Bitrix\Main\IO\Path::normalize(__DIR__.'/field_template/'.$templateName.'/') . '/';
	$template['ASSETS_PATH'] = '/field_template/'.$templateName.'/';

	if (File::isFileExists($template['PATH'].'template.php')) {
		//assets of field template
		if (File::isFileExists($template['PATH'].'style.css') &&
			array_search($template['ASSETS_PATH'].'style.css', $arResult["ADDITIONAL_STYLES"]) === false )
			$arResult["ADDITIONAL_STYLES"][] = $template['ASSETS_PATH'].'style.css';

		if (File::isFileExists($template['PATH'].'script.js') &&
			array_search($template['ASSETS_PATH'].'script.css', $arResult["ADDITIONAL_SCRIPTS"]) === false )
			$arResult["ADDITIONAL_SCRIPTS"][] = $template['ASSETS_PATH'].'script.js';
	} else {
		$template['PATH'] = false;
	}
	return $template;
};

/**
 * Field Template Settings
 */
$customTemplateByDisplayType = array(
	"NUMBERS" => array("A","B"),
	"DROPDOWN" => array("R", 'G', 'F',"P", "K", "H", "K1"),
	"CALENDAR" => "U",
);

//for custom templates
$customTemplateByCode = array(
	//"DROPDOWN" => array("deal_type", "rooms")
);
//combine fields in 1 custom template by code
$customCombinedTemplates = array(
);

$arResult["ADDITIONAL_STYLES"] = array();
$arResult["ADDITIONAL_SCRIPTS"] = array();
$arNewItems = $properties = $propertyHints = [];

foreach ($arResult["ITEMS"] as &$arItem ) {
	//add hint
	if (array_key_exists($arItem['ID'], $propertyHints))
	{
		$arItem['HINT'] = $propertyHints[$arItem['ID']];
	}

	foreach ($customCombinedTemplates as $template => &$code) {
		if ( (is_array($code) && array_search($arItem["CODE"], $code) !== false )
			|| (is_string($code) && $arItem["CODE"] == $code) ) {
			$arItem['COMBINED_TEMPLATE'] = $template;
		}
	}
	if ($arItem['COMBINED_TEMPLATE']) {
		if ($arNewItems[$arItem['COMBINED_TEMPLATE']]) {
			$arNewItems[$arItem['COMBINED_TEMPLATE']]['FIELDS'][$arItem['CODE']] = $arItem;
			$arNewItems[$arItem['COMBINED_TEMPLATE']]['ID'] .= '_'.$arItem['ID'];
		} else {
			$arNewItems[$arItem['COMBINED_TEMPLATE']] = array(
				"TEMPLATE" => $getTemplateData($arItem['COMBINED_TEMPLATE']),
				"IS_COMBINE" => true,
				"CODE" => $arItem['COMBINED_TEMPLATE'],
				'ID' => $arItem['ID'],

				"FIELDS" => array(
					$arItem['CODE'] => $arItem
				)
			);
		}
	} else {
		$fieldTemplate = '';
		foreach ($customTemplateByDisplayType as $template => $type) {
			if ( (is_array($type) && array_search($arItem["DISPLAY_TYPE"], $type) !== false ) ||
				(is_string($type) && $arItem["DISPLAY_TYPE"] == $type) ) $fieldTemplate = $template;
		}

		foreach ($customTemplateByCode ?: [] as $template => $code) {
			if ( (is_array($code) && array_search($arItem["CODE"], $code) !== false ) ||
				(is_string($code) && $arItem["CODE"] == $code) ) $fieldTemplate = $template;
		}

		foreach ($customTemplateByUserType ?: [] as $template => $userType) {
			if ( (is_array($userType) && array_search($arItem["USER_TYPE"], $userType) !== false ) ||
				(is_string($userType) && $arItem["USER_TYPE"] == $userType) ) $fieldTemplate = $template;
		}

		//Default Template
		if (!$fieldTemplate) $fieldTemplate = "DROPDOWN";

		if ($fieldTemplate === 'NUMBERS') {
			$arItem["VALUES"]["MIN"]["HTML_VALUE"] = $arItem["VALUES"]["MIN"]["HTML_VALUE"] ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : '';
			$arItem["VALUES"]["MAX"]["HTML_VALUE"] = $arItem["VALUES"]["MAX"]["HTML_VALUE"] ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : '';
		}

		$arItem['TEMPLATE'] = $getTemplateData($fieldTemplate);
		$arNewItems[] = $arItem;
	}
}
$arResult['ITEMS'] = $arNewItems;

array_walk($arResult['ITEMS'], function (&$v, $index) {
	$v['SORT'] = $index;
});
\Bitrix\Main\Type\Collection::sortByColumn($arResult['ITEMS'], ['DISPLAY_EXPANDED' => SORT_DESC, 'SORT' => [SORT_NUMERIC, SORT_ASC]]);

$this->__component->setResultCacheKeys(array(
	'ADDITIONAL_STYLES',
	'ADDITIONAL_SCRIPTS'
));

//FIX add selected cards view
$addParams = [
	'view' => 1,
	'sort' => 1,
	'order' => 1,
];
foreach ($addParams as $k)
{
	if (empty($_REQUEST[$k]))
	{
		unset($addParams[$k]);
	}
}
//if (count($addParams) > 0)
//{
//	$fixUrlsKeys = [
//		'FILTER_URL',
//	    'FILTER_AJAX_URL',
//	    'SEF_SET_FILTER_URL',
//	    'SEF_DEL_FILTER_URL',
//	    'FORM_ACTION',
//	];
//	foreach ([&$arResult, &$arResult['JS_FILTER_PARAMS']] as &$dest)
//	{
//		foreach ($fixUrlsKeys as $k)
//		{
//			if (!empty($dest[$k]))
//			{
//				$uri = new Uri($dest[$k]);
//				$params = [];
//				foreach ($addParams as $paramKey => $v)
//				{
//					$params[$paramKey] = $_REQUEST[$paramKey];
//				}
//				$uri->addParams($params);
//				$dest[$k] = $uri->getUri();
//			}
//		}
//	}
//
//	//\Bitrix\Main\Diag\Debug::writeToFile($arResult, __FILE__);
//}
