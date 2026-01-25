<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?
$GLOBALS['arCatalogItemsFilter'] = array('IBLOCK_ID'=>array(28),'!PROPERTY_SHOW_ON_INDEX_PAGE' => false);
//$GLOBALS['arCatalogItemsFilter'] = array('IBLOCK_ID'=>array(28,12),'!PROPERTY_SHOW_ON_INDEX_PAGE' => false);
?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/banner.php",
        "TITLE" => "Главный баннер",
        "WIDGET_REL" => "mp-banner",
        "h" => ".h1"
    )
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/sales.php",
        "TITLE" => "Продажа и сервис",
        "WIDGET_REL" => "mp-services",
        "h" => ".h1"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/features.php",
        "TITLE" => "Преимущества",
        "WIDGET_REL" => "mp-features",
        "h" => ".h1"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/help.php",
        "TITLE" => "Помощь",
        "WIDGET_REL" => "mp-help",
        "h" => ".h1"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/stock.php",
        "TITLE" => "Техника",
        "WIDGET_REL" => "mp-stock",
        "h" => ".h1"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "COMPONENT_TEMPLATE" => ".default",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DESCRIPTION" => "",
        "EDIT_TEMPLATE" => "clear.php",
        "PAGE_SECTION" => "N",
        "PATH" => SITE_TEMPLATE_PATH."/includes/blog.php",
        "TITLE" => "Блог",
        "WIDGET_REL" => "mp-blog",
        "h" => ".h1"
    )
);?>

