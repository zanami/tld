<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);
?>
<?php
global $APPLICATION;
$showContainer = $APPLICATION->GetPageProperty("HIDE_CONTAINER") != 'Y' && $APPLICATION->GetPageProperty('IS_MAIN_PAGE') != 'Y';
$showSubMenu = $showContainer;
$isContentPage = $APPLICATION->GetPageProperty("CONTENT_PAGE");
?>
<?php ob_start(); ?>
<?php if ($showContainer): ?><div class="container mx-auto px-4"><?php endif; ?>
    <?php if ($showSubMenu): ?>
        <?php
        $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "left",
                [
                        "ROOT_MENU_TYPE" => "left",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "4",
                        "CHILD_MENU_TYPE" => "subleft",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y"
                ]
        );
        ?>
    <?php endif; ?>
    <?php if ($isContentPage): ?><div class="content"><?php endif; ?>

    <?php $APPLICATION->AddViewContent("AFTER_HEADER", ob_get_clean()); ?>

<?php if ($showContainer): ?></div><?php endif; ?>
<?php if ($isContentPage): ?></div><?php endif; ?>
<footer role="contentinfo" class="pt-16 pb-20 bg-neutral-950">
    <div class="container mx-auto px-4">
        <!-- grid: 1 колонка на мобиле, 4 колонки с md -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-x-8 gap-y-12">

            <!-- МЕНЮ: на мобиле идёт первым, на десктопе занимает 3 колонки справа -->
            <div class="order-1 md:order-2 md:col-span-3">
                <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", [
                    "ROOT_MENU_TYPE" => "footer",
                    "MAX_LEVEL"      => "2",
                    "CHILD_MENU_TYPE"=> "footer",
                    "USE_EXT"        => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                ], false, ["HIDE_ICONS" => "Y"]);?>
            </div>

            <!-- КОНТЕНТ: на мобиле внизу, на десктопе — первая колонка слева -->
            <div class="order-2 md:order-1 md:col-span-1">
                <img
                        class="w-24 md:w-32 h-auto"
                        src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo/logo-bottom.svg"
                        alt="logo"
                />
                <div class="font-light text-xs text-gray-400 mt-6">
                    &copy; <?= date('Y') ?> <?= $siteName ?>
                </div>
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