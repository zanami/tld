<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$view = $arParams['SECTIONS_VIEW'] ?? 'cards'; // cards | links

?>

<?if($arResult['SECTIONS']):?>
    <?php if ($view === 'list'): ?>
        <div class="catalog item-views table container mx-auto px-4 my-12">
            <div class="flex flex-wrap gap-2">
                <?php foreach ($arResult['SECTIONS'] as $arItem): ?>
                    <a href="<?=$arItem['SECTION_PAGE_URL']?>"
                       class="text-shadow-slate-900 rounded-md bg-accent px-4 py-3">
                        <?=htmlspecialcharsbx($arItem['NAME'])?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="catalog item-views table container mx-auto px-4 my-12">
            <ul class="grid gap-8 grid-cols-1 md:grid-cols-3">
                <?foreach($arResult['SECTIONS'] as $arItem):?>
                    <?
                    // edit/add/delete buttons for edit mode
                    $arSectionButtons = CIBlock::GetPanelButtons(
                            $arItem['IBLOCK_ID'],
                            0,
                            $arItem['ID'],
                            ['SESSID' => false, 'CATALOG' => true]
                    );
                    $this->AddEditAction(
                            $arItem['ID'],
                            $arSectionButtons['edit']['edit_section']['ACTION_URL'],
                            CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_EDIT')
                    );
                    $this->AddDeleteAction(
                            $arItem['ID'],
                            $arSectionButtons['edit']['delete_section']['ACTION_URL'],
                            CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_DELETE'),
                            ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]
                    );

                    // preview picture
                    $bShowSectionImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);
                    if($bShowSectionImage){
                        $bImage = !empty($arItem['PICTURE']);
                        $arSectionImage = ($bImage
                                ? CFile::ResizeImageGet(
                                        $arItem['PICTURE'],
                                        ['width' => 400, 'height' => 260],
                                        BX_RESIZE_IMAGE_PROPORTIONAL,
                                        true
                                )
                                : []
                        );
                        $imageSectionSrc = ($bImage
                                ? $arSectionImage['src']
                                : SITE_TEMPLATE_PATH.'/images/noimage_sections.png'
                        );
                    }
                    ?>
                    <li
                            id="<?=$this->GetEditAreaId($arItem['ID'])?>"
                            class="h-full overflow-hidden flex flex-col rounded-3xl bg-white"
                    >
                        <?if($bShowSectionImage):?>
                            <a
                                    href="<?=$arItem['SECTION_PAGE_URL']?>"
                                    class="relative block aspect-16/9 overflow-hidden rounded-t-3xl"
                            >
                                <img
                                        src="<?=$imageSectionSrc?>"
                                        alt="<?=$arItem['NAME']?>"
                                        title="<?=$arItem['NAME']?>"
                                        class="w-full h-full object-cover"
                                />
                                <!-- диагональный градиент-оверлей -->
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-black/40 via-black/10 to-transparent"></div>
                            </a>
                        <?endif;?>

                        <div class="flex flex-col flex-1 pt-6 pb-4">
                            <?// section name?>
                            <?if(in_array('NAME', $arParams['FIELD_CODE'])):?>
                                <div class="mb-2">
                                    <a href="<?=$arItem['SECTION_PAGE_URL']?>" class="no-underline">
                                        <h3 class="text-xl/7 font-semibold text-amber-500">
                                            <?=$arItem['NAME']?>
                                        </h3>
                                    </a>
                                </div>
                            <?endif;?>
                            <?// section preview text?>
                            <?if(strlen($arItem['UF_INFOTEXT'])):?>
                                <div class="font-thin text-xl">
                                    <?=$arItem['UF_INFOTEXT']?>
                                </div>
                            <?endif;?>
                        </div>
                    </li>
                <?endforeach;?>
            </ul>
        </div>
    <?endif;?>
<?endif;?>