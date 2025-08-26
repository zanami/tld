<?
use Bitrix\Iblock;

$arSklad = array();
$arSklad["ITEMS"] = array();
$arSklad["ELEMENTS"] = array();
$arSelect = array_merge($arParams["FIELD_CODE"], array(
	"ID",
	"IBLOCK_ID",
	"IBLOCK_SECTION_ID",
	"NAME",
	"ACTIVE_FROM",
	"TIMESTAMP_X",
	"DETAIL_PAGE_URL",
	"LIST_PAGE_URL",
	"DETAIL_TEXT",
	"DETAIL_TEXT_TYPE",
	"PREVIEW_TEXT",
	"PREVIEW_TEXT_TYPE",
	"PREVIEW_PICTURE",
));
if ($arResult['ITEMS']) {$topCount = $arParams["NEWS_COUNT"] - count($arResult['ITEMS']);}
if ($topCount) {
	$arFilter =array('IBLOCK_ID'=>28,'!PROPERTY_SHOW_ON_INDEX_PAGE' => false);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>$topCount), $arSelect);
	while($obElement = $res->GetNextElement())   {
	   $arItem = $obElement->GetFields();
	   $id = (int)$arItem['ID'];
	   $arItem["PROPERTIES"] = $obElement->GetProperties();
	   $arSklad["ITEMS"][$id] = $arItem;
	   $arSklad["ELEMENTS"][] = $id;
	}
	foreach ($arSklad["ITEMS"] as &$arItem)
	{
		foreach ($arParams["PROPERTY_CODE"] as $pid)
		{
			$prop = &$arItem["PROPERTIES"][$pid];
			if (
				(is_array($prop["VALUE"]) && count($prop["VALUE"]) > 0)
				|| (!is_array($prop["VALUE"]) && strlen($prop["VALUE"]) > 0)
			)
			{
				$arItem["DISPLAY_PROPERTIES"][$pid] = CIBlockFormatProperties::GetDisplayValue($arItem, $prop, "news_out");
			}
		}

		$ipropValues = new Iblock\InheritedProperty\ElementValues($arItem["IBLOCK_ID"], $arItem["ID"]);
		$arItem["IPROPERTY_VALUES"] = $ipropValues->getValues();
		Iblock\Component\Tools::getFieldImageData(
			$arItem,
			array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
			Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
			'IPROPERTY_VALUES'
		);
		foreach($arParams["FIELD_CODE"] as $code)
			if(array_key_exists($code, $arItem)) {$arItem["FIELDS"][$code] = $arItem[$code];}
	}
}

$arResult['ITEMS'] = $arResult['ITEMS'] + $arSklad["ITEMS"];
$arResult['ELEMENTS'] = array_merge($arResult['ELEMENTS'], $arSklad["ELEMENTS"]);
//Bitrix\Main\Diag\Debug::dumpToFile($arSklad['ELEMENTS'], $varName = 'skle');

$arSectionsFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y');
if($arParams['PARENT_SECTION']){
	$arSectionsFilter = array_merge($arSectionsFilter, array('SECTION_ID' => $arParams['PARENT_SECTION'], '>DEPTH_LEVEL' => '1'));
}
else{
	$arSectionsFilter['DEPTH_LEVEL'] = '1';
}
$arResult['SECTIONS'] = CCache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), $arSectionsFilter, false, array('ID', 'NAME', 'IBLOCK_ID', 'DEPTH_LEVEL', 'SECTION_PAGE_URL', 'PICTURE', 'DETAIL_PICTURE', 'UF_INFOTEXT', 'DESCRIPTION'));

//Bitrix\Main\Diag\Debug::dumpToFile(array_keys($arResult['ITEMS']), $varName = 'cati');
//Bitrix\Main\Diag\Debug::dumpToFile($arResult['ELEMENTS'], $varName = 'cate');

// get goods with property SHOW_ON_INDEX_PAGE == Y
if($arResult['ITEMS']){
	$arGoodsSectionsIDs = array();
	$j=0;
	//Bitrix\Main\Diag\Debug::dumpToFile($arResult['ITEMS'][266]['ID'], $varName = 'pre266');
	foreach($arResult['ITEMS'] as $i => &$arItem){
		//Bitrix\Main\Diag\Debug::dumpToFile(array($arItem['ID'], $arResult['ITEMS'][$i]['ID']), $varName = $i);
								   //Bitrix\Main\Diag\Debug::dumpToFile(array_keys($arResult['ITEMS']), $varName = "step".$i);
								   //		if($i != $arItem['ID']) Bitrix\Main\Diag\Debug::dumpToFile($arItem, $varName = "dump".$i);
		//Bitrix\Main\Diag\Debug::dumpToFile(array($arItem['ID'],$arItem['NAME']), $varName = '');
		if($arItem['PROPERTIES']['SHOW_ON_INDEX_PAGE']['VALUE_XML_ID'] !== 'YES'){
			unset($arResult['ITEMS'][$i]);
			unset($arResult['ELEMENTS'][$j]);
		}
		else{
			$arGoodsSectionsIDs[] = $arItem["IBLOCK_SECTION_ID"];
		}

	$j++;
	}
	//Bitrix\Main\Diag\Debug::dumpToFile($arResult['ITEMS'][266]['ID'], $varName = 'mid266');

	// get good`s section name
	if($arGoodsSectionsIDs){
		$arGoodsSectionsIDs = array_unique($arGoodsSectionsIDs);
		$arGoodsSections = CCache::CIBLockSection_GetList(array('CACHE' => array('TAG' => CCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N', 'RESULT' => array('NAME'))), array('ID' => $arGoodSectionsIDs), false, array('ID', 'NAME'));
		if($arGoodsSections){
			foreach($arResult['ITEMS'] as $i => &$arItem){
				$arResult['ITEMS'][$i]['SECTION_NAME'] = ($arGoodsSections[$arItem["IBLOCK_SECTION_ID"]] ? $arGoodsSections[$arItem["IBLOCK_SECTION_ID"]] : "Техника на складе");
			}
		}
	}
}
Bitrix\Main\Diag\Debug::dumpToFile($arResult['ITEMS'][266], $varName = 'post266');


?>