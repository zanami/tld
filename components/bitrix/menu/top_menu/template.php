<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Ожидает $arResult c DEPTH_LEVEL, IS_PARENT, SELECTED, PERMISSION, LINK, TEXT
 * Работает до любой глубины, раскрытие по :hover на desktop и по клику (аккордеон) на mobile.
 */

$previousLevel = 0;
?>
<div class="flex items-center justify-between w-full px-4">
    <div>
        <button
                id="navbarToggler"
                class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden"
                type="button"
                aria-controls="navbarCollapse"
                aria-expanded="false"
        >
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
        </button>

        <nav
                id="navbarCollapse"
                class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white dark:bg-dark-2 py-5 shadow-lg lg:static lg:block lg:w-full lg:max-w-full lg:bg-transparent dark:lg:bg-transparent lg:py-0 lg:px-4 lg:shadow-none xl:px-6"
        >
            <ul class="block lg:flex 2xl:ml-20">
                <?php foreach ($arResult as $index => $arItem): ?>

                <?php
                // Закрываем уровни, если поднялись выше
                if ($previousLevel && (int)$arItem["DEPTH_LEVEL"] < $previousLevel) {
                    echo str_repeat("</ul></div></li>", ($previousLevel - (int)$arItem["DEPTH_LEVEL"]));
                }

                // Пропускаем п. без прав
                if ($arItem["PERMISSION"] <= "D") {
                    $previousLevel = (int)$arItem["DEPTH_LEVEL"];
                    continue;
                }

                // Базовые классы ссылки
                $isFirstTop = ($arItem["DEPTH_LEVEL"] == 1 && $index === array_key_first($arResult));
                $linkClasses = "flex py-2 mx-8 text-base font-medium ud-menu-scroll text-dark dark:text-white group-hover:text-primary lg:mr-0 ";
                $linkClasses .= $isFirstTop ? "" : "lg:ml-7 xl:ml-10 ";
                $linkClasses .= "lg:inline-flex lg:py-6 lg:px-0 lg:text-body-color dark:lg:text-dark-6";
                $activeClasses = !empty($arItem["SELECTED"]) ? " text-primary lg:text-primary" : "";

                // Если есть дети
                if ($arItem["IS_PARENT"]):
                ?>
                <li class="relative group">
                    <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"
                       class="<?=$linkClasses . $activeClasses?>"
                       data-submenu-toggle>
                        <?=$arItem["TEXT"]?>
                        <svg class="ml-2 mt-[2px] h-4 w-4 transition-transform group-hover:rotate-180 lg:inline-block hidden" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.116l3.71-3.885a.75.75 0 111.08 1.04l-4.24 4.44a.75.75 0 01-1.08 0l-4.24-4.44a.75.75 0 01.02-1.06z"/></svg>
                    </a>

                    <!-- Контейнер подменю -->
                    <div class="lg:absolute lg:left-0 lg:top-full lg:min-w-[220px] lg:rounded-lg lg:bg-white dark:lg:bg-dark-2 lg:py-3 lg:shadow-lg
                          lg:opacity-0 lg:invisible lg:translate-y-2 lg:transition-all lg:duration-200
                          group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                          lg:z-50
                          <!-- mobile: аккордеон --> hidden data-submenu>
                <ul class="lg:block">
                    <?php
                    else:
                    ?>
                <li class="relative group">
                    <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="<?=$linkClasses . $activeClasses?>">
                        <?=$arItem["TEXT"]?>
                    </a>
                    <?php
                    endif;

                    $previousLevel = (int)$arItem["DEPTH_LEVEL"];
                    ?>

                    <?php
                    // Закрытие элемента, если не родитель
                    if (!$arItem["IS_PARENT"]) {
                        echo "</li>";
                    }
                    ?>

                    <?php endforeach; ?>

                    <?php
                    // Закрываем открытые уровни в конце
                    if ($previousLevel > 1) {
                        echo str_repeat("</ul></div></li>", ($previousLevel - 1));
                    }
                    ?>
            </ul>
        </nav>
    </div>
</div>

<script>
    (function () {
        // Тоггл основного меню (mobile)
        var toggler = document.getElementById('navbarToggler');
        var nav = document.getElementById('navbarCollapse');
        if (toggler && nav) {
            toggler.addEventListener('click', function () {
                var isHidden = nav.classList.contains('hidden');
                nav.classList.toggle('hidden', !isHidden);
                toggler.setAttribute('aria-expanded', String(isHidden));
            });
        }

        // Аккордеон подменю на mobile: открываем/закрываем по клику на родителя
        // На desktop подменю открывается по :hover (через group-hover)
        nav?.querySelectorAll('[data-submenu-toggle]').forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                // Только для мобильного вида (lg:hidden == mobile)
                var isDesktop = window.matchMedia('(min-width: 1024px)').matches;
                if (isDesktop) return;

                var container = trigger.parentElement?.querySelector('[data-submenu]');
                if (!container) return;

                e.preventDefault();
                var isOpen = !container.classList.contains('hidden');
                // Закрыть, если открыто; иначе открыть
                container.classList.toggle('hidden', isOpen);
            });
        });

        // При ресайзе на desktop — гарантируем, что подменю скрыты в DOM (их всё равно покажет :hover)
        window.addEventListener('resize', function () {
            var isDesktop = window.matchMedia('(min-width: 1024px)').matches;
            if (isDesktop) {
                nav?.querySelectorAll('[data-submenu]').forEach(function (el) {
                    el.classList.add('hidden');
                });
            }
        });
    })();
</script>