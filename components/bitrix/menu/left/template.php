<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
if(!function_exists("ShowSubItems")){
	function ShowSubItems($arItem){
		?>
		<?if($arItem["SELECTED"] && $arItem["CHILD"]):?>
			<?$noMoreSubMenuOnThisDepth = false;?>
			<ul class="submenu">
				<?foreach($arItem["CHILD"] as $arSubItem):?>
					<li class="<?=($arSubItem["SELECTED"] ? "active" : "")?>">
						<a href="<?=$arSubItem["LINK"]?>"><?=$arSubItem["TEXT"]?></a>
						<?if(!$noMoreSubMenuOnThisDepth):?>
							<?ShowSubItems($arSubItem);?>
						<?endif;?>
					</li>
					<?$noMoreSubMenuOnThisDepth |= CScorp::isChildsSelected($arSubItem["CHILD"]);?>
				<?endforeach;?>
			</ul>
		<?endif;?>
		<?
	}
}
?>
<?if($arResult):?>
    <ul class="flex flex-wrap gap-2 mb-12">
        <?php foreach($arResult as $arItem):?>
            <li class="group flex rounded-md bg-accent <?=($arItem["SELECTED"] ? "bg-link" : "")?>">
                <a class="px-4 py-3 transition-colors
               group-hover:text-white
               <?= ($arItem["SELECTED"] ? "text-white" : "") ?>"
                   href="<?= $arItem["LINK"] ?>"
                >
                    <?= $arItem["TEXT"] ?>
                </a>
            </li>
        <?php endforeach;?>
    </ul>
<?endif;?>