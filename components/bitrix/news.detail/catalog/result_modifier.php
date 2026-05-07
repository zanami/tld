<?

if (CModule::IncludeModule("iblock")):
    $elementID = $arResult['ID'];
    $iblockId = $arResult['IBLOCK_ID'];
    $arrayLinks = array();
    $linkedArray = CIBlockElement::GetList(
        Array("ID" => "ASC"),
        Array("IBLOCK_ID" => $iblockId, "ID" => $elementID),
        false,
        false,
        Array(
            'ID',
            'PROPERTY_RELATED_ARTICLES'
        )
    );
    while ($ar_fields = $linkedArray->Fetch()) {
        if(!empty($ar_fields['PROPERTY_RELATED_ARTICLES_VALUE'])) {$arrayLinks[] = $ar_fields['PROPERTY_RELATED_ARTICLES_VALUE'];} //ID связанных элементов в масиив
    }
    $arResult["SEE_ALSO"] = $arrayLinks;
endif;
//print_r($arrayLinks);
	if($arResult["DISPLAY_PROPERTIES"]["TECH_TYPE"]["VALUE_XML_ID"]) {
		$arResult['CANONICAL_PAGE_URL'] = $arResult['CANONICAL_PAGE_URL'].'&'.$arResult["DISPLAY_PROPERTIES"]["TECH_TYPE"]["VALUE_XML_ID"];
	}
if($arParams['DISPLAY_PICTURE'] != 'N'){
	if(is_array($arResult['DETAIL_PICTURE'])){
		$arResult['GALLERY'][] = array(
			'DETAIL' => $arResult['DETAIL_PICTURE'],
			'PREVIEW' => CFile::ResizeImageGet($arResult['DETAIL_PICTURE'] , array('width' => 310, 'height' => 285), BX_RESIZE_PROPORTIONAL, true),
			'THUMB' => CFile::ResizeImageGet($arResult['DETAIL_PICTURE'] , array('width' => 75, 'height' => 75), BX_RESIZE_IMAGE_EXACT, true),
			'TITLE' => (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['TITLE']) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME'])),
			'ALT' => (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['ALT']) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME'])),
		);
	}
	
	if(!empty($arResult['PROPERTIES']['PHOTOS']['VALUE'])){
		foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $img){
			$arResult['GALLERY'][] = array(
				'DETAIL' => ($arPhoto = CFile::GetFileArray($img)),
				'PREVIEW' => CFile::ResizeImageGet($img, array('width' => 310, 'height' => 285), BX_RESIZE_PROPORTIONAL, true),
				'THUMB' => CFile::ResizeImageGet($img , array('width' => 75, 'height' => 75), BX_RESIZE_IMAGE_EXACT, true),
				'TITLE' => (strlen($arPhoto['DESCRIPTION']) ? $arPhoto['DESCRIPTION'] : (strlen($arPhoto['TITLE']) ? $arPhoto['TITLE'] : $arResult['NAME'])),
				'ALT' => (strlen($arPhoto['DESCRIPTION']) ? $arPhoto['DESCRIPTION'] : (strlen($arPhoto['ALT']) ? $arPhoto['ALT'] : $arResult['NAME'])),
			);
		}
	}
}

$parsePrice = function ($value) {
    if (is_array($value)) {
        $value = reset($value);
    }

    $value = html_entity_decode((string)$value, ENT_QUOTES, SITE_CHARSET ?: 'UTF-8');
    $value = str_replace([' ', "\xc2\xa0"], '', $value);
    $value = preg_replace('/[^\d,.\-]/', '', $value);
    if (preg_match('/[,.]\d{1,2}$/', $value, $matches)) {
        $decimalSeparator = $matches[0][0];
        $thousandsSeparator = $decimalSeparator == ',' ? '.' : ',';
        $value = str_replace($thousandsSeparator, '', $value);
        $value = str_replace($decimalSeparator, '.', $value);
    } else {
        $value = str_replace([',', '.'], '', $value);
    }

    return (float)$value;
};

$price = $parsePrice($arResult['DISPLAY_PROPERTIES']['PRICE']['VALUE']);
$leasingRate = 1.18;
$leasingDefaultTerm = 12;
$leasingDefaultAdvance = 20;
$leasingAdvanceAmount = round($price * $leasingDefaultAdvance / 100);
$leasingMonthlyPayment = round(($price - $leasingAdvanceAmount) * $leasingRate / $leasingDefaultTerm);
$arResult['LEASING_CALCULATOR'] = [
    'SHOW' => $price > 0,
    'PRICE' => $price,
    'RATE' => $leasingRate,
    'TERMS' => [12, 24, 36],
    'ADVANCES' => [20, 30, 50],
    'DEFAULT_TERM' => $leasingDefaultTerm,
    'DEFAULT_ADVANCE' => $leasingDefaultAdvance,
    'ADVANCE_AMOUNT' => $leasingAdvanceAmount,
    'MONTHLY_PAYMENT' => $leasingMonthlyPayment,
];

if($arResult['DISPLAY_PROPERTIES']){
	$arResult['CHARACTERISTICS'] = array();
	$arResult['VIDEO'] = array();
	foreach($arResult['DISPLAY_PROPERTIES'] as $PCODE => $arProp){
		if(!in_array($arProp['CODE'], array('PERIOD', 'PHOTOS', 'PRICE', 'PRICEOLD', 'ARTICLE', 'STATUS', 'DOCUMENTS', 'LINK_GOODS', 'LINK_STAFF', 'LINK_REVIEWS', 'LINK_PROJECTS', 'LINK_SERVICES', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS'))){
			if($arProp["VALUE"] || strlen($arProp["VALUE"])){
				if ($arProp['USER_TYPE'] == 'video') {
					if (count($arProp['PROPERTY_VALUE_ID']) > 1) {
						foreach($arProp['VALUE'] as $val){
							if($val['path']){
								$arResult['VIDEO'][] = $val;
							}
						}
					}
					elseif($arProp['VALUE']['path']){
						$arResult['VIDEO'][] = $arProp['VALUE'];
					}
				}
				else{
					$arResult['CHARACTERISTICS'][$PCODE] = $arProp;
				}
			}
		}
	}
}
?>
