<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$frame = $this->createFrame()->begin();
$frame->setAnimation(true);
?>
<?if($arResult['ITEMS']):?>
	<?
	$qntyItems = count($arResult['ITEMS']);
	$bShowImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);
	?>
        <ul class="container mx-auto grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-4" itemscope itemtype="https://schema.org/ItemList">
            <?
            $i = 0;
            foreach($arResult["ITEMS"] as $i => $arItem):?>
                <?
                // edit/add/delete buttons for edit mode
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                // use detail link?
                $bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);
                // preview image
                if($bShowImage){
                    $bImage = strlen($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
                    $arImage = ($bImage ? CFile::ResizeImageGet($arItem['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 344, 'height' => 224), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
                    $imageSrc = ($bImage ? $arImage['src'] : SITE_TEMPLATE_PATH.'/images/noimage_product.png');
                    $imageDetailSrc = ($bImage ? $arItem['FIELDS']['DETAIL_PICTURE']['SRC'] : false);
                }
                // use order button?
                $bOrderButton = $arItem["DISPLAY_PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES";
                ?>
                <li class="h-full overflow-hidden flex flex-col" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <meta itemprop="position" content="<?=$i++?>" />
                    <?if($bShowImage):?>
                        <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="blink">
                        <?elseif($imageDetailSrc):?><a href="<?=$imageDetailSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" class="img-inside fancybox" itemprop="url">
                        <?endif;?>
                        <img class="w-full rounded-3xl h-56 object-cover mb-8" loading="lazy" src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" itemprop="image" />
                        <?if($bDetailLink):?></a>
                        <?elseif($imageDetailSrc):?><span class="zoom"><i class="fa fa-16 fa-white-shadowed fa-search"></i></span></a>
                        <?endif;?>
                    <?endif;?>

                    <div class="tracking-wide flex flex-col flex-1">
                        <?// element name?>
                        <?if(strlen($arItem['FIELDS']['NAME'])):?>
                            <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" itemprop="url"><?endif;?>
                            <h3 itemprop="name" class="text-xl/7 font-semibold text-gray-900"><?=$arItem['NAME']?></h3>
                            <?if($bDetailLink):?></a><?endif;?>
                        <?endif;?>
                    </div>
                    <div class="mt-auto">
                        <?// element status?>
                        <?if(strlen($arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE'])):?>
                            <span class="hidden label label-<?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID']?>" itemprop="description"><?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE']?></span>
                        <?endif;?>

                        <?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])):?>
                            <?// element price?>
                            <?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])):?>
                                <div class="flex items-center gap-2 my-4 font-thin text-2xl">
                                    <div class="text-gray-900">
                                        <span class="price_val"><?=CScorp::FormatPriceShema($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])?></span>
                                    </div>
                                    <?if($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']):?>
                                        <div class="line-through text-gray-400">
                                            <span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']?></span>
                                        </div>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                        <?endif;?>
                        <div class="flex items-center gap-4 mt-2 mb-4 text-gray-600 font-thin text-lg">
                            <?if($arItem['DISPLAY_PROPERTIES']['COLOR']['VALUE']):?>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003" xml:space="preserve" width="16px" height="18px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 5.22 5.62"> <defs> <style type="text/css"> .fil0 {fill:#F7A519} </style> </defs> <g id="Layer_x0020_1"><path class="fil0" d="M1.44 1.12c0.05,-1.49 2.29,-1.49 2.34,0 0.52,0.16 0.82,0.68 0.95,1.2 0.08,0.33 0.49,1.94 0.49,2.15 0,0.66 -0.7,1.14 -1.33,1.14 -0.48,0 -2.55,0.04 -2.88,-0.04 -0.59,-0.14 -1.14,-0.68 -0.98,-1.32l0.46 -1.93c0.12,-0.51 0.42,-1.04 0.95,-1.2zm0.2 2.05l0.53 -0.68 0.57 0 -0.64 0.78 0.67 1.12 -0.54 0 -0.44 -0.74 -0.15 0.18 0 0.56 -0.46 0 0 -1.9 0.46 0 0 0.68zm2.44 0.7c-0.18,0.79 -1.39,0.7 -1.39,-0.16 0,-0.43 -0.09,-1.06 0.51,-1.21 0.47,-0.12 0.89,0.17 0.89,0.55l-0.5 0c-0.01,-0.16 -0.44,-0.18 -0.44,0.16 0,0.23 -0.04,0.57 0.07,0.69 0.1,0.1 0.4,0.12 0.42,-0.19l-0.34 0 0 -0.44 0.8 0 -0.02 0.6zm-0.74 -2.81c-0.11,-0.84 -1.35,-0.84 -1.46,0l1.46 0z"></path> </g> </svg>
                                    <span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['COLOR']['VALUE']?> кг</span>
                                </div>
                            <?endif;?>
                            <?if($arItem['DISPLAY_PROPERTIES']['SIZE']['VALUE']):?>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003" xml:space="preserve" width="18px" height="18px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 5.14 5.14"> <defs> <style type="text/css"> .fil0 {fill:#F7A519} </style> </defs> <g id="Layer_x0020_1"> <metadata id="CorelCorpID_0Corel-Layer"></metadata> <path class="fil0" d="M2.57 0c1.42,0 2.57,1.15 2.57,2.57 0,1.42 -1.15,2.57 -2.57,2.57 -1.42,0 -2.57,-1.15 -2.57,-2.57 0,-1.42 1.15,-2.57 2.57,-2.57zm-1.5 1.3l0 -0.49 3 0 0 0.49c-1.93,0 -0.8,0 -3,0zm1.74 1.01l0.59 0.58 0.34 -0.34c-1.16,-1.16 0.16,0.16 -1.17,-1.17 -1.33,1.33 -0.01,0.01 -1.17,1.17l0.34 0.34 0.59 -0.58 0 1.3 0.48 0 0 -1.3zm-0.48 1.75l0.48 0 0 0.51 -0.48 0c0,-1.43 0,1.13 0,-0.51z"></path> </g> </svg>
                                    <span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['SIZE']['VALUE']?> мм</span>
                                </div>
                            <?endif;?>
                        </div>
                        <?if($bDetailLink):?>
                            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="inline-block px-4 py-3 rounded-md bg-accent text-gray-950 uppercase">Купить со скидкой</a>
                        <?endif;?>
                    </div>
                </li>
            <?endforeach;?>
        </ul>
<?endif;?>

<?$frame->end();?>