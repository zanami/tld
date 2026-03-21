<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views staff-linked">
	<?if ($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if ($arResult['ITEMS']):?>
		<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
			<?foreach ($arResult['ITEMS'] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);
				$bImage = !empty($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
				$imageSrc = $bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['SRC'] : '';
				?>
				<div class="overflow-hidden rounded-[2rem] border border-black/10 bg-white shadow-sm" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
					<div class="aspect-[4/3] overflow-hidden bg-gray-100">
						<?if ($bImage):?>
							<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="block h-full"><?endif;?>
								<img src="<?=$imageSrc?>" alt="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME'])?>" class="h-full w-full object-cover" loading="lazy" />
							<?if ($bDetailLink):?></a><?endif;?>
						<?else:?>
							<div class="flex h-full items-center justify-center bg-gradient-to-br from-gray-900 via-gray-700 to-orange-500 text-sm uppercase tracking-[0.35em] text-white/80">Team</div>
						<?endif;?>
					</div>
					<div class="px-6 py-6">
						<h3 class="text-xl font-semibold text-gray-950">
							<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="transition hover:text-orange-700"><?endif;?>
								<?=$arItem['NAME']?>
							<?if ($bDetailLink):?></a><?endif;?>
						</h3>

						<?if (strlen($arItem['DISPLAY_PROPERTIES']['POST']['VALUE'])):?>
							<div class="mt-2 text-sm font-medium uppercase tracking-[0.18em] text-gray-500"><?=$arItem['DISPLAY_PROPERTIES']['POST']['VALUE']?></div>
						<?endif;?>

						<?if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
							<div class="content mt-4 text-base text-gray-700">
								<?if ($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
									<p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
								<?else:?>
									<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
								<?endif;?>
							</div>
						<?endif;?>

						<div class="mt-5 space-y-2 text-sm text-gray-700">
							<?foreach ((array)$arItem['DISPLAY_PROPERTIES'] as $PCODE => $arProperty):?>
								<?if ($PCODE === 'POST'): continue; endif;?>
								<?if (!strlen((string)$arProperty['DISPLAY_VALUE']) && empty($arProperty['DISPLAY_VALUE'])) continue;?>
								<?
								if (is_array($arProperty['DISPLAY_VALUE'])) {
									$val = implode(' / ', $arProperty['DISPLAY_VALUE']);
								} else {
									$val = $arProperty['DISPLAY_VALUE'];
								}
								?>
								<div>
									<span class="font-medium text-gray-500"><?=$arProperty['NAME']?>:</span>
									<?if ($PCODE === 'EMAIL'):?>
										<a href="mailto:<?=$val?>" class="text-orange-700 hover:underline"><?=$val?></a>
									<?else:?>
										<span><?=$val?></span>
									<?endif;?>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>

		<?if ($arParams['DISPLAY_BOTTOM_PAGER']):?>
			<div class="mt-10"><?=$arResult['NAV_STRING']?></div>
		<?endif;?>
	<?endif;?>
</div>
