<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views list <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=($templateName = $component->{'__parent'}->{'__template'}->{'__name'})?>">

	<?if($arResult['ITEMS']):?>
    <?php
    $bShowImage = in_array('PREVIEW_PICTURE', (array)$arParams['FIELD_CODE'], true);
    ?>
    <div class="container mx-auto px-4 grid gap-10 grid-cols-1 md:grid-cols-2 xl:grid-cols-4"
         itemscope itemtype="https://schema.org/ItemList">

        <?php foreach ($arResult['ITEMS'] as $pos => $arItem): ?>
        <?php
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

        $bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N'
                && (!strlen($arItem['DETAIL_TEXT']) ? $arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' : true);

        // картинка
        $imageSrc = SITE_TEMPLATE_PATH.'/images/noimage_product.png';
        if ($bShowImage && !empty($arItem['FIELDS']['PREVIEW_PICTURE']['ID'])) {
            $arImage = CFile::ResizeImageGet(
                    $arItem['FIELDS']['PREVIEW_PICTURE']['ID'],
                    ['width' => 800, 'height' => 600],
                    BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                    true
            );
            if (!empty($arImage['src'])) {
                $imageSrc = $arImage['src'];
            }
        }

        // описание
        $desc = trim((string)($arItem['PREVIEW_TEXT'] ?? ''));
        if ($desc === '' && !empty($arItem['DISPLAY_PROPERTIES']['TEXT']['VALUE'])) {
            $desc = trim((string)$arItem['DISPLAY_PROPERTIES']['TEXT']['VALUE']);
        }

        // дата
        $date = '';
        if (!empty($arItem['DISPLAY_ACTIVE_FROM'])) {
            $date = $arItem['DISPLAY_ACTIVE_FROM'];
        } elseif (!empty($arItem['ACTIVE_FROM'])) {
            $date = FormatDate('d.m.Y', MakeTimeStamp($arItem['ACTIVE_FROM']));
        }
        ?>

        <div class="flex flex-col
                         overflow-hidden
                         rounded-3xl
                    "
             id="<?=$this->GetEditAreaId($arItem['ID'])?>"
        >
            <meta itemprop="position" content="<?= ($pos + 1) ?>" />

            <?php if ($bDetailLink): ?><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="block"><?php endif; ?>
                <div class="overflow-hidden rounded-3xl aspect-[4/3] bg-black/5">
                    <img
                            class="w-full object-cover"
                            loading="lazy"
                            src="<?= $imageSrc ?>"
                            alt="<?= htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['ALT'] ?: $arItem['NAME']) ?>"
                            title="<?= htmlspecialcharsbx($arItem['FIELDS']['PREVIEW_PICTURE']['TITLE'] ?: $arItem['NAME']) ?>"
                            itemprop="image"
                    />
                </div>
                <?php if ($bDetailLink): ?></a><?php endif; ?>
            <?php if ($bDetailLink): ?><a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="py-4"><?php else: ?><div class="px-4 py-4"><?php endif; ?>
                    <h3 itemprop="name" class="text-xl md:text-xl font-semibold leading-snug text-gray-900">
                        <?= $arItem['NAME'] ?>
                    </h3>

                    <?php if ($desc !== ''): ?>
                        <p class="text-base mt-4 md:text-lg font-light leading-relaxed text-black/70">
                            <?= strip_tags($desc) ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($date !== ''): ?>
                        <div class="mt-8 text-sm text-black/40">
                            <?= $date ?>
                        </div>
                    <?php endif; ?>
                <?php if ($bDetailLink): ?></a><?php else: ?></div><?php endif; ?>

    </div>

<?php endforeach; ?>
</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>