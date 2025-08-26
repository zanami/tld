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
	$countmd = 4;
	$countsm = 3;
	$countxs = 2;
	$colmd = 3;
	$colsm = 4;
	$colxs = 6;
	$bShowImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);
	?>
	<div class="front-catalog">
        <div class="mb-12 container">
            <h3 class="mt-12 mb-4 text-5xl">Техника на складе</h3>
            <p class="mb-2 text-2xl text-center  text-gray-400">Купить вилочные погрузчики UN Forklift 1−10 т (дизель/бензин/электро) и складскую технику XILIN. В наличии готовые решения для вашего склада с быстрой отгрузкой!</p>
        </div>
		<?/*$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => SITE_DIR."include/front-catalog-favorites.php",
				"EDIT_TEMPLATE" => "standard.php"
			)
		);*/?>
		<div class="the-flexslider unstyled row" data-plugin-options='{"animation": "slide", "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "counts": [<?=$countmd?>, <?=$countsm?>, <?=$countxs?>]}'>
			<ul class="slides" itemscope itemtype="http://schema.org/ItemList">
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
					<li class="col-md-<?=$colmd?> col-sm-<?=$colsm?> col-xs-<?=$colxs?>">
						<div class="item<?=($bShowImage ? '' : ' wti')?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="<?=$i++?>" />
							<?if($bShowImage):?>
								<div class="image">
									<?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="blink">
									<?elseif($imageDetailSrc):?><a href="<?=$imageDetailSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" class="img-inside fancybox" itemprop="url">
									<?endif;?>
										<img class="img-responsive lazyload" loading="lazy" data-src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" itemprop="image" />
									<?if($bDetailLink):?></a>
									<?elseif($imageDetailSrc):?><span class="zoom"><i class="fa fa-16 fa-white-shadowed fa-search"></i></span></a>
									<?endif;?>
								</div>
							<?endif;?>
							
							<div class="text">
								<div class="cont">
									<?// element name?>
									<?if(strlen($arItem['FIELDS']['NAME'])):?>
										<div class="title">
											<?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" itemprop="url"><?endif;?>
												<span itemprop="name"><?=$arItem['NAME']?></span>
											<?if($bDetailLink):?></a><?endif;?>
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
										<span class="article" itemprop="description"><?=GetMessage('S_ARTICLE')?>:&nbsp;<span><?=$arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE']?></span></span>
									<?endif;?>
									
									<?/*
									<?// element preview text?>
									<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
										<div class="description" itemprop="description">
											<?if($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
												<p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
											<?else:?>
												<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
											<?endif;?>
										</div>
									<?endif;?>
									*/?>
								</div>
								
								<?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']) || $bOrderButton):?>
									<div class="row foot">
										<div class="<?=(!$bOrderButton ? 'col-md-12 col-sm-12 col-xs-12' : 'col-md-6 col-sm-12 col-xs-12')?> pull-left">
											<?// element price?>
											<?if(strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])):?>
												<div class="price">
													<div class="price_new">
														<span class="price_val"><?=CScorp::FormatPriceShema($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])?></span>
													</div>
													<?if($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']):?>
														<div class="price_old">
															<span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']?></span>
														</div>
													<?endif;?>
												</div>
											<?endif;?>
										</div>

										<?if($bOrderButton):?>
											<div class="col-md-6 col-sm-12 col-xs-12 pull-right">
												<?// element order button?>
												<span class="btn btn-default btn-sm pull-right" <?=(strlen(($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']) && strlen($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE'])) ? 'style="margin-top:16px;"' : '')?> data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_scorp_form"]["aspro_scorp_order_product"][0]?>" data-product="<?=$arItem["NAME"]?>" data-name="order_product"><?=GetMessage("TO_ORDER")?></span>
											</div>
										<?endif;?>
									</div>
								<?endif;?>
							</div>
						</div>
					</li>
				<?endforeach;?>
			</ul>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
$('.catalog.item-views.table .item .image img').each (function() {var src = $(this).data('src').toString(); $(this).attr('src', src);});
			$('.catalog.item-views.table .item .image').sliceHeight({slice: <?=$qntyItems?>, autoslicecount: false, lineheight: -3});
			$('.catalog.item-views.table .title').sliceHeight({slice: <?=$qntyItems?>, autoslicecount: false});
			$('.catalog.item-views.table .cont').sliceHeight({slice: <?=$qntyItems?>, autoslicecount: false});
			$('.catalog.item-views.table .item').sliceHeight({slice: <?=$qntyItems?>, autoslicecount: false});
		});
		</script>
	</div>
<?endif;?>
<script type="text/javascript">
$(document).ready(function() {
	try{

		if(arScorpOptions.THEME.CATALOG_INDEX == 'Y'){
			$('.catalog.item-views.sections.front').show();
			if(arScorpOptions.THEME.TEASERS_INDEX == 'NONE'){
				$('.catalog.item-views.sections.front').css('margin-top', '47px');
			}
		}
		else{
			$('.catalog.item-views.sections.front').remove();
			$('#front_catalog_separator').remove();
		}
		if(arScorpOptions.THEME.CATALOG_FAVORITES_INDEX == 'Y'){
			$('.catalog.item-views.table.front').show();
			if(arScorpOptions.THEME.TEASERS_INDEX == 'NONE' && arScorpOptions.THEME.CATALOG_INDEX == 'N'){
				$('.catalog.item-views.table.front').css('margin-top', '47px');
			}
			InitFlexSlider();
			$('.catalog.item-views.table.front .blink img').blink();
		}
		else{
			$('.catalog.item-views.table.front').remove();
			$('#front_catalog_separator').remove();
		}
	}
	catch(e){}
});
</script>
<?$frame->end();?>