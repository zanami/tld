<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['GALLERY'] = array();
$arResult['VIDEO'] = array();

if ($arResult['DISPLAY_PROPERTIES']) {
	$photos = $arResult['DISPLAY_PROPERTIES']['PHOTOS']['VALUE'] ?? array();
	if ($photos && is_array($photos)) {
		foreach ($photos as $img) {
			$arPhoto = CFile::GetFileArray($img);
			if (!$arPhoto) {
				continue;
			}

			$arResult['GALLERY'][] = array(
				'DETAIL' => $arPhoto,
				'PREVIEW' => CFile::ResizeImageGet($img, array('width' => 600, 'height' => 400), BX_RESIZE_IMAGE_EXACT, true),
				'THUMB' => CFile::ResizeImageGet($img, array('width' => 75, 'height' => 75), BX_RESIZE_IMAGE_EXACT, true),
				'TITLE' => (strlen($arPhoto['DESCRIPTION']) ? $arPhoto['DESCRIPTION'] : (strlen($arPhoto['TITLE']) ? $arPhoto['TITLE'] : $arResult['NAME'])),
				'ALT' => (strlen($arPhoto['DESCRIPTION']) ? $arPhoto['DESCRIPTION'] : (strlen($arPhoto['ALT']) ? $arPhoto['ALT'] : $arResult['NAME'])),
			);
		}
	}

	foreach ($arResult['DISPLAY_PROPERTIES'] as $i => $arProp) {
		if ($arProp["VALUE"] || strlen($arProp["VALUE"])) {
			if ($arProp['USER_TYPE'] == 'video') {
				if (is_array($arProp['PROPERTY_VALUE_ID']) && count($arProp['PROPERTY_VALUE_ID']) > 1) {
					foreach ($arProp['VALUE'] as $val) {
						if ($val['path']) {
							$arResult['VIDEO'][] = $val;
						}
					}
				} elseif ($arProp['VALUE']['path']) {
					$arResult['VIDEO'][] = $arProp['VALUE'];
				}
				unset($arResult['DISPLAY_PROPERTIES'][$i]);
			}
		}
	}
}
?>
