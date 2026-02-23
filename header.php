<?php
use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

CModule::IncludeModule("aspro.scorp");
Extension::load([
	'tld.jqmpopup',
    'btmcn.validate',
    'btmcn.validator',
	'btmcn.inputmask',

]);
if ($APPLICATION->GetCurPage(false) == SITE_DIR) {
	$APPLICATION->SetPageProperty('IS_MAIN_PAGE', 'Y');
    $isMainPage = true;
}
$hasBxPanel = $USER->IsAdmin();
$headerClass = $isMainPage ? ' absolute top-0 left-0 z-40 dark mb-10' : 'mb-10';
$siteName = "БТ	Машинери";
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>" class="tag-html scroll-smooth">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
	<?php
	$APPLICATION->ShowProperty('AfterHeadOpen');
	$APPLICATION->ShowViewContent('AfterHeadOpen');
	?>
    <title><? $APPLICATION->ShowTitle() ?></title>
    <link
      rel="shortcut icon"
      href="<?= SITE_TEMPLATE_PATH ?>/assets/images/favicon.ico"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/css/animate.css" />
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/src/css/tailwind.css" />

    <!-- ==== WOW JS ==== -->
    <script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/wow.min.js"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/js/fancybox/fancybox.css" />


    <script>
      new WOW().init();
    </script>
  </head>

	<? $APPLICATION->ShowHead() ?>

	<?php
	$APPLICATION->ShowProperty('BeforeHeadClose');
	$APPLICATION->ShowViewContent('BeforeHeadClose');
	?>
</head>

<body class="<? $APPLICATION->ShowProperty('BodyClass'); ?>" <? $APPLICATION->ShowProperty('BodyTag'); ?>>
    <?CScorp::SetJSOptions();?>

	<? $APPLICATION->ShowPanel() ?>

    <header class="flex items-center w-full bg-transparent ud-header <?= $headerClass ?> <?= $hasBxPanel ? 'with-bx-panel' : '' ?>">
        <div class="container mx-auto">
            <div class="relative flex items-center justify-between -mx-4">
                <div class="max-w-full px-4 w-60">
                    <a href="<?= SITE_DIR ?>" class="block w-full py-0 navbar-logo">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo.svg"
                                alt="logo"
                                class="w-full dark:hidden"
                        />
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo-white.svg"
                                alt="logo"
                                class="hidden w-full dark:block"
                        />
                        <span class="sr-only">
                            <span><?= $siteName ?></span>
                            <span>Погрузчики TEU и Xilin. Складская техника.</span>
                        </span>
                    </a>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top_menu",
                    array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => ""
                    ),
                    false,
                    array(
                        "ACTIVE_COMPONENT" => "Y"
                    )
                ); ?>
            </div>
        </div>
    </header>

	<?php
	if ($APPLICATION->GetProperty('IS_MAIN_PAGE') == 'Y') {
	?>
		<main>
		<?php
            require($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/frontpage.php');
	} else {
		?>
        <div class="container mb-12 mx-auto px-4">
        <h1 class="page-title mb-10 mt-4 text-5xl"><?$APPLICATION->ShowTitle(false)?></h1>
        <?$APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "main",
            [
                "START_FROM" => "1",
                "PATH"       => "",
                "SITE_ID"    => SITE_ID
            ],
            false
        );?>
        </div>
		<?php
	} ?>
    <?php
    $APPLICATION->ShowViewContent('AFTER_HEADER');
    ?>

