<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("aspro.scorp");

if ($APPLICATION->GetCurPage(false) == SITE_DIR) {
	$APPLICATION->SetPageProperty('IS_MAIN_PAGE', 'Y');
}

?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>" class="tag-html">

<head>
	<?php
	$APPLICATION->ShowProperty('AfterHeadOpen');
	$APPLICATION->ShowViewContent('AfterHeadOpen');
	?>
<html lang="en" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

	<? $APPLICATION->ShowPanel() ?>

	<? $APPLICATION->IncludeComponent("bitrix:menu", "mobile", array(
		"ROOT_MENU_TYPE" => "float",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => ""
	)); ?>

	<header class="absolute top-0 left-0 z-40 flex items-center w-full bg-transparent ud-header">
		<div class="hdng__placeholder"></div>
		<div class="container px-4 mx-auto">
			<div class="relative flex items-center justify-between -mx-4">
        <div class="max-w-full px-4 w-60">
          <a href="<?= SITE_DIR ?>" class="block w-full py-5 navbar-logo">
            <img
              src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo.svg"
              alt="logo"
              class="w-full dark:hidden"
            />
            <img
              src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo-white.svg"
              alt="logo"
              class="hidden w-full dark:block"
            />
						<span class="sr-only">
							<span><?= $siteName ?></span>
							<span>Погрузчики TEU и Xilin. Складская техника.</span>
						</span>
          </a>
        </div>
        <div class="flex items-center justify-between w-full px-4">
          <div>
            <button
              id="navbarToggler"
              class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden"
            >
              <span
                class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"
              ></span>
              <span
                class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"
              ></span>
              <span
                class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"
              ></span>
            </button>
            <nav
              id="navbarCollapse"
              class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white dark:bg-dark-2 py-5 shadow-lg lg:static lg:block lg:w-full lg:max-w-full lg:bg-transparent dark:lg:bg-transparent lg:py-0 lg:px-4 lg:shadow-none xl:px-6"
            >
              <ul class="block lg:flex 2xl:ml-20">
                  <li class="relative group">
                    <a
                      href="#home"
                      class="flex py-2 mx-8 text-base font-medium ud-menu-scroll text-dark dark:text-white group-hover:text-primary lg:mr-0 lg:inline-flex lg:py-6 lg:px-0 lg:text-body-color dark:lg:text-dark-6"
                    >
                      Home
                    </a>
                  </li>
                  <li class="relative group">
                    <a
                      href="/#about"
                      class="flex py-2 mx-8 text-base font-medium ud-menu-scroll text-dark dark:text-white group-hover:text-primary lg:mr-0 lg:ml-7 lg:inline-flex lg:py-6 lg:px-0 lg:text-body-color dark:lg:text-dark-6 xl:ml-10"
                    >
                      About
                    </a>
                  </li>
                  <li class="relative group">
                    <a
                      href="/#pricing"
                      class="flex py-2 mx-8 text-base font-medium ud-menu-scroll text-dark dark:text-white group-hover:text-primary lg:mr-0 lg:ml-7 lg:inline-flex lg:py-6 lg:px-0 lg:text-body-color dark:lg:text-dark-6 xl:ml-10"
                    >
                      Pricing
                    </a>
                  </li>
              </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>

					<div class="hdng__item hdng__item_right">
						<? $APPLICATION->IncludeComponent(
							"bitrix:menu",
							"main_menu",
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

						<? $APPLICATION->IncludeComponent(
							"bitrix:menu",
							"float_menu",
							array(
								"ROOT_MENU_TYPE" => "float",
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

						<? //$APPLICATION->IncludeComponent('btnmc:sidebar.form', '', ['FORM_TYPE' => 'order_call',])
						?>

				</div>
			</div>
		</div>
	</header>

	<?php

	if ($APPLICATION->GetProperty('IS_MAIN_PAGE') == 'Y') {
	?>
		<main>
		<?php
	} else {
		?>
			<? $APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"main",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => "",
					"SITE_ID" => "-",
					//"START_FROM" => "1",
				),
				false
			); ?>
		<?php
	}
