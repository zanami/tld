<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?if ($arParams['DISPLAY_TOP_PAGER']):?>
	<?=$arResult['NAV_STRING']?>
<?endif;?>

<?if ($arResult['ITEMS']):?>
	<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
		<?foreach ($arResult['ITEMS'] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			$detailLink = $arParams['SHOW_DETAIL_LINK'] !== 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);
			$image = $arItem['FIELDS']['PREVIEW_PICTURE']['SRC'];
			$post = trim((string)$arItem['DISPLAY_PROPERTIES']['POST']['VALUE']);
			unset($arItem['DISPLAY_PROPERTIES']['POST']);
			?>
			<article class="flex h-full flex-col rounded-3xl border border-stroke bg-white p-6 shadow-sm" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
				<?if ($image):?>
					<div class="mb-5 overflow-hidden rounded-2xl bg-gray-2 aspect-[4/3]">
						<?if ($detailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="block h-full"><?endif;?>
							<img class="h-full w-full object-cover" src="<?=$image?>" alt="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME'])?>">
						<?if ($detailLink):?></a><?endif;?>
					</div>
				<?endif;?>

				<div class="flex flex-1 flex-col">
					<?if (strlen($arItem['NAME'])):?>
						<h3 class="text-xl font-semibold leading-tight text-dark">
							<?if ($detailLink):?><a class="transition hover:text-link" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?endif;?>
								<?=$arItem['NAME']?>
							<?if ($detailLink):?></a><?endif;?>
						</h3>
					<?endif;?>

					<?if ($post):?>
						<div class="mt-2 text-sm font-semibold uppercase tracking-[0.08em] text-link/80"><?=$post?></div>
					<?endif;?>

					<?if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
						<div class="mt-4 text-sm leading-6 text-dark-3">
							<?if ($arItem['PREVIEW_TEXT_TYPE'] === 'text'):?>
								<p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
							<?else:?>
								<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
							<?endif;?>
						</div>
					<?endif;?>

					<?if ($arItem['DISPLAY_PROPERTIES']):?>
						<div class="mt-5 space-y-2 border-t border-stone-200 pt-4 text-sm leading-6 text-dark-3">
							<?foreach ($arItem['DISPLAY_PROPERTIES'] as $code => $arProperty):?>
								<?
								$value = is_array($arProperty['DISPLAY_VALUE']) ? implode(', ', $arProperty['DISPLAY_VALUE']) : $arProperty['DISPLAY_VALUE'];
								if (!$value) {
									continue;
								}
								?>
								<div>
									<span class="font-semibold text-dark"><?=$arProperty['NAME']?>:</span>
									<?if ($code === 'EMAIL'):?>
										<a href="mailto:<?=$value?>"><?=$value?></a>
									<?elseif ($code === 'PHONE'):?>
										<?$phoneHref = preg_replace('/[^0-9\+]/', '', strip_tags((string)$value));?>
										<a href="tel:<?=$phoneHref?>"><?=$value?></a>
									<?elseif ($code === 'SITE'):?>
										<!--noindex-->
										<?=str_replace('href=', "rel='nofollow' target='_blank' href=", $value);?>
										<!--/noindex-->
									<?else:?>
										<?=$value?>
									<?endif;?>
								</div>
							<?endforeach;?>
						</div>
					<?endif;?>
				</div>
			</article>
		<?endforeach;?>
	</div>

	<?if ($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<div class="mt-8">
			<?=$arResult['NAV_STRING']?>
		</div>
	<?endif;?>
<?endif;?>
