<?php

use Bitrix\Main\Localization\Loc;


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);
?>

<footer role="contentinfo" class="pt-16 pb-20 bg-gray-900">
	<div class="container">
		<div class="ftr">

            <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", [
                "ROOT_MENU_TYPE" => "footer",
                "MAX_LEVEL"      => "2",
                "CHILD_MENU_TYPE"=> "footer",
                "USE_EXT"        => "N", // у тебя подменю по папкам — это ок
                "ALLOW_MULTI_SELECT" => "N",
            ], false, ["HIDE_ICONS" => "Y"]);?>

			<div class="ftr__content">
                <img
                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo-bottom.svg"
                        alt="logo"
                />
                <div class="font-light text-xs text-gray-300 mt-6">&copy; <?= date('Y') ?> <?= SITE_SERVER_NAME ?></div>
			</div>
		</div>
	</div>
    <div id="bx-composite-banner"></div>
</footer>

<?php
$APPLICATION->ShowProperty('BeforeBodyClose');
$APPLICATION->ShowViewContent('BeforeBodyClose');
?>

  <script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/main.js"></script>
</body>

</html>