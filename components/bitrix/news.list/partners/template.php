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
                    <?// partners grid?>
                    <div class="sid-<?=$arSection['ID']?> grid grid-cols-2 lg:grid-cols-4 gap-6 my-12">

                        <?foreach($arSection['ITEMS'] as $i => $arItem):?>
                            <?
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                            // картинка партнёра
                            $imageSrc = false;
                            if (!empty($arItem['FIELDS']['PREVIEW_PICTURE']['ID'])) {
                                $arImage = CFile::ResizeImageGet(
                                        $arItem['FIELDS']['PREVIEW_PICTURE']['ID'],
                                        ['width' => 320, 'height' => 200],
                                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                                        true
                                );
                                $imageSrc = $arImage['src'];
                            }
                            ?>

                            <div id="<?=$this->GetEditAreaId($arItem['ID'])?>" class="group border border-gray-200">
                                <div class="h-full flex flex-col items-center text-center gap-3">

                                    <?if($imageSrc):?>
                                        <div class="w-full aspect-[16/9]  rounded flex items-center justify-center p-4">
                                            <img
                                                    src="<?=$imageSrc?>"
                                                    alt="<?=htmlspecialcharsbx($arItem['NAME'])?>"
                                                    class="max-w-full max-h-full object-contain"
                                                    loading="lazy"
                                            />
                                        </div>
                                    <?endif;?>

                                    <?if(strlen($arItem['NAME'])):?>
                                        <div class="text-sm font-medium text-gray-900 leading-snug p-4">
                                            <?=$arItem['NAME']?>
                                        </div>
                                    <?endif;?>

                                    <?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                                        <div class="text-xs text-gray-600 leading-relaxed">
                                            <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                        </div>
                                    <?endif;?>

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