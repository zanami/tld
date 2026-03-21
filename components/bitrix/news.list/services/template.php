<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views services-list <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">
	<?if ($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if ($arResult['ITEMS']):?>
		<div class="grid gap-10 lg:grid-cols-2">
			<?foreach ($arResult['ITEMS'] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);
				$bImage = !empty($arItem['FIELDS']['PREVIEW_PICTURE']['ID']);
				$imageSrc = '';
				if ($bImage) {
					$arImage = CFile::ResizeImageGet($arItem['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 960, 'height' => 640), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
					$imageSrc = $arImage['src'];
				}
				?>
				<article class="overflow-hidden rounded-3xl border border-black/10 bg-white shadow-sm" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
					<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="block"><?endif;?>
						<?if ($imageSrc):?>
							<img src="<?=$imageSrc?>" alt="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME'])?>" class="h-72 w-full object-cover" loading="lazy" />
						<?else:?>
							<div class="flex h-72 items-center justify-center bg-gradient-to-br from-accent/20 via-accent/10 to-white text-sm uppercase tracking-[0.35em] text-accent">Service</div>
						<?endif;?>
					<?if ($bDetailLink):?></a><?endif;?>

					<div class="px-7 py-7 lg:px-8">
						<h2 class="text-2xl font-semibold leading-tight text-gray-950">
							<?if ($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="transition hover:text-link text-accent"><?endif;?>
								<?=$arItem['NAME']?>
							<?if ($bDetailLink):?></a><?endif;?>
						</h2>

						<?if (strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
							<div class="content mt-4 text-base text-gray-700">
								<?if ($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
									<p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
								<?else:?>
									<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
								<?endif;?>
							</div>
						<?endif;?>
					</div>
				</article>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?if ($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<div class="mt-10"><?=$arResult['NAV_STRING']?></div>
	<?endif;?>

	<?if (is_array($arResult['SECTION']['PATH'])):?>
		<?$arCurSectionPath = end($arResult['SECTION']['PATH']);?>
		<?if (strlen($arCurSectionPath['DESCRIPTION']) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
			<div class="content mt-12 rounded-3xl border border-black/10 bg-gray-50 px-8 py-7"><?=$arCurSectionPath['DESCRIPTION']?></div>
		<?endif;?>
	<?endif;?>
</div>
