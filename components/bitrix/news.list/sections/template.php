<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?if ($arResult['SECTIONS']):?>
	<div class="catalog item-views table my-14">
		<ul class="grid gap-8 grid-cols-1 md:grid-cols-3">
			<?foreach ($arResult['SECTIONS'] as $arSection):?>
				<?
				$arSectionButtons = CIBlock::GetPanelButtons($arSection['IBLOCK_ID'], 0, $arSection['ID'], array('SESSID' => false, 'CATALOG' => true));
				$this->AddEditAction($arSection['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_EDIT'));
				$this->AddDeleteAction($arSection['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arSection['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$bShowSectionImage = in_array('PREVIEW_PICTURE', (array)$arParams['FIELD_CODE']);
				$imageSectionSrc = '';
				if ($bShowSectionImage && $arSection['PICTURE']) {
					$arSectionImage = CFile::ResizeImageGet($arSection['PICTURE'], array('width' => 400, 'height' => 260), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$imageSectionSrc = $arSectionImage['src'];
				}
				$sectionText = strlen($arSection['UF_INFOTEXT']) ? $arSection['UF_INFOTEXT'] : $arSection['DESCRIPTION'];
				?>
				<li id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="h-full overflow-hidden flex flex-col rounded-3xl bg-white shadow-sm border border-black/5">
					<?if ($bShowSectionImage):?>
						<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="relative block aspect-16/9 overflow-hidden rounded-t-3xl">
							<?if ($imageSectionSrc):?>
								<img src="<?=$imageSectionSrc?>" alt="<?=htmlspecialcharsbx($arSection['NAME'])?>" title="<?=htmlspecialcharsbx($arSection['NAME'])?>" class="w-full h-full object-cover transition duration-300 hover:scale-105" loading="lazy" />
							<?else:?>
								<div class="flex h-full items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-accent text-sm uppercase tracking-[0.35em] text-white/80">Section</div>
							<?endif;?>
							<div class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-black/40 via-black/10 to-transparent"></div>
						</a>
					<?endif;?>

					<div class="flex flex-col flex-1 px-6 pt-6 pb-5">
						<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="no-underline">
							<h2 class="text-xl/7 font-semibold text-accent transition hover:text-link"><?=$arSection['NAME']?></h2>
						</a>
						<?if ($sectionText):?>
							<div class="mt-3 font-thin text-lg leading-7 text-gray-800"><?=$sectionText?></div>
						<?endif;?>
					</div>
				</li>
			<?endforeach;?>
		</ul>
	</div>
<?endif;?>
