<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?$j=0;?>
<div class="item-views <?=$arParams['VIEW_TYPE']?> <?=($arParams['SHOW_TABS'] == 'Y' ? 'with_tabs' : '')?> <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">
	<?// top pagination?>
	<?if($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if($arResult['SECTIONS']):?>
				<div>
					<?// group elements by sections?>
					<?foreach($arResult['SECTIONS'] as $SID => $arSection):?>
						<?
						// edit/add/delete buttons for edit mode
						$arSectionButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], array('SESSID' => false, 'CATALOG' => true));
						$this->AddEditAction($arSection['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
						$this->AddDeleteAction($arSection['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
						<div id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="tab-pane <?=(!$si++ || !$arSection['ID'] ? 'active' : '')?>">

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

                            <div class="space-y-3  my-12">
                                <?foreach($arResult['ITEMS'] as $arItem):?>
                                    <?
                                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                                    $city = trim($arItem['FIELDS']['PREVIEW_TEXT'] ?? '');
                                    $pay = $arItem['DISPLAY_PROPERTIES']['PAY']['VALUE'] ?? '';
                                    ?>

                                    <details id="<?=$this->GetEditAreaId($arItem['ID'])?>" class="group rounded-xl bg-gray-50">

                                        <!-- header -->
                                        <summary class="list-none cursor-pointer px-5 py-4 flex items-start gap-4">

                                            <div class="min-w-0 flex-1">

                                                <!-- название вакансии -->
                                                <div class="text-base sm:text-lg font-semibold text-gray-900">
                                                    <?=$arItem['NAME']?>
                                                </div>

                                                <!-- мета строка -->
                                                <?if($city || $pay):?>
                                                    <div class="mt-1 text-sm text-gray-600 flex flex-wrap gap-x-3 gap-y-1">

                                                        <?if($city):?>
                                                            <span><?=$city?></span>
                                                        <?endif;?>

                                                        <?if($city && $pay):?>
                                                            <span class="text-gray-400">•</span>
                                                        <?endif;?>

                                                        <?if($pay):?>
                                                            <span class="font-medium text-gray-900"><?=$pay?></span>
                                                        <?endif;?>

                                                    </div>
                                                <?endif;?>

                                            </div>

                                            <!-- стрелка -->
                                            <div class="shrink-0 mt-1 text-gray-500 transition-transform duration-200 group-open:rotate-180">
                                                ⌄
                                            </div>
                                        </summary>

                                        <!-- body -->
                                        <div class="px-5 pb-5 pt-1 content">


                                            <!-- основной текст -->
                                            <div class="text-sm leading-relaxed text-gray-700 space-y-4">
                                                <?if(strlen($arItem['FIELDS']['DETAIL_TEXT'])):?>
                                                    <?=$arItem['FIELDS']['DETAIL_TEXT']?>
                                                <?endif;?>
                                            </div>

                                            <div class="pt-4">
                                                <a href="#vacancy-form"
                                                   data-event="jqm" data-name="resume" data-form="formnew" data-param-id="<?=CCache::$arIBlocks[SITE_ID]['aspro_scorp_form']['aspro_scorp_resume'][0]?>" data-autoload-POST="<?=$arItem['NAME']?>" data-autohide=""
                                                   class="inline-flex items-center justify-center rounded-lg bg-gray-900 text-white px-4 py-2 text-sm hover:bg-gray-800">
                                                    Откликнуться
                                                </a>
                                            </div>

                                        </div>
                                    </details>
                                <?endforeach;?>
                            </div>
					<?endforeach;?>
				</div>
		<?if($arParams['SHOW_TABS'] == 'Y'):?>
			</div>
		<?endif;?>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>