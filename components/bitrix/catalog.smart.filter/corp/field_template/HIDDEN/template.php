
<?/**
 * tehnicheskiy shablon so skritimi punktami dlya js obrabotki
 * @var $arItem;
 */?>

<? foreach ($arItem["VALUES"] as $val => $ar): ?>
	<input
		class="hidden"
		type="checkbox"
		name="<?=$ar["CONTROL_NAME"]?>"
		id="<?=$ar["CONTROL_ID"]?>"
		value="<? echo $ar["HTML_VALUE"] ?>"
		<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
	/>
<?endforeach;?>
