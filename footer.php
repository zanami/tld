<?php

use Bitrix\Main\Localization\Loc;


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);
?>

<footer role="contentinfo" class="pt-16 pb-20 bg-gray-900">
	<div class="container">
		<div class="ftr">

			<? $APPLICATION->IncludeComponent(
				"bitrix:menu",
				"footer_menu",
				array(
					"ROOT_MENU_TYPE" => "bottom",
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "left",
					"USE_EXT" => "Y",
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "36000000",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => array(),
					"COMPONENT_TEMPLATE" => "bottom",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "N"
				),
				false,
				array(
					"ACTIVE_COMPONENT" => "Y"
				)
			); ?>

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