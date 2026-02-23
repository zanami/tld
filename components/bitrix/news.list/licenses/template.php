<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views <?=$arParams['VIEW_TYPE']?> <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">
	<?// top pagination?>
	<?if($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if($arResult['SECTIONS']):?>
		<div class="group-content">
			<?// group elements by sections?>
			<?foreach($arResult['SECTIONS'] as $si => $arSection):?>
				<?
				// edit/add/delete buttons for edit mode
				$arSectionButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], array('SESSID' => false, 'CATALOG' => true));
				$this->AddEditAction($arSection['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="tab-pane <?=(!$si++ || !$arSection['ID'] ? 'active' : '')?>">
					<?if($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y'):?>
						<?// section name?>
                        <?if(strlen($arSection['NAME'])):?>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                <?=$arSection['NAME']?>
                            </h3>
                        <?endif;?>

                        <?if(strlen($arSection['DESCRIPTION'])):?>
                            <div class="text-sm text-gray-600 mb-6 max-w-3xl">
                                <?=$arSection['DESCRIPTION']?>
                            </div>
                        <?endif;?>
					<?endif;?>

                    <?// show section items (tailwind, with original link/fancybox behavior)?>
                    <div class="sid-<?=$arSection['ID']?> divide-y divide-gray-200/60 mb-12">
                        <?foreach($arSection['ITEMS'] as $i => $arItem):?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                            // use detail link?
                            $bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);

                            // year (optional) - replace YEAR if needed
                            $year = $arItem['DISPLAY_PROPERTIES']['YEAR']['VALUE'] ?? '';

                            // image sources
                            $bImage = !empty($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
                            $imageSrc = ($bImage ? $arItem['FIELDS']['PREVIEW_PICTURE']['SRC'] : false);
                            $imageDetailSrc = (!empty($arItem['FIELDS']['DETAIL_PICTURE']['SRC']) ? $arItem['FIELDS']['DETAIL_PICTURE']['SRC'] : false);

                            $imgAlt = ($bImage ? ($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME']) : $arItem['NAME']);
                            $imgTitle = ($bImage ? ($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME']) : $arItem['NAME']);

                            // decide how image is linked (repeat your original logic)
                            $useFancybox = (!$bDetailLink && $imageDetailSrc);
                            ?>

                            <div id="<?=$this->GetEditAreaId($arItem['ID'])?>" class="py-4">
                                <div class="flex items-start gap-4">

                                    <?if($bImage):?>
                                        <div class="shrink-0">
                                            <?if($bDetailLink):?>
                                                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="block">
                                                    <img
                                                            src="<?=$imageSrc?>"
                                                            alt="<?=htmlspecialcharsbx($imgAlt)?>"
                                                            title="<?=htmlspecialcharsbx($imgTitle)?>"
                                                            class="w-28 object-contain rounded "
                                                            loading="lazy"
                                                    />
                                                </a>
                                            <?elseif($useFancybox):?>
                                                <a
                                                        href="<?=$imageDetailSrc?>"
                                                        alt="<?=htmlspecialcharsbx($imgAlt)?>"
                                                        title="<?=htmlspecialcharsbx($imgTitle)?>"
                                                        data-fancybox="gallery"
                                                        class="block img-inside "
                                                >
                                                    <img
                                                            src="<?=$imageSrc?>"
                                                            alt="<?=htmlspecialcharsbx($imgAlt)?>"
                                                            title="<?=htmlspecialcharsbx($imgTitle)?>"
                                                            class="w-28 object-contain rounded"
                                                            loading="lazy"
                                                    />
                                                </a>
                                            <?else:?>
                                                <img
                                                        src="<?=$imageSrc?>"
                                                        alt="<?=htmlspecialcharsbx($imgAlt)?>"
                                                        title="<?=htmlspecialcharsbx($imgTitle)?>"
                                                        class="w-28 object-contain rounded "
                                                        loading="lazy"
                                                />
                                            <?endif;?>
                                        </div>
                                    <?endif;?>

                                    <div class="min-w-0 flex-1">

                                        <?if($year):?>
                                            <div class="text-xs text-gray-500 mb-1">
                                                <?=$year?>
                                            </div>
                                        <?endif;?>

                                        <?if(strlen($arItem['NAME'])):?>
                                            <div class="text-base font-medium text-gray-900">
                                                <?if($bDetailLink):?>
                                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="hover:underline">
                                                        <?=$arItem['NAME']?>
                                                    </a>
                                                <?else:?>
                                                    <?=$arItem['NAME']?>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>

                                        <?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                            <div class="mt-1 text-sm text-gray-600">
                                                <?if($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
                                                    <p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
                                                <?else:?>
                                                    <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                                <?endif;?>
                                            </div>
                                        <?endif;?>

                                    </div>

                                </div>
                            </div>

                        <?endforeach;?>
                    </div>

				</div>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>