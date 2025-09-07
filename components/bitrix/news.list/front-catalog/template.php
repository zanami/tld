<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<?
$frame = $this->createFrame()->begin();
$frame->setAnimation(true);
?>
<?if($arResult['ITEMS']):?>
	<?
	$qntyItems = count($arResult['ITEMS']);
	$bShowImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);
	?>
	<div class="front-catalog">
        <div class="mb-12 container text-center">
            <h3 class="mt-12 mb-4 text-5xl">Техника на складе</h3>
            <p class="mb-2 text-2xl text-gray-400">Купить вилочные погрузчики UN Forklift 1−10 т (дизель/бензин/электро) и складскую технику XILIN. В наличии готовые решения для вашего склада с быстрой отгрузкой!</p>
        </div>
        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4" itemscope itemtype="https://schema.org/ItemList">
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
                    $arImage = ($bImage ? CFile::ResizeImageGet($arItem['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 160, 'height' => 160), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
                    $imageSrc = ($bImage ? $arImage['src'] : SITE_TEMPLATE_PATH.'/images/noimage_product.png');
                    $imageDetailSrc = ($bImage ? $arItem['FIELDS']['DETAIL_PICTURE']['SRC'] : false);
                }
                // use order button?
                $bOrderButton = $arItem["DISPLAY_PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES";
                ?>
                <li class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="item<?=($bShowImage ? '' : ' wti')?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <meta itemprop="position" content="<?=$i++?>" />
                        <?if($bShowImage):?>
                            <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="blink">
                            <?elseif($imageDetailSrc):?><a href="<?=$imageDetailSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" class="img-inside fancybox" itemprop="url">
                            <?endif;?>
                                <img class="w-full h-56 object-cover" loading="lazy" src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" itemprop="image" />
                            <?if($bDetailLink):?></a>
                            <?elseif($imageDetailSrc):?><span class="zoom"><i class="fa fa-16 fa-white-shadowed fa-search"></i></span></a>
                            <?endif;?>
                        <?endif;?>

                        <div class="p-5 space-y-3">
                            <?// element name?>
                            <?if(strlen($arItem['FIELDS']['NAME'])):?>
                                <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" itemprop="url"><?endif;?>
                                    <h3 itemprop="name" class="ext-lg font-bold text-gray-900"><?=$arItem['NAME']?></h3>
                                </div>
                            <?endif;?>

                            <?// element section name?>
                            <?if(strlen($arItem['SECTION_NAME'])):?>
                                <div class="section_name"><?=$arItem['SECTION_NAME']?></div>
                            <?endif;?>

                            <?// element status?>
                            <?if(strlen($arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE'])):?>
                                <span class="label label-<?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID']?>" itemprop="description"><?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE']?></span>
                            <?endif;?>

                            <?// element article?>
                            <?if(strlen($arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'])):?>
                                <p class="text-gray-600 text-sm" itemprop="description"><?=GetMessage('S_ARTICLE')?>:&nbsp;<span><?=$arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE']?></span></p>
                            <?endif;?>

                            <?// element preview text?>
                            <?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                <div class="text-gray-600 text-sm" itemprop="description">
                                    <?if($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
                                        <?=$arItem['F    IELDS']['PREVIEW_TEXT']?>
                                    <?else:?>
                                        <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']) || $bOrderButton):?>
                                <?// element price?>
                                <?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])):?>
                                    <div class="flex items-center gap-2">
                                        <div class="text-xl font-bold text-gray-900">
                                            <span class="price_val"><?=CScorp::FormatPriceShema($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])?></span>
                                        </div>
                                        <?if($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']):?>
                                            <div class="line-through text-gray-400">
                                                <span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']?></span>
                                            </div>
                                        <?endif;?>
                                    </div>
                                <?endif;?>

                                <?if($bOrderButton):?>
                                    <?// element order button?>
                                    <span class="w-full bg-black text-white text-sm font-medium py-2 px-4 rounded-lg hover:bg-gray-800 transition" <?=(strlen(($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']) && strlen($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE'])) ? 'style="margin-top:16px;"' : '')?> data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_scorp_form"]["aspro_scorp_order_product"][0]?>" data-product="<?=$arItem["NAME"]?>" data-name="order_product"><?=GetMessage("TO_ORDER")?></span>
                                <?endif;?>
                            <?endif;?>
                    </div>
                </li>
            <?endforeach;?>
        </ul>
	</div>
<?endif;?>

<?$frame->end();?>