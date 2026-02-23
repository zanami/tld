<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views list <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">
	<?// top pagination?>
	<?if($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

    <div class="relative py-12">
        <?foreach($arResult['ITEMS'] as $arItem):?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

            // YEAR (замени код свойства при необходимости)
            $year = $arItem['DISPLAY_PROPERTIES']['YEAR']['VALUE'] ?? '';

            // image
            $imageSrc = false;
            if (!empty($arItem['FIELDS']['PREVIEW_PICTURE']['ID'])) {
                $arImage = CFile::ResizeImageGet(
                        $arItem['FIELDS']['PREVIEW_PICTURE']['ID'],
                        ['width' => 320, 'height' => 320],
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        true
                );
                $imageSrc = $arImage['src'];
            }
            ?>

            <div class="relative flex gap-6" id="<?=$this->GetEditAreaId($arItem['ID'])?>">

                <!-- левая колонка (год + линия) -->
                <div class="relative w-24 flex-shrink-0 text-right">

                    <?if($year):?>
                        <div class="font-bold text-lg leading-none text-gray-900">
                            <?=$year?>
                        </div>
                    <?endif;?>

                    <!-- вертикальная линия -->
                    <div class="absolute right-3 top-0 bottom-0 w-px bg-gray-200"></div>

                    <!-- точка -->
                    <div class="absolute right-[7px] top-5 w-3.5 h-3.5 rounded-full bg-gray-900 ring-4 ring-white"></div>
                </div>

                <!-- карточка -->
                <div class="flex-1">
                    <div class="p-5">

                        <?if(strlen($arItem['NAME'])):?>
                            <div class="font-semibold text-xl text-gray-900 mb-2">
                                <?=$arItem['NAME']?>
                            </div>
                        <?endif;?>

                        <?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
                            <div class="text-gray-600">
                                <?if($arItem['PREVIEW_TEXT_TYPE'] == 'text'):?>
                                    <p><?=$arItem['FIELDS']['PREVIEW_TEXT']?></p>
                                <?else:?>
                                    <?=$arItem['FIELDS']['PREVIEW_TEXT']?>
                                <?endif;?>
                            </div>
                        <?endif;?>

                        <?if($imageSrc):?>
                            <div class="mt-4">
                                <img
                                        src="<?=$imageSrc?>"
                                        alt="<?=htmlspecialcharsbx($arItem['NAME'])?>"
                                        class="rounded-lg max-w-full h-auto"
                                        loading="lazy"
                                />
                            </div>
                        <?endif;?>

                    </div>
                </div>

            </div>
        <?endforeach;?>
    </div>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>