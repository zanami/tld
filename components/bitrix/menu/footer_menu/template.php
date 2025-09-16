<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

if (empty($arResult)) return;

$itemsPerColumn = ceil(count($arResult) / 2);
?>

<div class="ftr__menu mnu-b">

<?php foreach (array_chunk($arResult, $itemsPerColumn, true) as $chunk) { ?>

<div class="mnu-b__col">
	<?php foreach ($chunk as $arItem) {
		$arItem['TRUNCATE_TEXT'] = ($arParams['TRUNCATE_TEXT_LENGTH'] <> '') ? TruncateText($arItem["TEXT"], $arParams['TRUNCATE_TEXT_LENGTH']) : $arItem["TEXT"];
	?>
		<a href="<?= $arItem["LINK"] ?>" class="mnu-b__item"><?=$arItem['TRUNCATE_TEXT']?></a>
	<?php } ?>
</div>

<?php } ?>

</div>
