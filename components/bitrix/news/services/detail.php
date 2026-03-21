<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
$arItemFilter = CScorp::GetCurrentElementFilter($arResult['VARIABLES'], $arParams);
$arElement = CCache::CIBlockElement_GetList(
	array('CACHE' => array('TAG' => CCache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'N')),
	$arItemFilter,
	false,
	false,
	array('ID', 'PREVIEW_TEXT', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'LIST_PAGE_URL', 'PROPERTY_LINK_PROJECTS', 'PROPERTY_LINK_GOODS', 'PROPERTY_LINK_REVIEWS', 'PROPERTY_LINK_STAFF', 'PROPERTY_LINK_SERVICES')
);
?>
<?if (!$arElement && $arParams['SET_STATUS_404'] !== 'Y'):?>
	<div class="rounded-3xl border border-amber-200 bg-amber-50 px-6 py-5 text-amber-900"><?=GetMessage("ELEMENT_NOTFOUND")?></div>
<?elseif (!$arElement && $arParams['SET_STATUS_404'] === 'Y'):?>
	<?CScorp::goto404Page();?>
<?else:?>
	<?CScorp::AddMeta(
		array(
			'og:description' => $arElement['PREVIEW_TEXT'],
			'og:image' => (($arElement['PREVIEW_PICTURE'] || $arElement['DETAIL_PICTURE']) ? CFile::GetPath(($arElement['PREVIEW_PICTURE'] ? $arElement['PREVIEW_PICTURE'] : $arElement['DETAIL_PICTURE'])) : false),
		)
	);?>
	<div class="space-y-16 lg:space-y-20">
		<div class="detail <?=($templateName = $component->{'__template'}->{'__name'})?>">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"services",
				Array(
					"S_ASK_QUESTION" => $arParams["S_ASK_QUESTION"],
					"S_ORDER_SERVICE" => $arParams["S_ORDER_SERVICE"],
					"T_GALLERY" => $arParams["T_GALLERY"],
					"T_DOCS" => $arParams["T_DOCS"],
					"T_GOODS" => $arParams["T_GOODS"],
					"T_SERVICES" => $arParams["T_SERVICES"],
					"T_PROJECTS" => $arParams["T_PROJECTS"],
					"T_REVIEWS" => $arParams["T_REVIEWS"],
					"T_STAFF" => $arParams["T_STAFF"],
					"T_VIDEO" => $arParams["T_VIDEO"],
					"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
					"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
					"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
					"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
					"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"META_KEYWORDS" => $arParams["META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
					"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
					"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
					"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
					"ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
					"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
					"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
					"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
					"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
					"CHECK_DATES" => $arParams["CHECK_DATES"],
					"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
					"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
					"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
					"USE_SHARE" => $arParams["USE_SHARE"],
					"SHARE_HIDE" => $arParams["SHARE_HIDE"],
					"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
					"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
					"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
				),
				$component
			);?>
		</div>

		<?if (in_array('LINK_PROJECTS', $arParams['DETAIL_PROPERTY_CODE']) && $arElement['PROPERTY_LINK_PROJECTS_VALUE']):?>
			<?$arProjects = CCache::CIBlockElement_GetList(
				array('CACHE' => array('TAG' => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]['aspro_scorp_content']['aspro_scorp_projects'][0]), 'MULTI' => 'Y')),
				array('ID' => $arElement['PROPERTY_LINK_PROJECTS_VALUE'], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'),
				false,
				false,
				array('ID', 'NAME', 'IBLOCK_ID', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE')
			);?>
			<?if ($arProjects):?>
				<section class="space-y-8 pt-2">
					<h2 class="text-3xl font-semibold text-gray-950"><?=strlen($arParams['T_PROJECTS']) ? $arParams['T_PROJECTS'] : GetMessage('T_PROJECTS')?></h2>
					<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
						<?foreach ($arProjects as $arItem):?>
							<?
							$arItemButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], $arItem['ID'], 0, array('SESSID' => false, 'CATALOG' => true));
							$this->AddEditAction($arItem['ID'], $arItemButtons['edit']['edit_element']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
							$this->AddDeleteAction($arItem['ID'], $arItemButtons['edit']['delete_element']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							$thumb = CFile::GetPath($arItem['PREVIEW_PICTURE'] ? $arItem['PREVIEW_PICTURE'] : $arItem['DETAIL_PICTURE']);
							?>
							<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="group flex h-full flex-col overflow-hidden rounded-3xl border border-black/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
								<div class="aspect-[4/3] overflow-hidden bg-gray-100">
									<?if ($thumb):?>
										<img src="<?=$thumb?>" alt="<?=htmlspecialcharsbx($arItem['NAME'])?>" title="<?=htmlspecialcharsbx($arItem['NAME'])?>" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy" />
									<?else:?>
										<div class="flex h-full items-center justify-center bg-gray-200 text-sm uppercase tracking-[0.3em] text-gray-500">Project</div>
									<?endif;?>
								</div>
								<div class="flex flex-1 flex-col px-6 py-5">
									<div class="text-xl font-semibold leading-snug text-gray-950"><?=$arItem['NAME']?></div>
									<div class="mt-4 text-sm uppercase tracking-[0.2em] text-accent"><?=GetMessage('TO_ALL')?></div>
								</div>
							</a>
						<?endforeach;?>
					</div>
				</section>
			<?endif;?>
		<?endif;?>

		<?if (in_array('LINK_REVIEWS', $arParams['DETAIL_PROPERTY_CODE']) && $arElement['PROPERTY_LINK_REVIEWS_VALUE']):?>
			<?$arReviews = CCache::CIBlockElement_GetList(
				array('CACHE' => array('TAG' => CCache::GetIBlockCacheTag(CCache::$arIBlocks[SITE_ID]['aspro_scorp_content']['aspro_scorp_reviews'][0]), 'MULTI' => 'Y')),
				array('ID' => $arElement['PROPERTY_LINK_REVIEWS_VALUE'], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'),
				false,
				false,
				array('ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_POST', 'PROPERTY_DOCUMENTS', 'PREVIEW_TEXT')
			);?>
			<?if ($arReviews):?>
				<section class="space-y-8 pt-2">
					<h2 class="text-3xl font-semibold text-gray-950"><?=strlen($arParams['T_REVIEWS']) ? $arParams['T_REVIEWS'] : GetMessage('T_REVIEWS')?></h2>
					<div class="grid gap-6 lg:grid-cols-2">
						<?foreach ($arReviews as $arItem):?>
							<?
							$arItemButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], $arItem['ID'], 0, array('SESSID' => false, 'CATALOG' => true));
							$this->AddEditAction($arItem['ID'], $arItemButtons['edit']['edit_element']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
							$this->AddDeleteAction($arItem['ID'], $arItemButtons['edit']['delete_element']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							?>
							<div class="rounded-3xl border border-black/10 bg-gray-50 px-6 py-6" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
								<div class="content text-base text-gray-700"><?=$arItem['PREVIEW_TEXT']?></div>
								<?if ($arItem['PROPERTY_DOCUMENTS_VALUE']):?>
									<div class="mt-6 grid gap-3 sm:grid-cols-2">
										<?foreach ((array)$arItem['PROPERTY_DOCUMENTS_VALUE'] as $docID):?>
											<?$arFile = CScorp::get_file_info($docID);?>
											<?
											$fileName = substr($arFile['ORIGINAL_NAME'], 0, strrpos($arFile['ORIGINAL_NAME'], '.'));
											$fileTitle = (strlen($arFile['DESCRIPTION']) ? $arFile['DESCRIPTION'] : $fileName);
											?>
											<a href="<?=$arFile['SRC']?>" target="_blank" class="rounded-3xl border border-black/10 bg-white px-4 py-3 text-sm text-gray-700 transition hover:border-accent hover:text-link">
												<span class="block font-medium"><?=$fileTitle?></span>
												<span class="mt-1 block text-xs text-gray-500"><?=GetMessage('CT_NAME_SIZE')?>: <?=CScorp::filesize_format($arFile['FILE_SIZE']);?></span>
											</a>
										<?endforeach;?>
									</div>
								<?endif;?>
								<div class="mt-6 border-t border-black/10 pt-4">
									<div class="text-lg font-semibold text-gray-950"><?=$arItem['NAME']?></div>
									<?if ($arItem['PROPERTY_POST_VALUE']):?>
										<div class="text-sm text-gray-500"><?=$arItem['PROPERTY_POST_VALUE']?></div>
									<?endif;?>
								</div>
							</div>
						<?endforeach;?>
					</div>
				</section>
			<?endif;?>
		<?endif;?>

		<?if (in_array('LINK_STAFF', $arParams['DETAIL_PROPERTY_CODE']) && $arElement['PROPERTY_LINK_STAFF_VALUE']):?>
			<section class="space-y-8 pt-2">
				<h2 class="text-3xl font-semibold text-gray-950"><?=strlen($arParams['T_STAFF']) ? $arParams['T_STAFF'] : (count($arElement['PROPERTY_LINK_STAFF_VALUE']) > 1 ? GetMessage('T_STAFF2') : GetMessage('T_STAFF1'))?></h2>
				<?global $arrrFilter; $arrrFilter = array('ID' => $arElement['PROPERTY_LINK_STAFF_VALUE']);?>
				<?$APPLICATION->IncludeComponent("bitrix:news.list", "staff-linked", array(
					"IBLOCK_TYPE" => "aspro_scorp_content",
					"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_scorp_content"]["aspro_scorp_staff"][0],
					"NEWS_COUNT" => "30",
					"SORT_BY1" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "arrrFilter",
					"FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", ""),
					"PROPERTY_CODE" => array("EMAIL", "POST", "PHONE", ""),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "360000",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "N",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"SET_TITLE" => "N",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "Y",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"PAGER_TEMPLATE" => "",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Новости",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"VIEW_TYPE" => "table",
					"SHOW_TABS" => "N",
					"SHOW_SECTION_PREVIEW_DESCRIPTION" => "N",
					"IMAGE_POSITION" => "left",
					"COUNT_IN_LINE" => "3",
					"AJAX_OPTION_ADDITIONAL" => ""
				), false, array("HIDE_ICONS" => "Y"));?>
			</section>
		<?endif;?>

		<?if (in_array('LINK_GOODS', $arParams['DETAIL_PROPERTY_CODE']) && $arElement['PROPERTY_LINK_GOODS_VALUE']):?>
			<section class="space-y-8 pt-2">
				<h2 class="text-3xl font-semibold text-gray-950"><?=strlen($arParams['T_GOODS']) ? $arParams['T_GOODS'] : GetMessage('T_GOODS')?></h2>
				<?global $arrrFilter; $arrrFilter = array('ID' => $arElement['PROPERTY_LINK_GOODS_VALUE']);?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"catalog-linked",
					Array(
						"S_ORDER_PRODUCT" => $arParams["S_ORDER_PRODUCT"],
						"IBLOCK_TYPE" => "aspro_scorp_catalog",
						"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_scorp_catalog"]["aspro_scorp_catalog"][0],
						"NEWS_COUNT" => "20",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "SORT",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "arrrFilter",
						"FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PICTURE", ""),
						"PROPERTY_CODE" => array("PRICE", "PRICEOLD", "ARTICLE", "FORM_ORDER", "STATUS", ""),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"SET_TITLE" => "N",
						"SET_STATUS_404" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "36000000",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "Новости",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"SHOW_DETAIL_LINK" => "Y",
						"COUNT_IN_LINE" => "3",
						"IMAGE_POSITION" => "left",
					),
					false,
					array("HIDE_ICONS" => "Y")
				);?>
			</section>
		<?endif;?>

		<?if (in_array('LINK_SERVICES', $arParams['DETAIL_PROPERTY_CODE']) && $arElement['PROPERTY_LINK_SERVICES_VALUE']):?>
			<section class="space-y-8 pt-2">
				<h2 class="text-3xl font-semibold text-gray-950"><?=strlen($arParams['T_SERVICES']) ? $arParams['T_SERVICES'] : GetMessage('T_SERVICES')?></h2>
				<?global $arrrFilter; $arrrFilter = array("ID" => $arElement["PROPERTY_LINK_SERVICES_VALUE"]);?>
				<?$APPLICATION->IncludeComponent("bitrix:news.list", "services", array(
					"IBLOCK_TYPE" => "aspro_scorp_content",
					"IBLOCK_ID" => CCache::$arIBlocks[SITE_ID]["aspro_scorp_content"]["aspro_scorp_services"][0],
					"NEWS_COUNT" => "20",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "arrrFilter",
					"FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", ""),
					"PROPERTY_CODE" => array("", ""),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "N",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"SET_TITLE" => "N",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Новости",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"VIEW_TYPE" => "list",
					"SHOW_TABS" => "N",
					"SHOW_IMAGE" => "Y",
					"SHOW_NAME" => "Y",
					"SHOW_DETAIL" => "Y",
					"IMAGE_POSITION" => "top",
					"COUNT_IN_LINE" => "3",
					"AJAX_OPTION_ADDITIONAL" => ""
				), false, array("HIDE_ICONS" => "Y"));?>
			</section>
		<?endif;?>
	</div>
	<?
	if (is_array($arElement['IBLOCK_SECTION_ID']) && count($arElement['IBLOCK_SECTION_ID']) > 1) {
		CScorp::CheckAdditionalChainInMultiLevel($arResult, $arParams, $arElement);
	}
	?>
	<div class="pt-10 pb-12 md:pt-12 md:pb-16">
		<div class="flex justify-center">
			<a class="inline-flex items-center gap-2 rounded-3xl border border-black/10 px-6 py-4 text-sm font-medium text-accent transition hover:border-accent hover:text-link" href="<?=$arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']?>">
				<span>&larr;</span>
				<span><?=GetMessage('BACK_LINK')?></span>
			</a>
		</div>
	</div>
<?endif;?>
