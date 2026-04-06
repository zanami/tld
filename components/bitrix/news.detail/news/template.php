<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
$displayName = $arParams['DISPLAY_NAME'] != 'N' && strlen($arResult['NAME']);
$period = (string)($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE'] ?? '');
$displayPeriod = strlen($period) || ($arResult['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', (array)$arParams['FIELD_CODE']));
$displayPropertiesCodes = array_diff(array_keys((array)$arResult['DISPLAY_PROPERTIES']), array('PERIOD', 'PHOTOS', 'DOCUMENTS', 'LINK_GOODS', 'LINK_STAFF', 'LINK_REVIEWS', 'LINK_PROJECTS', 'LINK_STUDY', 'LINK_SERVICES', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS'));
$detailImage = !empty($arResult['FIELDS']['DETAIL_PICTURE']) ? $arResult['DETAIL_PICTURE']['SRC'] : '';
$detailImageTitle = strlen((string)($arResult['DETAIL_PICTURE']['DESCRIPTION'] ?? '')) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen((string)($arResult['DETAIL_PICTURE']['TITLE'] ?? '')) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME']);
$detailImageAlt = strlen((string)($arResult['DETAIL_PICTURE']['DESCRIPTION'] ?? '')) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen((string)($arResult['DETAIL_PICTURE']['ALT'] ?? '')) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME']);
$galleryItems = is_array($arResult['GALLERY']) ? $arResult['GALLERY'] : array();
if ($detailImage) {
	array_unshift($galleryItems, array(
		'DETAIL' => array('SRC' => $detailImage),
		'PREVIEW' => array('src' => $detailImage),
		'TITLE' => $detailImageTitle,
		'ALT' => $detailImageAlt,
	));
}
$galleryItems = array_values(array_reduce($galleryItems, function ($carry, $item) {
	$src = $item['DETAIL']['SRC'] ?? '';
	if ($src && !isset($carry[$src])) {
		$carry[$src] = $item;
	}
	return $carry;
}, array()));
$leadGalleryItem = $galleryItems ? $galleryItems[0] : null;
$hasAside = $leadGalleryItem || ($arResult['DISPLAY_PROPERTIES'] && $displayPropertiesCodes);
?>
<article class="space-y-12 lg:space-y-16">
	<div class="<?=$hasAside ? 'grid gap-10 xl:grid-cols-[minmax(0,1fr)_24rem]' : 'max-w-4xl'?>">
		<div class="space-y-8">
			<?if ($displayName):?>
				<h2 class="text-4xl font-semibold tracking-tight text-gray-950"><?=$arResult['NAME']?></h2>
			<?endif;?>

			<?if ($displayPeriod):?>
				<div>
					<?if (strlen($period)):?>
						<span class="inline-flex rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-link"><?=$period?></span>
					<?else:?>
						<span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-gray-600"><?=$arResult['DISPLAY_ACTIVE_FROM']?></span>
					<?endif;?>
				</div>
			<?endif;?>

			<?if (strlen($arResult['FIELDS']['PREVIEW_TEXT']) || strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
				<div class="space-y-8 text-gray-700">
					<?if (strlen($arResult['FIELDS']['PREVIEW_TEXT'])):?>
						<div class="max-w-3xl text-2xl font-thin leading-9">
							<?if ($arResult['PREVIEW_TEXT_TYPE'] == 'text'):?>
								<p><?=$arResult['FIELDS']['PREVIEW_TEXT'];?></p>
							<?else:?>
								<?=$arResult['FIELDS']['PREVIEW_TEXT'];?>
							<?endif;?>
						</div>
					<?endif;?>

					<?if (strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
						<div class="content text-xl font-thin leading-8">
							<?if ($arResult['DETAIL_TEXT_TYPE'] == 'text'):?>
								<p><?=$arResult['FIELDS']['DETAIL_TEXT'];?></p>
							<?else:?>
								<?=$arResult['FIELDS']['DETAIL_TEXT'];?>
							<?endif;?>
						</div>
					<?endif;?>
				</div>
			<?endif;?>
		</div>

		<?if ($hasAside):?>
			<aside class="space-y-8">
				<?if ($leadGalleryItem):?>
					<a href="<?=$leadGalleryItem['DETAIL']['SRC']?>" data-fancybox="news-main" class="group block overflow-hidden rounded-3xl bg-gray-100 shadow-sm">
						<img src="<?=$leadGalleryItem['PREVIEW']['src'] ?? $leadGalleryItem['DETAIL']['SRC']?>" alt="<?=htmlspecialcharsbx($leadGalleryItem['ALT'] ?? $detailImageAlt)?>" title="<?=htmlspecialcharsbx($leadGalleryItem['TITLE'] ?? $detailImageTitle)?>" class="h-full min-h-80 w-full object-cover transition duration-300 group-hover:scale-105" />
					</a>
				<?endif;?>

				<?if ($arResult['DISPLAY_PROPERTIES'] && $displayPropertiesCodes):?>
					<div class="rounded-3xl border border-black/10 bg-gray-50 p-7">
						<div class="mb-4 text-sm font-semibold uppercase tracking-[0.25em] text-gray-500"><?=GetMessage('T_CHARACTERISTICS')?></div>
						<dl class="space-y-4">
							<?foreach ($arResult['DISPLAY_PROPERTIES'] as $PCODE => $arProperty):?>
								<?if (in_array($PCODE, $displayPropertiesCodes)):?>
									<?
									if (is_array($arProperty['DISPLAY_VALUE'])) {
										$val = implode(' / ', $arProperty['DISPLAY_VALUE']);
									} else {
										$val = $arProperty['DISPLAY_VALUE'];
									}
									?>
									<div class="border-b border-black/10 pb-4 last:border-b-0 last:pb-0">
										<dt class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500"><?=$arProperty['NAME']?></dt>
										<dd class="mt-2 text-sm leading-6 text-gray-800">
											<?if ($PCODE == 'SITE'):?>
												<?=str_replace("href=", "rel='nofollow' target='_blank' href=", $val);?>
											<?elseif ($PCODE == 'EMAIL'):?>
												<a href="mailto:<?=$val?>" class="text-accent hover:text-link hover:underline"><?=$val?></a>
											<?else:?>
												<?=$val?>
											<?endif;?>
										</dd>
									</div>
								<?endif;?>
							<?endforeach;?>
						</dl>
					</div>
				<?endif;?>
			</aside>
		<?endif;?>
	</div>

	<?if (count($galleryItems) > 1):?>
		<section class="space-y-8 pt-2">
			<h3 class="mb-10 text-5xl font-semibold text-gray-950"><?=strlen($arParams['T_GALLERY']) ? $arParams['T_GALLERY'] : GetMessage('T_GALLERY')?></h3>
			<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
				<?foreach ($galleryItems as $index => $arPhoto):?>
					<a href="<?=$arPhoto['DETAIL']['SRC']?>" data-fancybox="news-gallery" class="group overflow-hidden rounded-3xl bg-gray-100 <?=$index === 0 ? 'sm:col-span-2 sm:row-span-2' : ''?>">
						<img src="<?=$arPhoto['PREVIEW']['src'] ?? $arPhoto['DETAIL']['SRC']?>" alt="<?=htmlspecialcharsbx($arPhoto['ALT'] ?? $detailImageAlt)?>" title="<?=htmlspecialcharsbx($arPhoto['TITLE'] ?? $detailImageTitle)?>" class="w-full object-cover transition duration-300 group-hover:scale-105 <?=$index === 0 ? 'h-80 min-h-80 sm:h-full' : 'h-52'?>" loading="lazy" />
					</a>
				<?endforeach;?>
			</div>
		</section>
	<?endif;?>

	<?if (!empty($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'])):?>
		<section class="space-y-8 pt-2">
			<h3 class="mb-10 text-5xl font-semibold text-gray-950"><?=strlen($arParams['T_DOCS']) ? $arParams['T_DOCS'] : GetMessage('T_DOCS')?></h3>
			<div class="flex flex-col gap-6 text-xl font-thin leading-8">
				<?foreach ((array)$arResult['PROPERTIES']['DOCUMENTS']['VALUE'] as $docID):?>
					<?$arItem = CScorp::get_file_info($docID);?>
					<?
					$fileName = substr($arItem['ORIGINAL_NAME'], 0, strrpos($arItem['ORIGINAL_NAME'], '.'));
					$fileTitle = (strlen($arItem['DESCRIPTION']) ? $arItem['DESCRIPTION'] : $fileName);
					?>
					<div class="flex gap-3">
						<div>
							<a class="block text-gray-900 hover:text-link" href="<?=$arItem['SRC']?>" target="_blank" title="<?=$fileTitle?>"><?=$fileTitle?></a>
							<span class="block text-gray-500"><?=CScorp::filesize_format($arItem['FILE_SIZE']);?></span>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</section>
	<?endif;?>

	<?$frame = $this->createFrame('video')->begin('');?>
	<?$frame->setAnimation(true);?>
	<?if ($arResult['VIDEO']):?>
		<section class="space-y-8 pt-2">
			<h3 class="mb-10 text-5xl font-semibold text-gray-950"><?=strlen($arParams['T_VIDEO']) ? $arParams['T_VIDEO'] : GetMessage('T_VIDEO')?></h3>
			<div class="grid gap-6 lg:grid-cols-2">
				<?foreach ($arResult['VIDEO'] as $i => $arVideo):?>
					<div class="overflow-hidden rounded-3xl border border-black/10 bg-white shadow-sm">
						<div class="aspect-video bg-black">
							<video id="js-video_<?=$i?>" class="h-full w-full" controls preload="metadata">
								<source src="<?=$arVideo["path"]?>" type="video/mp4" />
							</video>
						</div>
						<div class="px-6 py-5 text-base font-medium text-gray-900"><?=(strlen($arVideo["title"]) ? $arVideo["title"] : $i + 1)?></div>
					</div>
				<?endforeach;?>
			</div>
		</section>
	<?endif;?>
	<?$frame->end();?>
</article>
