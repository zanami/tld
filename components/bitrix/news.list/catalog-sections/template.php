<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<?if($arResult['SECTIONS']):?>
    <div class="catalog item-views table container mx-auto my-12">
        <ul class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
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
                        class="h-full overflow-hidden flex flex-col rounded-3xl bg-white border border-gray-100 shadow-sm"
                >
                    <?if($bShowSectionImage):?>
                        <a
                                href="<?=$arItem['SECTION_PAGE_URL']?>"
                                class="relative block h-56 overflow-hidden rounded-t-3xl"
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

                    <div class="flex flex-col flex-1 px-6 pt-6 pb-4">
                        <?// section name?>
                        <?if(in_array('NAME', $arParams['FIELD_CODE'])):?>
                            <div class="mb-2">
                                <a href="<?=$arItem['SECTION_PAGE_URL']?>" class="no-underline">
                                    <h3 class="text-xl/7 font-semibold text-gray-900">
                                        <?=$arItem['NAME']?>
                                    </h3>
                                </a>
                            </div>
                        <?endif;?>
                    </div>
                </li>
            <?endforeach;?>
        </ul>
    </div>
<?endif;?>