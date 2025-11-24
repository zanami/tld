<?
// get section names elements
foreach($arResult['ITEMS'] as $arItem){
	$arSectionsIDs[] = $arItem['IBLOCK_SECTION_ID'];
}
if($arSectionsIDs){
	$arSectionsIDs = array_unique($arSectionsIDs);
	$arSectionsTmp = CScorp::cacheSection(false, array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arSectionsIDs), false, array('ID', 'NAME'));
	foreach($arSectionsTmp as $arSection){
		$arSections[$arSection['ID']] = $arSection;
	}
}

if(is_array($arResult['ITEMS'])){
	foreach($arResult['ITEMS'] as $i => $arItem){
		$arItem['SECTION_NAME'] = $arSections[$arItem['IBLOCK_SECTION_ID']]['NAME'];
		$arResult['ITEMS'][$i] = $arItem;
	}
}

$arSection  =  [];
if(is_array( $arResult ["SECTION"]["PATH"]) && (count( $arResult ["SECTION"]["PATH"]) > 0)):
   $arSection  = end( $arResult["SECTION"]["PATH"]);
   
   $res  = \CIBlockSection::GetByID(  $arSection [ "ID" ] );
   if ( $ar_res  =  $res ->GetNext())
      $mSection  =  $ar_res;

   if(isset($mSection ["DESCRIPTION"]) && (strlen($mSection ["DESCRIPTION"]) >  0)):
          $arResult["SECTION_DESCRIPTION"] = $mSection["DESCRIPTION"];
   endif;
endif;
?>