<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?if ($arResult['ITEMS']):?>
	<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
		<?foreach ($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);
			$bShowImage = in_array('PREVIEW_PICTURE', (array)$arParams['FIELD_CODE']);
			$imageSrc = '';
			$imageDetailSrc = '';
			if ($bShowImage && !empty($arItem['FIELDS']['PREVIEW_PICTURE']['ID'])) {
				$arImage = CFile::ResizeImageGet($arItem['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 640, 'height' => 640), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
				$imageSrc = $arImage['src'];
				$imageDetailSrc = $arItem['FIELDS']['DETAIL_PICTURE']['SRC'];
			}
			$bOrderButton = $arItem["DISPLAY_PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES";
			?>
			<div class="overflow-hidden rounded-3xl border border-black/10 bg-white shadow-sm" id="<?=$this->GetEditAreaId($arItem['ID'])?>" itemprop="itemListElement">
				<div class="aspect-square overflow-hidden bg-gray-100">
					<?if ($imageSrc):?>
						<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="block h-full" itemprop="url"><?endif;?>
						<?if (!$bDetailLink && $imageDetailSrc):?><a href="<?=$imageDetailSrc?>" data-fancybox="catalog-linked" class="block h-full" itemprop="url"><?endif;?>
							<img class="h-full w-full object-cover" src="<?=$imageSrc?>" alt="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME'])?>" itemprop="image" loading="lazy" />
						<?if ($bDetailLink || (!$bDetailLink && $imageDetailSrc)):?></a><?endif;?>
					<?else:?>
						<div class="flex h-full items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-orange-500 text-sm uppercase tracking-[0.35em] text-white/80">Product</div>
					<?endif;?>
				</div>

				<div class="px-6 py-6">
					<?if (strlen($arItem['SECTION_NAME'])):?>
						<div class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500"><?=$arItem['SECTION_NAME']?></div>
					<?endif;?>

					<h3 class="mt-3 text-xl font-semibold leading-snug text-gray-950">
						<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" itemprop="url" class="transition hover:text-link"><?endif;?>
							<span itemprop="name"><?=$arItem['NAME']?></span>
						<?if ($bDetailLink):?></a><?endif;?>
					</h3>

					<div class="mt-4 space-y-2 text-sm text-gray-600">
						<?if (strlen($arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE'])):?>
							<div class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-gray-700"><?=$arItem['DISPLAY_PROPERTIES']['STATUS']['VALUE']?></div>
						<?endif;?>
						<?if (strlen($arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'])):?>
							<div><span class="font-medium text-gray-500"><?=GetMessage('S_ARTICLE')?>:</span> <span><?=$arItem['DISPLAY_PROPERTIES']['ARTICLE']['VALUE']?></span></div>
						<?endif;?>
					</div>

					<?if (strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE']) || $bOrderButton):?>
						<div class="mt-6 flex flex-wrap items-end justify-between gap-4">
							<div>
								<?if (strlen($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])):?>
									<div class="text-2xl font-semibold text-gray-950">
										<span class="price_val"><?=CScorp::FormatPriceShema($arItem['DISPLAY_PROPERTIES']['PRICE']['VALUE'])?></span>
									</div>
									<?if ($arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']):?>
										<div class="mt-1 text-sm text-gray-400 line-through">
											<span class="price_val"><?=$arItem['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']?></span>
										</div>
									<?endif;?>
								<?endif;?>
							</div>
							<?if ($bOrderButton):?>
								<span class="inline-block px-12 py-4 rounded-md bg-accent text-gray-950 uppercase cursor-pointer" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]["aspro_scorp_form"]["aspro_scorp_order_product"][0]?>" data-product="<?=$arItem["NAME"]?>" data-name="order_product" data-form="formnew">
									<?=(strlen($arParams['S_ORDER_PRODUCT']) ? $arParams['S_ORDER_PRODUCT'] : GetMessage('S_ORDER_PRODUCT'))?>
								</span>
							<?endif;?>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endforeach;?>
	</div>
<?endif;?>
