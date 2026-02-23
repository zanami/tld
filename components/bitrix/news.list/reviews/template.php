<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views <?=$arParams['VIEW_TYPE']?> <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">
	<?// top pagination?>
	<?if($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if($arResult['SECTIONS']):?>
		<div class="group-content my-12">
			<?// group elements by sections?>
			<?foreach($arResult['SECTIONS'] as $si => $arSection):?>
				<?if($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y'):?>
                    <?if(strlen($arSection['NAME'])):?>
                        <h3 class="text-2xl font-semibold text-gray-900 tracking-tight mb-2">
                            <?=$arSection['NAME']?>
                        </h3>
                    <?endif;?>

                    <?if(strlen($arSection['DESCRIPTION'])):?>
                        <div class="text-sm leading-relaxed text-gray-600 mb-6 max-w-3xl">
                            <?=$arSection['DESCRIPTION']?>
                        </div>
                    <?endif;?>
				<?endif;?>

				<?// show section items?>
                <div class="sid-<?=$arSection['ID']?> space-y-8">

                    <?foreach($arSection['ITEMS'] as $i => $arItem):?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                        $company = $arItem['DISPLAY_PROPERTIES']['POST']['VALUE'] ?? '';
                        $docs = (array)($arItem['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'] ?? []);
                        ?>

                        <figure id="<?=$this->GetEditAreaId($arItem['ID'])?>" class="max-w-4xl">
                            <!-- bubble -->
                            <div class="relative rounded-2xl bg-gray-50 px-6 py-6 sm:px-8 sm:py-7">
                                <!-- tail -->
                                <div class="absolute left-10 -bottom-3 w-6 h-6 bg-gray-50 rotate-45 rounded-sm"></div>

                                <!-- big quotes -->
                                <div class="absolute left-6 top-6 text-6xl leading-none text-orange-500 select-none" aria-hidden="true">
                                    “
                                </div>

                                <div class="pl-10">
                                    <?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                        <div class="text-lg sm:text-xl font-medium text-gray-900 leading-snug">
                                            <?if(($arItem['PREVIEW_TEXT_TYPE'] ?? 'text') === 'text'):?>
                                                <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                            <?else:?>
                                                <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                            <?endif;?>
                                        </div>
                                    <?endif;?>

                                    <?if(!empty($docs)):?>
                                        <div class="mt-6 space-y-3">
                                            <?foreach($docs as $docID):?>
                                                <?$arFile = CScorp::get_file_info($docID);?>
                                                <?
                                                $fileName = substr($arFile['ORIGINAL_NAME'], 0, strrpos($arFile['ORIGINAL_NAME'], '.'));
                                                $fileTitle = (strlen($arFile['DESCRIPTION']) ? $arFile['DESCRIPTION'] : $fileName);
                                                $fileExt = strtoupper($arFile['TYPE'] ?? '');
                                                $fileSize = CScorp::filesize_format($arFile['FILE_SIZE']);
                                                ?>

                                                <a href="<?=$arFile['SRC']?>"
                                                   target="_blank"
                                                   title="<?=$fileTitle?>"
                                                   class="flex items-center gap-4"
                                                >
                                                    <!-- file icon -->
                                                    <div class="shrink-0 w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-700">
                                                        <?=$fileExt ?: 'FILE'?>
                                                    </div>

                                                    <div class="min-w-0">
                                                        <div class="text-base font-medium text-gray-900 truncate">
                                                            <?=$fileTitle?>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            Размер: <?=$fileSize?>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?endforeach;?>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>

                            <!-- signature -->
                            <figcaption class="mt-6 pl-10">
                                <?if(strlen($arItem['NAME'])):?>
                                    <div class="text-xl font-semibold text-gray-900">
                                        <?=$arItem['NAME']?>
                                    </div>
                                <?endif;?>
                                <?if(strlen($company)):?>
                                    <div class="text-base text-gray-500">
                                        <?=$company?>
                                    </div>
                                <?endif;?>
                            </figcaption>
                        </figure>

                    <?endforeach;?>

                </div>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>