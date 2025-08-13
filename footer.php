<?php

use Bitrix\Main\Localization\Loc;


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

<footer role="contentinfo">
	<div class="w">
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
				<div class="ftr__connect cntct">
					<div class="cntct__title"><?= Loc::getMessage("FOOTER_CONTACT_TITLE") ?></div>
					<? $APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"office_footer",
						array(
							"ACTIVE_DATE_FORMAT" => "d.m.Y",
							"ADD_SECTIONS_CHAIN" => "N",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"AJAX_OPTION_HISTORY" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"CACHE_FILTER" => "N",
							"CACHE_GROUPS" => "Y",
							"CACHE_TIME" => "36000000",
							"CACHE_TYPE" => "A",
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"DISPLAY_BOTTOM_PAGER" => "N",
							"DISPLAY_DATE" => "N",
							"DISPLAY_NAME" => "N",
							"DISPLAY_PICTURE" => "N",
							"DISPLAY_PREVIEW_TEXT" => "N",
							"DISPLAY_TOP_PAGER" => "N",
							"FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"FILTER_NAME" => "",
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",
							"IBLOCK_ID" => 'office',
							"IBLOCK_TYPE" => "content",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"INCLUDE_SUBSECTIONS" => "N",
							"MESSAGE_404" => "",
							"NEWS_COUNT" => "1",
							"PAGER_BASE_LINK_ENABLE" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_TEMPLATE" => ".default",
							"PAGER_TITLE" => "",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"PREVIEW_TRUNCATE_LEN" => "",
							"PROPERTY_CODE" => array(
								0 => "email",
								1 => "skype",
								2 => "address",
								3 => "timetable",
								4 => "phone",
								8 => "",
							),
							"SET_BROWSER_TITLE" => "N",
							"SET_LAST_MODIFIED" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_STATUS_404" => "N",
							"SET_TITLE" => "N",
							"SHOW_404" => "N",
							"SORT_BY1" => "SORT",
							"SORT_BY2" => "NAME",
							"SORT_ORDER1" => "ASC",
							"SORT_ORDER2" => "ASC",
							"STRICT_SECTION_CHECK" => "N",
						),
						false
					); ?>

				</div>
				<div class="ftr__misc">
					<div class="ftr__miscItem">&copy; <?= date('Y') ?> <?= SITE_SERVER_NAME ?></div>
					<div class="ftr__miscItem">
						<a href="<?= SITE_DIR ?>agreement/" class="ftr__miscLink"><?= Loc::getMessage("FOOTER_AGREEMENT_LINK") ?></a>
					</div>
					<div id="bx-composite-banner"></div>
				</div>


			</div>
		</div>
	</div>
</footer>

<?php
$APPLICATION->ShowProperty('BeforeBodyClose');
$APPLICATION->ShowViewContent('BeforeBodyClose');

  <script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/main.js"></script>
</body>

</html>