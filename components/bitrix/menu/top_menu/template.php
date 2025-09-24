<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Ожидает в $arResult поля: DEPTH_LEVEL, IS_PARENT, SELECTED, PERMISSION, LINK, TEXT
 * Параметры компонента: MAX_LEVEL>=2, USE_EXT (по необходимости), CHILD_MENU_TYPE задан.
 */
$previousLevel = 0;
?>
<div class="flex items-center justify-between w-full px-4">
    <div>
        <!-- Бургер -->
        <button
                id="navbarToggler"
                class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden"
                type="button" aria-controls="navbarCollapse" aria-expanded="false">
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
        </button>

        <!-- Навигация -->
        <nav id="navbarCollapse"
             class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white dark:bg-dark-2 py-5 shadow-lg
                lg:static lg:block lg:w-full lg:max-w-full lg:bg-transparent dark:lg:bg-transparent lg:py-0 lg:px-4 lg:shadow-none xl:px-6">
            <ul class="block lg:flex 2xl:ml-20">
                <?php foreach ($arResult as $i => $arItem): ?>
                <?php
                // Закрываем уровни если поднимаемся
                if ($previousLevel && (int)$arItem["DEPTH_LEVEL"] < $previousLevel) {
                    echo str_repeat("</ul></div></li>", ($previousLevel - (int)$arItem["DEPTH_LEVEL"]));
                }

                if ($arItem["PERMISSION"] <= "D") {
                    $previousLevel = (int)$arItem["DEPTH_LEVEL"];
                    continue;
                }

                $depth = (int)$arItem["DEPTH_LEVEL"];
                $isTop = ($depth === 1);
                $isFirstTop = ($isTop && $i === array_key_first($arResult));

                // Классы ссылок верхнего уровня
                $topLink = "flex py-2 mx-6 uppercase text-lg font-medium ud-menu-scroll text-dark dark:text-orange-600 group-hover:text-primary lg:mr-0 ".
                    ($isFirstTop ? "" : "lg:ml-4 xl:ml-6 ").
                    "lg:inline-flex lg:py-2 lg:px-0 lg:text-body-color dark:lg:text-dark-6";

                // Классы ссылок подуровней (компактные)
                $subLink = "block px-4 py-2 text-base text-dark dark:text-white hover:bg-gray-100 dark:hover:bg-dark-3";

                // Active
                $active = !empty($arItem["SELECTED"]) ? " text-primary lg:text-primary" : "";
                ?>

                <?php if ($arItem["IS_PARENT"]): ?>
                <!-- Родительский пункт -->
                <li class="relative group">
                    <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"
                       class="<?= ($isTop ? $topLink : $subLink) . $active ?>"
                       data-submenu-toggle>
                        <?=$arItem["TEXT"]?>
                        <?php /* Стрелка только у верхнего уровня на десктопе */ ?>
                        <?php if ($isTop): ?>
                            <svg class="ml-2 mt-[2px] h-4 w-4 transition-transform lg:inline-block hidden group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.116l3.71-3.885a.75.75 0 111.08 1.04l-4.24 4.44a.75.75 0 01-1.08 0l-4.24-4.44a.75.75 0 01.02-1.06z"/></svg>
                        <?php endif; ?>
                    </a>

                    <!-- Контейнер подменю -->
                    <div class="hidden lg:absolute lg:left-0 lg:top-full lg:min-w-[220px] lg:rounded-lg lg:bg-white dark:lg:bg-dark-2 lg:py-2 lg:shadow-lg
                       lg:group-hover:block lg:z-50 lg:pointer-events-auto"
                            data-submenu
                        <?php /* Фолбэк, если tailwind не подхватывает класс hidden: */ ?>
                            style="display:none">
                        <ul class="lg:block">
                <?php else: ?>
                        <!-- Обычный пункт -->
                        <li class="relative group">
                            <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"
                               class="<?= ($isTop ? $topLink : $subLink) . $active ?>">
                                <?=$arItem["TEXT"]?>
                            </a>
                <?php endif; ?>

                <?php
                    $previousLevel = $depth;
                    if (!$arItem["IS_PARENT"]) echo "</li>";
                ?>
                <?php endforeach; ?>

                <?php if ($previousLevel > 1) echo str_repeat("</ul></div></li>", ($previousLevel - 1)); ?>
            </ul>
        </nav>
    </div>
</div>

<script>
    (function () {
        var toggler = document.getElementById('navbarToggler');
        var nav = document.getElementById('navbarCollapse');

        // Тоггл основного меню (mobile)
        if (toggler && nav) {
            toggler.addEventListener('click', function () {
                var hidden = nav.classList.contains('hidden');
                nav.classList.toggle('hidden', !hidden);
                toggler.setAttribute('aria-expanded', String(hidden));
            });
        }

        // Аккордеон подменю на mobile (<lg): hidden <-> block
        nav?.querySelectorAll('[data-submenu-toggle]').forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                if (window.matchMedia('(min-width: 1024px)').matches) return; // только mobile
                var container = trigger.parentElement?.querySelector('[data-submenu]');
                if (!container) return;
                e.preventDefault();
                var isHidden = container.classList.contains('hidden') || container.style.display === 'none';
                container.classList.toggle('hidden', !isHidden);
                container.classList.toggle('block', isHidden);
                container.style.display = isHidden ? 'block' : 'none';
            });
        });

        // Фолбэк для desktop hover, если по каким-то причинам lg:group-hover:block не срабатывает
        // Наводим мышь на li.group => показываем data-submenu
        nav?.querySelectorAll('li.group').forEach(function (li) {
            var submenu = li.querySelector('[data-submenu]');
            if (!submenu) return;

            li.addEventListener('mouseenter', function () {
                if (!window.matchMedia('(min-width: 1024px)').matches) return;
                submenu.classList.add('block');
                submenu.classList.remove('hidden');
                submenu.style.display = 'block';
            });
            li.addEventListener('mouseleave', function () {
                if (!window.matchMedia('(min-width: 1024px)').matches) return;
                submenu.classList.add('hidden');
                submenu.classList.remove('block');
                submenu.style.display = 'none';
            });
        });

        // При переходе на desktop сбрасываем mobile-состояния
        window.addEventListener('resize', function () {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                nav?.querySelectorAll('[data-submenu]').forEach(function (el) {
                    el.classList.add('hidden');
                    el.classList.remove('block');
                    el.style.display = 'none';
                });
            }
        });
    })();
</script>