<?

/**
 * @var $arItem
 */

use Bitrix\Main\Localization\Loc;

$arItem['lang'] = array(
	'from' => Loc::getMessage('CT_BCSF_FILTER_FROM'),
	'to' => Loc::getMessage('CT_BCSF_FILTER_TO')
);

if ($arItem['CODE'] === 'cost') {
	$currencyIcon = '<span class="currency-icon" data-currency-icon=""></span>';
	$arItem['NAME'] .= '<span data-currency-factor=""></span>';
}
?>

<div class="sfltr-label" onclick="smartFilter.toggleValues(this, event)">
	<span class="sfltr-label_name"><?= $arItem["NAME"] ?></span><?= $arItem['HINT'] ? ', ' . $arItem['HINT'] : '' ?>
	<span class="sfltr-label_value"></span>
	<span class="sfltr-label_close"><i class="icon-close" aria-hidden="true"></i></span>
</div>

<div class="sfltr-values">
	<div class="filter-numbers" data-property-id="<?= $arItem['ID'] ?>">

		<div class="filter-numbers_input-wrap">
			<input class="filter-numbers_input _min" type="text" name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>" id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>" value="" size="12" data-template="<?= $arItem['TEMPLATE']['NAME'] ?>" data-real-value="" />
			<input class="filter-numbers_input _max" type="text" name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>" id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>" value="" size="12" data-template="<?= $arItem['TEMPLATE']['NAME'] ?>" data-real-value="" />
		</div>

		<? if ($arItem['DISPLAY_TYPE'] == 'A') : ?>
			<div class="filter-slider">
				<input type="hidden" class="range-slider-input">
			</div>
			<? CJSCore::Init(array('btmcn.rangeslider')); ?>
		<? endif; ?>

		<? CJSCore::Init(array('btmcn.autonumeric')); ?>
		<? //Bitrix\Main\UI\Extension::load(array('btmcn.autonumeric'));
		?>

	</div>

	<script>
		;
		(function() {

			function init() {
				window['smartFilterNumbers<?= $arItem["ID"] ?>'] = new btmcnSFNumbers(<?= \Bitrix\Main\Web\Json::encode($arItem); ?>);
			}

			init();
			BX.addCustomEvent('onComponentAjaxHistorySetState', init);

		}());
	</script>
</div>