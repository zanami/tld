<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
$displayName = $arParams['DISPLAY_NAME'] != 'N' && strlen($arResult['NAME']);
$displayPeriod = strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arResult['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', (array)$arParams['FIELD_CODE']));
$displayPropertiesCodes = array_diff(array_keys((array)$arResult['DISPLAY_PROPERTIES']), array('PERIOD', 'PHOTOS', 'DOCUMENTS', 'LINK_GOODS', 'LINK_STAFF', 'LINK_REVIEWS', 'LINK_PROJECTS', 'LINK_SERVICES', 'FORM_ORDER', 'FORM_QUESTION', 'PHOTOPOS'));
$detailImage = $arResult['FIELDS']['DETAIL_PICTURE'] ? $arResult['DETAIL_PICTURE']['SRC'] : '';
$detailImageTitle = strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['TITLE']) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME']);
$detailImageAlt = strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['ALT']) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME']);
$galleryItems = $arResult['GALLERY'];
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
?>
<div class="space-y-16 lg:space-y-20">
	<div class="grid gap-12 xl:grid-cols-[minmax(0,1fr)_24rem]">
		<div class="space-y-10">
			<?if ($displayName):?>
				<h2 class="text-4xl font-semibold tracking-tight text-gray-950"><?=$arResult['NAME']?></h2>
			<?endif;?>

			<?if ($displayPeriod):?>
				<div>
					<?if (strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE'])):?>
						<span class="inline-flex rounded-full bg-accent/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-link"><?=$arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></span>
					<?else:?>
						<span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-gray-600"><?=$arResult['DISPLAY_ACTIVE_FROM']?></span>
					<?endif;?>
				</div>
			<?endif;?>

			<?if (strlen($arResult['FIELDS']['PREVIEW_TEXT']) || strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
				<div class="space-y-8 text-gray-700">
					<?if (strlen($arResult['FIELDS']['PREVIEW_TEXT'])):?>
						<div class="text-2xl leading-9 font-thin max-w-3xl">
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

		<div class="space-y-8">
			<?if ($leadGalleryItem):?>
				<a href="<?=$leadGalleryItem['DETAIL']['SRC']?>" data-fancybox="service-main" class="group block overflow-hidden rounded-3xl bg-gray-100 shadow-sm">
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
		</div>
	</div>

	<?if ($galleryItems):?>
		<section class="space-y-8 pt-2">
			<h3 class="text-5xl mb-10 font-semibold text-gray-950"><?=strlen($arParams['T_GALLERY']) ? $arParams['T_GALLERY'] : GetMessage('T_GALLERY')?></h3>
			<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
				<?foreach ($galleryItems as $index => $arPhoto):?>
					<a href="<?=$arPhoto['DETAIL']['SRC']?>" data-fancybox="service-gallery" class="group overflow-hidden rounded-3xl bg-gray-100 <?=$index === 0 ? 'sm:col-span-2 sm:row-span-2' : ''?>">
						<img src="<?=$arPhoto['PREVIEW']['src'] ?? $arPhoto['DETAIL']['SRC']?>" alt="<?=htmlspecialcharsbx($arPhoto['ALT'] ?? $detailImageAlt)?>" title="<?=htmlspecialcharsbx($arPhoto['TITLE'] ?? $detailImageTitle)?>" class="w-full object-cover transition duration-300 group-hover:scale-105 <?=$index === 0 ? 'h-80 sm:h-full min-h-80' : 'h-52'?>" loading="lazy" />
					</a>
				<?endforeach;?>
			</div>
		</section>
	<?endif;?>

	<?if ($arResult['DISPLAY_PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES' || $arResult['DISPLAY_PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES'):?>
		<section class="grid gap-8 pt-2 lg:grid-cols-2">
			<?if ($arResult['DISPLAY_PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES'):?>
				<div class="rounded-3xl border border-black/10 bg-white p-8 shadow-sm space-y-5">
					<div class="text-sm font-semibold uppercase tracking-[0.25em] text-gray-500">Консультация</div>
					<h3 class="mt-3 text-3xl font-semibold text-gray-950">Есть вопрос по услуге?</h3>
					<div class="content text-base text-gray-700">
						<?$APPLICATION->IncludeComponent(
							'bitrix:main.include',
							'',
							Array(
								'AREA_FILE_SHOW' => 'file',
								'PATH' => SITE_DIR.'include/ask_question.php',
								'EDIT_TEMPLATE' => ''
							)
						);?>
					</div>
					<div>
						<span class="inline-block px-12 py-4 rounded-md bg-gray-400 text-gray-50 uppercase cursor-pointer" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]['aspro_scorp_form']['aspro_scorp_question'][0]?>" data-name="question" data-form="formnew" data-autoload-NEED_PRODUCT="<?=$arResult['NAME']?>">
							<span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : GetMessage('S_ASK_QUESTION'))?></span>
						</span>
					</div>
				</div>
			<?endif;?>

			<?if ($arResult['DISPLAY_PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES'):?>
				<div class="rounded-3xl border border-accent/30 bg-accent/10 p-8 shadow-sm space-y-5">
					<div class="text-sm font-semibold uppercase tracking-[0.25em] text-link">Заявка</div>
					<h3 class="mt-3 text-3xl font-semibold text-gray-950">Нужен расчет или коммерческое предложение?</h3>
					<div class="content text-base text-gray-700">
						<?$APPLICATION->IncludeComponent(
							'bitrix:main.include',
							'',
							Array(
								'AREA_FILE_SHOW' => 'file',
								'PATH' => SITE_DIR.'include/ask_services.php',
								'EDIT_TEMPLATE' => ''
							)
						);?>
					</div>
					<div>
						<span class="inline-block px-12 py-4 rounded-md bg-accent text-gray-950 uppercase cursor-pointer" data-event="jqm" data-param-id="<?=CCache::$arIBlocks[SITE_ID]['aspro_scorp_form']['aspro_scorp_order_services'][0]?>" data-name="order_services" data-form="formnew" data-autoload-service="<?=$arResult['NAME']?>">
							<span><?=(strlen($arParams['S_ORDER_SERVICE']) ? $arParams['S_ORDER_SERVICE'] : GetMessage('S_ORDER_SERVICE'))?></span>
						</span>
					</div>
				</div>
			<?endif;?>
		</section>
	<?endif;?>

	<?if ($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE']):?>
		<section class="space-y-8 pt-2">
			<h3 class="text-5xl mb-10 font-semibold text-gray-950"><?=strlen($arParams['T_DOCS']) ? $arParams['T_DOCS'] : GetMessage('T_DOCS')?></h3>
			<div class="flex flex-col gap-6 text-xl font-thin leading-8">
				<?foreach ($arResult['PROPERTIES']['DOCUMENTS']['VALUE'] as $docID):?>
					<?$arItem = CScorp::get_file_info($docID);?>
					<?
					$fileName = substr($arItem['ORIGINAL_NAME'], 0, strrpos($arItem['ORIGINAL_NAME'], '.'));
					$fileTitle = (strlen($arItem['DESCRIPTION']) ? $arItem['DESCRIPTION'] : $fileName);
					?>
					<div class="flex gap-3">
						<?if ($arItem['TYPE'] == 'pdf'):?>
							<svg role="presentation" style="width:50px;" fill="#ff8562" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90"><path d="M90 28H80V16.4L63.6 0H10v28H0v40h10v22h70V68h10V28zM65 8.5l6.5 6.5H65V8.5zM15 5h45v15h15v8H15V5zm60 80H15V68h60v17zm10-22H5V33h80v30z"></path><path d="M25 53h2.5c4.1 0 7.5-3.4 7.5-7.5S31.6 38 27.5 38h-5c-1.4 0-2.5 1.1-2.5 2.5V58h5v-5zm0-10h2.5c1.4 0 2.5 1.1 2.5 2.5S28.9 48 27.5 48H25v-5zM52.5 50.5v-5c0-4.1-3.4-7.5-7.5-7.5h-7.5v20H45c4.1 0 7.5-3.4 7.5-7.5zm-10-7.5H45c1.4 0 2.5 1.1 2.5 2.5v5c0 1.4-1.1 2.5-2.5 2.5h-2.5V43zM60 50.5h7.5v-5H60V43h10v-5H57.5c-1.4 0-2.5 1.1-2.5 2.5V58h5v-7.5z"></path></svg>
						<?endif;?>
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
			<h3 class="text-5xl mb-10 font-semibold text-gray-950"><?=strlen($arParams['T_VIDEO']) ? $arParams['T_VIDEO'] : GetMessage('T_VIDEO')?></h3>
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
</div>
