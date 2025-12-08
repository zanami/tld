<?if($itemsCnt):?>
    <!-- noindex -->
    <div class="container mx-auto my-6">
        <?
        if($arResult['VARIABLES']['SECTION_ID']){
            $arSectiontmp = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arResult['VARIABLES']['SECTION_ID']), false, array('ID',  'UF_VIEWTYPE'))->GetNext();
        }
        elseif($arResult['VARIABLES']['SECTION_CODE']){
            $arSectiontmp = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $arResult['VARIABLES']['SECTION_CODE']), false, array('ID', 'UF_VIEWTYPE'))->GetNext();
        }

        if($_SESSION['UF_VIEWTYPE_'.$arParams['IBLOCK_ID']] === NULL){
            $arUserFieldViewType = CUserTypeEntity::GetList(array(), array('ENTITY_ID' => 'IBLOCK_'.$arParams['IBLOCK_ID'].'_SECTION', 'FIELD_NAME' => 'UF_VIEWTYPE'))->Fetch();
            $resUserFieldViewTypeEnum = CUserFieldEnum::GetList(array(), array('USER_FIELD_ID' => $arUserFieldViewType['ID']));
            while($arUserFieldViewTypeEnum = $resUserFieldViewTypeEnum->GetNext()){
                $_SESSION['UF_VIEWTYPE_'.$arParams['IBLOCK_ID']][$arUserFieldViewTypeEnum['ID']] = $arUserFieldViewTypeEnum['XML_ID'];
            }
        }

        $sort_default = $arParams['SORT_PROP_DEFAULT'] ? $arParams['SORT_PROP_DEFAULT'] : 'name';
        $order_default = $arParams['SORT_DIRECTION'] ? $arParams['SORT_DIRECTION'] : 'asc';
        $arPropertySortDefault = array('name', 'sort');

        $arAvailableSort = array(
                'name' => array(
                        'SORT' => 'NAME',
                        'ORDER_VALUES' => array(
                                'asc' => GetMessage('sort_title').GetMessage('sort_name_asc'),
                                'desc' => GetMessage('sort_title').GetMessage('sort_name_desc'),
                        ),
                ),
                'sort' => array(
                        'SORT' => 'SORT',
                        'ORDER_VALUES' => array(
                                $order_default => GetMessage('sort_title').GetMessage('sort_sort'),
                        )
                ),
        );

        foreach($arAvailableSort as $prop => $arProp){
            if(!in_array($prop, $arParams['SORT_PROP']) && $sort_default !== $prop){
                unset($arAvailableSort[$prop]);
            }
        }

        if($arParams['SORT_PROP']){
            if(!isset($_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))])){
                foreach($arParams['SORT_PROP'] as $prop){
                    if(!isset($arAvailableSort[$prop])){
                        $dbRes = CIBlockProperty::GetList(array(), array('ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $prop));
                        while($arPropperty = $dbRes->Fetch()){
                            $arAvailableSort[$prop] = array(
                                    'SORT' => 'PROPERTY_'.$prop,
                                    'ORDER_VALUES' => array(),
                            );

                            if($prop == 'PRICE' || $prop == 'FILTER_PRICE'){
                                $arAvailableSort[$prop]['ORDER_VALUES']['asc'] = GetMessage('sort_title').GetMessage('sort_PRICE_asc');
                                $arAvailableSort[$prop]['ORDER_VALUES']['desc'] = GetMessage('sort_title').GetMessage('sort_PRICE_desc');
                            }
                            else{
                                $arAvailableSort[$prop]['ORDER_VALUES'][$order_default] = GetMessage('sort_title_property', array('#CODE#' => $arPropperty['NAME']));
                            }
                        }
                    }
                }
                $_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))] = $arAvailableSort;
            }
            else{
                $arAvailableSort = $_SESSION[$arParams['IBLOCK_ID'].md5(serialize((array)$arParams['SORT_PROP']))];
            }
        }

        if(array_key_exists('display', $_REQUEST) && !empty($_REQUEST['display'])){
            setcookie('catalogViewMode', $_REQUEST['display'], 0, SITE_DIR);
            $_COOKIE['catalogViewMode'] = $_REQUEST['display'];
        }
        if(array_key_exists('sort', $_REQUEST) && !empty($_REQUEST['sort'])){
            setcookie('catalogSort', $_REQUEST['sort'], 0, SITE_DIR);
            $_COOKIE['catalogSort'] = $_REQUEST['sort'];
        }
        if(array_key_exists('order', $_REQUEST) && !empty($_REQUEST['order'])){
            setcookie('catalogOrder', $_REQUEST['order'], 0, SITE_DIR);
            $_COOKIE['catalogOrder'] = $_REQUEST['order'];
        }
        if(array_key_exists('show', $_REQUEST) && !empty($_REQUEST['show'])){
            setcookie('catalogPageElementCount', $_REQUEST['show'], 0, SITE_DIR);
            $_COOKIE['catalogPageElementCount'] = $_REQUEST['show'];
        }

        if($arSectiontmp['UF_VIEWTYPE'] && isset($_SESSION['UF_VIEWTYPE_'.$arParams['IBLOCK_ID']][$arSectiontmp['UF_VIEWTYPE']])){
            $display = $_SESSION['UF_VIEWTYPE_'.$arParams['IBLOCK_ID']][$arSectiontmp['UF_VIEWTYPE']];
        }
        else{
            $display = !empty($_COOKIE['catalogViewMode']) ? $_COOKIE['catalogViewMode'] : $arParams['VIEW_TYPE'];
        }
        $show = !empty($_COOKIE['catalogPageElementCount']) ? $_COOKIE['catalogPageElementCount'] : $arParams['PAGE_ELEMENT_COUNT'];
        $sort = !empty($_COOKIE['catalogSort']) ? $_COOKIE['catalogSort'] : $sort_default;
        $order = !empty($_COOKIE['catalogOrder']) ? $_COOKIE['catalogOrder'] : $order_default;
        ?>
        <div class="sorting-links flex gap-4">
            <span class="text-neutral-600"><?=GetMessage('T_SORT');?>:</span>
            <?foreach($arAvailableSort as $newSort => $arSort):?>
                <?php
                $isCurrentSort = ($sort == $newSort);
                $orderValues   = array_keys($arSort['ORDER_VALUES']);

                // Определяем, какое направление поставить в ссылку
                if(count($orderValues) > 1){
                    // Есть и asc, и desc — делаем переключатель
                    if($isCurrentSort){
                        // Сейчас сортируем по этому полю — переключаем направление
                        if($order == 'asc' && in_array('desc', $orderValues)){
                            $nextOrder = 'desc';
                        }
                        elseif($order == 'desc' && in_array('asc', $orderValues)){
                            $nextOrder = 'asc';
                        }
                        else{
                            $nextOrder = $orderValues[0];
                        }
                    }
                    else{
                        // По этому полю ещё не сортируем — ставим "стартовое" направление
                        $nextOrder = in_array('asc', $orderValues) ? 'asc' : $orderValues[0];
                    }
                }
                else{
                    // Только одно направление (например, "популярность")
                    $nextOrder = $orderValues[0];
                }

                // URL, по которому будет сортировка
                $url = $APPLICATION->GetCurPageParam(
                        'sort='.$newSort.'&order='.$nextOrder,
                        array('sort', 'order')
                );

                // Текст ссылки: если уже сортируем по этому полю и есть текущий title — берём его,
                // иначе берём первый из массива ORDER_VALUES
                if($isCurrentSort && isset($arSort['ORDER_VALUES'][$order])){
                    $linkTitle = $arSort['ORDER_VALUES'][$order];
                }
                else{
                    $firstTitle = reset($arSort['ORDER_VALUES']);
                    $linkTitle  = $firstTitle;
                }
                ?>
                <a rel="nofollow"
                   href="<?=$url?>"
                   class="text-amber-600 decoration-1 underline decoration-dashed underline-offset-4 <?=$isCurrentSort ? 'font-semibold' : ''?>">
                    <?=$linkTitle?>
                </a>
            <?endforeach;?>
        </div>
    </div>
    <!-- /noindex -->
<?endif;?>
