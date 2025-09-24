<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$previousLevel = 0;
?>
<div class="flex items-center justify-between w-full px-4">
    <div>
        <button
                id="navbarToggler"
                class="absolute right-4 top-1/2 block -translate-y-1/2 rounded-lg px-3 py-[6px] ring-primary focus:ring-2 lg:hidden"
                type="button" aria-controls="navbarCollapse" aria-expanded="false">
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
            <span class="relative my-[6px] block h-[2px] w-[30px] bg-dark dark:bg-white"></span>
        </button>

        <nav id="navbarCollapse"
             class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white dark:bg-dark-2 py-5 shadow-lg
                lg:static lg:block lg:w-full lg:max-w-full lg:bg-transparent dark:lg:bg-transparent lg:py-0 lg:px-4 lg:shadow-none xl:px-6">
            <ul class="block lg:flex 2xl:ml-20">
                <?php foreach ($arResult as $i => $arItem): ?>
                <?php
                if ($previousLevel && (int)$arItem["DEPTH_LEVEL"] < $previousLevel) {
                    echo str_repeat("</ul></div></li>", ($previousLevel - (int)$arItem["DEPTH_LEVEL"]));
                }
                if ($arItem["PERMISSION"] <= "D") {
                    $previousLevel = (int)$arItem["DEPTH_LEVEL"];
                    continue;
                }

                $isTop = ($arItem["DEPTH_LEVEL"] == 1);
                $isFirstTop = ($isTop && $i === array_key_first($arResult));
                $linkCls = "flex py-2 mx-8 text-base font-medium ud-menu-scroll text-dark dark:text-white group-hover:text-primary lg:mr-0 ";
                $linkCls .= $isFirstTop ? "" : "lg:ml-7 xl:ml-10 ";
                $linkCls .= "lg:inline-flex lg:py-6 lg:px-0 lg:text-body-color dark:lg:text-dark-6";
                $active = !empty($arItem["SELECTED"]) ? " text-primary lg:text-primary" : "";
                $subCls = "block px-4 py-2 text-sm text-dark dark:text-white hover:bg-gray-100 dark:hover:bg-dark-3";
                ?>

                <?php if ($arItem["IS_PARENT"]): ?>
                <li class="relative group">
                    <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="<?=$linkCls.$active?>" data-submenu-toggle>
                        <?=$arItem["TEXT"]?>
                        <svg class="ml-2 mt-[2px] h-4 w-4 transition-transform lg:inline-block hidden group-hover:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M5.23 7.21a.75.75 0 011.06.02L10 11.116l3.71-3.885a.75.75 0 111.08 1.04l-4.24 4.44a.75.75 0 01-1.08 0l-4.24-4.44a.75.75 0 01.02-1.06z"/></svg>
                    </a>

                    <!-- Контейнер подменю: hidden по умолчанию, на десктопе показываем по :hover -->
                    <div class="hidden lg:absolute lg:left-0 lg:top-full lg:min-w-[220px] lg:rounded-lg lg:bg-white dark:lg:bg-dark-2 lg:py-3 lg:shadow-lg
                          lg:group-hover:block lg:z-50" data-submenu>
                        <ul class="lg:block">
                            <?php else: ?>
                            <li class="relative group">
                                <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="<?=$subCls.$active?>"><?=$arItem["TEXT"]?></a>
                                <?php endif; ?>

                                <?php
                                $previousLevel = (int)$arItem["DEPTH_LEVEL"];
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

        // Аккордеон подменю на mobile: скрыто по умолчанию (hidden), раскрываем до block
        nav?.querySelectorAll('[data-submenu-toggle]').forEach(function (trigger) {
            trigger.addEventListener('click', function (e) {
                // только для мобильного (< lg)
                if (window.matchMedia('(min-width: 1024px)').matches) return;
                var container = trigger.parentElement?.querySelector('[data-submenu]');
                if (!container) return;
                e.preventDefault();
                container.classList.toggle('hidden');
                if (!container.classList.contains('hidden')) {
                    container.classList.add('block');
                } else {
                    container.classList.remove('block');
                }
            });
        });

        // При входе на десктоп — оставляем hidden (будет перекрыто lg:group-hover:block)
        window.addEventListener('resize', function () {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                nav?.querySelectorAll('[data-submenu]').forEach(function (el) {
                    el.classList.add('hidden');
                    el.classList.remove('block');
                });
            }
        });
    })();
</script>