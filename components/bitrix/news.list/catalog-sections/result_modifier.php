<?
// get all subsections of PARENT_SECTION or root sections
$arSectionsFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y');
if($arParams['PARENT_SECTION']){
	$arSectionsFilter = array_merge($arSectionsFilter, array('SECTION_ID' => $arParams['PARENT_SECTION'], '>DEPTH_LEVEL' => '1'));
}
else{
	$arSectionsFilter['DEPTH_LEVEL'] = '1';
}
$arResult['SECTIONS'] = CCache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), $arSectionsFilter, false, array('ID', 'NAME', 'IBLOCK_ID', 'DEPTH_LEVEL', 'SECTION_PAGE_URL', 'PICTURE', 'DETAIL_PICTURE', 'UF_INFOTEXT', 'DESCRIPTION'));


// === ВОТ ТУТ ДОБАВЛЯЕМ ФИЛЬТР ===
if (($arParams['SECTIONS_VIEW'] ?? '') === 'list') {

    // нужные ID разделов
    $allowedIds = [37, 34, 33, 35, 17, 19]; // ← свои


    $byId = [];
    foreach ($arResult['SECTIONS'] as $s) {
        $byId[(int)$s['ID']] = $s;
    }

    $ordered = [];
    foreach ($allowedIds as $id) {
        $id = (int)$id;
        if (isset($byId[$id])) {
            $ordered[] = $byId[$id];
        }
    }

    $arResult['SECTIONS'] = $ordered;
}

unset($arResult['ITEMS']);
?>