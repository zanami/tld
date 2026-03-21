<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

$frame = $this->createFrame()->begin();
$frame->setAnimation(true);

$sliderId = 'hero-banner-' . $this->randString(8);
$itemsCount = count((array)$arResult['ITEMS']);
$hasSlider = $itemsCount > 1;
?>

<?php if (!empty($arResult['ITEMS'])): ?>
    <section class="relative w-full overflow-hidden">
        <div class="<?= $hasSlider ? 'swiper common-carousel' : '' ?>" id="<?= $sliderId ?>">
            <div class="<?= $hasSlider ? 'swiper-wrapper' : '' ?>">
                <?php foreach ($arResult['ITEMS'] as $index => $arItem): ?>
                    <?php
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);

                    $backgroundSrc = is_array($arItem['DETAIL_PICTURE']) && !empty($arItem['DETAIL_PICTURE']['SRC'])
                        ? $arItem['DETAIL_PICTURE']['SRC']
                        : SITE_TEMPLATE_PATH . '/assets/images/front/big-banner.jpg';

                    $foregroundSrc = is_array($arItem['PREVIEW_PICTURE']) && !empty($arItem['PREVIEW_PICTURE']['SRC'])
                        ? $arItem['PREVIEW_PICTURE']['SRC']
                        : '';

                    $detailLink = trim((string)$arItem['DETAIL_PAGE_URL']);
                    $linkImg = trim((string)($arItem['PROPERTIES']['LINKIMG']['VALUE'] ?? ''));
                    $titleLink = $linkImg ?: $detailLink;

                    $button1Text = trim((string)($arItem['PROPERTIES']['BUTTON1TEXT']['VALUE'] ?? ''));
                    $button1Link = trim((string)($arItem['PROPERTIES']['BUTTON1LINK']['VALUE'] ?? ''));
                    $button2Text = trim((string)($arItem['PROPERTIES']['BUTTON2TEXT']['VALUE'] ?? ''));
                    $button2Link = trim((string)($arItem['PROPERTIES']['BUTTON2LINK']['VALUE'] ?? ''));

                    $textColor = (string)($arItem['PROPERTIES']['TEXTCOLOR']['VALUE_XML_ID'] ?? '');
                    $textClass = $textColor === 'light' ? 'text-gray-950' : 'text-white';
                    $secondaryTextClass = $textColor === 'light' ? 'text-gray-950/80' : 'text-white/85';
                    ?>

                    <div class="<?= $hasSlider ? 'swiper-slide' : '' ?>">
                        <div
                            id="<?= $this->GetEditAreaId($arItem['ID']) ?>"
                            class="relative min-h-[420px] overflow-hidden lg:min-h-[540px]"
                        >
                            <div
                                class="absolute inset-0 bg-center bg-cover"
                                style="background-image:url('<?= htmlspecialcharsbx($backgroundSrc) ?>');"
                                aria-hidden="true"
                            ></div>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-black/25"
                                aria-hidden="true"
                            ></div>
                            <div
                                class="absolute inset-y-0 right-0 w-full bg-gradient-to-t from-black/15 via-transparent to-transparent lg:w-1/2"
                                aria-hidden="true"
                            ></div>

                            <div class="relative z-10 container mx-auto flex min-h-[420px] items-center px-4 py-16 lg:min-h-[540px]">
                                <div class="grid w-full items-center gap-12 lg:grid-cols-[minmax(0,1fr)_28rem]">
                                    <div class="max-w-3xl <?= $textClass ?>">
                                        <?php if ($titleLink): ?>
                                            <a href="<?= htmlspecialcharsbx($titleLink) ?>" class="block no-underline">
                                        <?php endif; ?>
                                            <h2 class="max-w-2xl text-4xl font-semibold tracking-tight lg:text-6xl">
                                                <?= htmlspecialcharsbx($arItem['NAME']) ?>
                                            </h2>
                                        <?php if ($titleLink): ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (strlen((string)$arItem['PREVIEW_TEXT'])): ?>
                                            <div class="mt-5 max-w-2xl text-lg font-thin leading-8 <?= $secondaryTextClass ?>">
                                                <?= $arItem['PREVIEW_TEXT'] ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($button1Text || $button2Text): ?>
                                            <div class="mt-8 flex flex-wrap gap-4">
                                                <?php if ($button1Text && $button1Link): ?>
                                                    <a
                                                        href="<?= htmlspecialcharsbx($button1Link) ?>"
                                                        class="inline-block rounded-md bg-accent px-10 py-4 text-base font-medium uppercase text-gray-950 transition hover:bg-link hover:text-white"
                                                    >
                                                        <?= htmlspecialcharsbx($button1Text) ?>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($button2Text && $button2Link): ?>
                                                    <a
                                                        href="<?= htmlspecialcharsbx($button2Link) ?>"
                                                        class="inline-block rounded-md border border-white/40 bg-white/10 px-10 py-4 text-base font-medium uppercase text-white transition hover:border-white hover:bg-white/20"
                                                    >
                                                        <?= htmlspecialcharsbx($button2Text) ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="hidden lg:block">
                                        <?php if ($foregroundSrc): ?>
                                            <?php if ($titleLink): ?>
                                                <a href="<?= htmlspecialcharsbx($titleLink) ?>" class="block">
                                            <?php endif; ?>
                                                <div class="ml-auto max-w-[28rem] overflow-hidden rounded-3xl border border-white/10 bg-white/10 p-3 shadow-2xl backdrop-blur-sm">
                                                    <img
                                                        src="<?= htmlspecialcharsbx($foregroundSrc) ?>"
                                                        alt="<?= htmlspecialcharsbx($arItem['NAME']) ?>"
                                                        title="<?= htmlspecialcharsbx($arItem['NAME']) ?>"
                                                        class="h-[22rem] w-full rounded-[1.3rem] object-cover"
                                                        loading="<?= $index === 0 ? 'eager' : 'lazy' ?>"
                                                    />
                                                </div>
                                            <?php if ($titleLink): ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($hasSlider): ?>
                <div class="pointer-events-none absolute inset-x-0 bottom-6 z-20">
                    <div class="container mx-auto flex items-center justify-between px-4">
                        <div class="swiper-pagination !static !w-auto"></div>
                        <div class="pointer-events-auto flex items-center gap-3">
                            <button type="button" class="swiper-button-prev !relative !left-auto !top-auto">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button type="button" class="swiper-button-next !relative !right-auto !top-auto">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($hasSlider): ?>
        <script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/swiper-bundle.min.js"></script>
        <script>
            (function () {
                var root = document.getElementById('<?= CUtil::JSEscape($sliderId) ?>');
                if (!root || typeof Swiper === 'undefined') {
                    return;
                }

                new Swiper(root, {
                    loop: <?= $itemsCount > 2 ? 'true' : 'false' ?>,
                    speed: 700,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: root.querySelector('.swiper-pagination'),
                        clickable: true
                    },
                    navigation: {
                        nextEl: root.querySelector('.swiper-button-next'),
                        prevEl: root.querySelector('.swiper-button-prev')
                    }
                });
            })();
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php $frame->end(); ?>
