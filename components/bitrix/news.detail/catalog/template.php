<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?><? $this->setFrameMode(
        true
); ?>

<div class="container mb-12 mx-auto">
    <? if (strlen($arResult['FIELDS']['PREVIEW_TEXT'])): ?>
        <div class="mb-2 text-2xl leading-9 font-thin max-w-3xl">
            <? if ($arResult['DETAIL_TEXT_TYPE'] == 'text'): ?>
                <p><?= $arResult['FIELDS']['PREVIEW_TEXT']; ?></p>
            <? else: ?>
                <?= $arResult['FIELDS']['PREVIEW_TEXT']; ?>
            <? endif; ?>
        </div>
    <? endif; ?>

    <div class="my-8 head<?= ($arResult['GALLERY'] ? '' : ' wti') ?>">
        <div class="flex flex-col gap-8<?=$arResult['GALLERY'] ? ' md:flex-row' : ''?>"">
            <? if ($arResult['GALLERY']): ?>
                <div class="overflow-hidden md:w-2/3">
                    <div class="gallery" data-gallery="<?= $arResult['ID'] ?>">
                        <!-- Большое изображение -->
                        <div class="mb-4">
                            <img
                                    class="w-full aspect-[4/3] object-cover rounded-md cursor-zoom-in"
                                    data-main-image
                                    src="<?= $arResult['GALLERY'][0]['DETAIL']['SRC'] ?>"
                                    alt="<?= $arResult['GALLERY'][0]['ALT'] ?>"
                                    title="<?= $arResult['GALLERY'][0]['TITLE'] ?>"
                                    itemprop="image"
                            />
                        </div>

                        <!-- Превьюшки -->
                        <? if (count($arResult['GALLERY']) > 1): ?>
                            <div class="flex gap-2 overflow-x-auto pb-2 -mx-2 px-2 whitespace-nowrap">
                                <? foreach ($arResult['GALLERY'] as $index => $arPhoto): ?>
                                    <button
                                            type="button"
                                            class="group relative shrink-0 w-20 h-20 rounded-md overflow-hidden border-2 <?= ($index === 0 ? 'border-blue-500' : 'border-transparent') ?>"
                                            data-thumb
                                            data-index="<?= $index ?>"
                                            data-full="<?= $arPhoto['DETAIL']['SRC'] ?>"
                                    >
                                        <img
                                                src="<?= $arPhoto['THUMB']['src'] ?>"
                                                alt="<?= $arPhoto['ALT'] ?>"
                                                title="<?= $arPhoto['TITLE'] ?>"
                                                class="w-full h-full object-cover group-hover:opacity-80 transition"
                                        />
                                    </button>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>

                        <!-- Оверлей / лайтбокс -->
                        <div
                                class="fixed inset-0 bg-white z-50 hidden items-center justify-center"
                                data-lightbox
                        >
                            <div class="relative max-w-3xl w-full px-4">
                                <!-- Картинка в лайтбоксе -->
                                <img
                                        class="w-full max-h-[80vh] object-contain rounded-lg"
                                        data-lightbox-image
                                        src=""
                                        alt=""
                                />

                            </div>
                            <!-- Кнопка закрытия -->
                            <button
                                    type="button"
                                    class="absolute top-4 right-4 text-gray-950 text-4xl"
                                    data-lightbox-close
                            >
                                &times;
                            </button>
                            <!-- Кнопки навигации -->
                            <button
                                    type="button"
                                    class="absolute top-1/2 left-2 -translate-y-1/2 text-gray-950 text-4xl px-2"
                                    data-lightbox-prev
                            >
                                ‹
                            </button>
                            <button
                                    type="button"
                                    class="absolute top-1/2 right-2 -translate-y-1/2 text-gray-950 text-4xl px-2"
                                    data-lightbox-next
                            >
                                ›
                            </button>
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="<?= ($arResult['GALLERY'] ? 'md:w-1/3' : ''); ?>">
                <div class="info">
                    <?
                    $frame = $this->createFrame('info')->begin('');
                    $frame->setAnimation(true);
                    ?>

                    <? if ($arResult['DISPLAY_PROPERTIES']['PRICE']['VALUE']): ?>

                        <div class="price flex flex-col gap-4">
                            <div class="price_new text-4xl font-medium"><?= CScorp::FormatPriceShema(
                                            $arResult['DISPLAY_PROPERTIES']['PRICE']['VALUE']
                                    ) ?></div>
                            <? if ($arResult['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE']): ?>
                                <div class="price_old text-xl font-thin leading-8"><?= GetMessage('DISCOUNT_PRICE') ?>
                                    &nbsp;<?= $arResult['DISPLAY_PROPERTIES']['PRICEOLD']['VALUE'] ?>
                                </div>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                    <div class="mb-1 text-xl font-semibold leading-8 text-amber-400">
                        <?= GetMessage('CTA_TEXT') ?>
                    </div>
                    <? if ($arResult['DISPLAY_PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES'): ?>
                        <div class="order my-4">
                            <? if ($arResult['DISPLAY_PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES'): ?>
                                <span class="inline-block px-12 py-4 rounded-md bg-amber-500 text-gray-950 uppercase" data-event="jqm"
                                      data-param-id="<?= CCache::$arIBlocks[SITE_ID]['aspro_scorp_form']['aspro_scorp_order_product'][0] ?>"
                                      data-name="order_product"
                                      data-product="<?= $arResult['NAME'] ?>"><?= (strlen(
                                            $arParams['S_ORDER_PRODUCT']
                                    ) ? $arParams['S_ORDER_PRODUCT'] : GetMessage(
                                            'S_ORDER_PRODUCT'
                                    )) ?></span>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                    <? $frame->end(); ?>
                </div>
            </div>
        </div>
    </div>

    <? if (strlen($arResult['FIELDS']['DETAIL_TEXT'])): ?>
        <div class="content text-xl font-thin leading-8">
            <? if ($arResult['DETAIL_TEXT_TYPE'] == 'text'): ?>
                <p><?= $arResult['FIELDS']['DETAIL_TEXT']; ?></p>
            <? else: ?>
                <?= $arResult['FIELDS']['DETAIL_TEXT']; ?>
            <? endif; ?>
        </div>
    <? endif; ?>
    <?
    $frame = $this->createFrame('order')->begin('');
    $frame->setAnimation(true);
    ?>
    <? // order?>
    <? if ($arResult['DISPLAY_PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES'): ?>
        <div class="md:flex gap-10 my-8 py-10 border-t border-gray-200 border-b">
            <div>
                <srong class="block mb-2 text-2xl font-semibold">Есть вопрос?</srong>
                <p class="text-2xl font-thin leading-8">Cпециалист свяжется с вами в течении 24 часов.</p>
            </div>
            <div class="md:ml-auto my-4">
                <span class="inline-block px-12 py-4 rounded-md bg-gray-400 text-gray-50 uppercase" data-event="jqm"
                      data-param-id="<?= CCache::$arIBlocks[SITE_ID]['aspro_scorp_form']['aspro_scorp_question'][0] ?>"
                      data-name="question"
                      data-autoload-NEED_PRODUCT="<?= $arResult['NAME'] ?>"><?= (strlen(
                            $arParams['S_ASK_QUESTION']
                    ) ? $arParams['S_ASK_QUESTION'] : GetMessage(
                            'S_ASK_QUESTION'
                    )) ?></span>
            </div>
        </div>
    <? endif; ?>
    <? $frame->end(); ?>

    <? // characteristics?>
    <? if ($arResult['CHARACTERISTICS']): ?>
        <div class="wraps">
            <h2 class="text-5xl mb-10"><?= (strlen(
                        $arParams['T_CHARACTERISTICS']
                ) ? $arParams['T_CHARACTERISTICS'] : GetMessage('T_CHARACTERISTICS')) ?></h2>
            <div class="content text-lg font-thin leading-8">
                <table class="props_table">
                    <? foreach ($arResult['CHARACTERISTICS'] as $arProp): ?>
                        <tr class="char">
                            <td class="char_name">
                                <? if ($arProp['HINT']): ?>
                                    <div class="hint">
                                        <span class="icons" data-toggle="tooltip"
                                              data-placement="top"
                                              title="<?= $arProp['HINT'] ?>"></span>
                                    </div>
                                <? endif; ?>
                                <span><?= $arProp['NAME'] ?></span>
                            </td>
                            <td class="char_value">
                            <span>
                                <? if (is_array($arProp['DISPLAY_VALUE'])): ?>
                                    <? foreach ($arProp['DISPLAY_VALUE'] as $key => $value): ?>
                                        <? if ($arProp['DISPLAY_VALUE'][$key + 1]): ?>
                                            <?= $value . '&nbsp;/ ' ?>
                                        <? else: ?>
                                            <?= $value ?>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                <? else: ?>
                                    <?= $arProp['DISPLAY_VALUE'] ?>
                                <? endif; ?>
                            </span>
                            </td>
                        </tr>
                    <? endforeach; ?>
                </table>
            </div>
        </div>
    <? endif; ?>

    <? if (count($arResult["SEE_ALSO"]) > 100 ): // TODO ?>
        <div class="wraps">
            <hr/>
            <h4 class="underline"><?= (strlen(
                        $arParams['T_SEEALSO']
                ) ? $arParams['T_SEEALSO'] : GetMessage('T_SEEALSO')) ?></h4>
            <div class="row chars">
                <div class="col-md-12">
                    <?
                    $GLOBALS['arrFilterLinked'] = array('=ID' => $arResult["SEE_ALSO"]);

                    $APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "see-also",
                            array(
                                    "FILTER_NAME" => "arrFilterLinked",
                                    "IBLOCK_ID" => 17,
                                    "NEWS_COUNT" => 5,
                                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                    "INCLUDE_SUBSECTIONS" => "N",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "SHOW_DETAIL_LINK" => $arParams["SHOW_DETAIL_LINK"],
                            ),
                            $component
                    );

                    ?>
                </div>
            </div>
        </div>
    <? endif; ?>

    <? // docs files?>
    <? if ($arResult['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE']): ?>
        <div class="docs content">
            <h4 class="underline"><?= (strlen(
                        $arParams['T_DOCS']
                ) ? $arParams['T_DOCS'] : GetMessage('T_DOCS')) ?></h4>
            <div class="row docs flex flex-col gap-6 text-xl text-thin">
                <? foreach ($arResult['PROPERTIES']['DOCUMENTS']['VALUE'] as $docID): ?>
                    <? $arItem = CScorp::get_file_info($docID); ?>
                    <div class="flex gap-2">
                        <? if ($arItem['TYPE'] == 'pdf'):?>
                            <svg role="presentation"  style="width:50px;" fill="#ff8562" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90 90"><path d="M90 28H80V16.4L63.6 0H10v28H0v40h10v22h70V68h10V28zM65 8.5l6.5 6.5H65V8.5zM15 5h45v15h15v8H15V5zm60 80H15V68h60v17zm10-22H5V33h80v30z"></path><path class="st0" d="M25 53h2.5c4.1 0 7.5-3.4 7.5-7.5S31.6 38 27.5 38h-5c-1.4 0-2.5 1.1-2.5 2.5V58h5v-5zm0-10h2.5c1.4 0 2.5 1.1 2.5 2.5S28.9 48 27.5 48H25v-5zM52.5 50.5v-5c0-4.1-3.4-7.5-7.5-7.5h-7.5v20H45c4.1 0 7.5-3.4 7.5-7.5zm-10-7.5H45c1.4 0 2.5 1.1 2.5 2.5v5c0 1.4-1.1 2.5-2.5 2.5h-2.5V43zM60 50.5h7.5v-5H60V43h10v-5H57.5c-1.4 0-2.5 1.1-2.5 2.5V58h5v-7.5z"></path></svg>
                        <? endif; ?>
                        <?
                        $fileName = substr(
                                $arItem['ORIGINAL_NAME'],
                                0,
                                strrpos($arItem['ORIGINAL_NAME'], '.')
                        );
                        $fileTitle = (strlen(
                                $arItem['DESCRIPTION']
                        ) ? $arItem['DESCRIPTION'] : $fileName);
                        ?>
                        <div>
                            <a class="text-gray-900 block" href="<?= $arItem['SRC'] ?>" target="_blank"
                               title="<?= $fileTitle ?>"><?= $fileTitle ?></a>
                            <span class="block"><?= CScorp::filesize_format($arItem['FILE_SIZE']); ?></span>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    <? endif; ?>

    <?
    $frame = $this->createFrame('video')->begin('');
    $frame->setAnimation(true);
    ?>
    <? // video?>
    <? if ($arResult['VIDEO']): ?>
        <div class="wraps">
            <hr/>
            <h4 class="underline"><?= (strlen(
                        $arParams['T_VIDEO']
                ) ? $arParams['T_VIDEO'] : GetMessage('T_VIDEO')) ?></h4>
            <div class="row video">
                <? foreach ($arResult['VIDEO'] as $i => $arVideo): ?>
                    <div class="col-md-6 item">
                        <div class="video_body">
                            <video id="js-video_<?= $i ?>" width="350" height="217" class="video-js"
                                   controls="controls" preload="metadata" data-setup="{}">
                                <source src="<?= $arVideo["path"] ?>" type='video/mp4'/>
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider
                                    upgrading to a web browser that supports HTML5 video
                                </p>
                            </video>
                        </div>
                        <div class="title"><?= (strlen(
                                    $arVideo["title"]
                            ) ? $arVideo["title"] : $i) ?></div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    <? endif; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.gallery[data-gallery]').forEach(function (gallery) {
            const mainImage = gallery.querySelector('[data-main-image]');
            const thumbs = Array.from(gallery.querySelectorAll('[data-thumb]'));
            const lightbox = gallery.querySelector('[data-lightbox]');
            const lightboxImage = gallery.querySelector('[data-lightbox-image]');
            const btnClose = gallery.querySelector('[data-lightbox-close]');
            const btnPrev = gallery.querySelector('[data-lightbox-prev]');
            const btnNext = gallery.querySelector('[data-lightbox-next]');

            let currentIndex = 0;

            function setActive (index) {
                currentIndex = index;

                const thumb = thumbs[index];
                if (!thumb) {
                    return;
                }

                const full = thumb.getAttribute('data-full');

                if (mainImage) {
                    mainImage.src = full;

                    const imgInside = thumb.querySelector('img');
                    if (imgInside) {
                        mainImage.alt = imgInside.alt || '';
                        mainImage.title = imgInside.title || '';
                    }
                }

                thumbs.forEach(function (t) {
                    t.classList.remove('border-blue-500');
                });
                thumb.classList.add('border-blue-500');
            }

            function syncLightboxImage () {
                if (lightboxImage && mainImage) {
                    lightboxImage.src = mainImage.src;
                    lightboxImage.alt = mainImage.alt;
                }
            }

            function openLightbox (index) {
                setActive(index);
                syncLightboxImage();

                if (lightbox) {
                    lightbox.classList.remove('hidden');
                    lightbox.classList.add('flex');
                }
            }

            function closeLightbox () {
                if (lightbox) {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                }
            }

            function showNext () {
                if (!thumbs.length) {
                    return;
                }
                const nextIndex = (currentIndex + 1) % thumbs.length;
                setActive(nextIndex);
                syncLightboxImage();
            }

            function showPrev () {
                if (!thumbs.length) {
                    return;
                }
                const prevIndex = (currentIndex - 1 + thumbs.length) % thumbs.length;
                setActive(prevIndex);
                syncLightboxImage();
            }

            // клики по превью
            thumbs.forEach(function (thumb) {
                thumb.addEventListener('click', function () {
                    const index = parseInt(thumb.getAttribute('data-index'), 10) || 0;
                    setActive(index);
                });
            });

            // клик по большой картинке — открыть лайтбокс
            if (mainImage) {
                mainImage.addEventListener('click', function () {
                    openLightbox(currentIndex);
                });
            }

            if (btnClose) {
                btnClose.addEventListener('click', closeLightbox);
            }
            if (btnNext) {
                btnNext.addEventListener('click', showNext);
            }
            if (btnPrev) {
                btnPrev.addEventListener('click', showPrev);
            }

            // клик по фону лайтбокса
            if (lightbox) {
                lightbox.addEventListener('click', function (e) {
                    if (e.target === lightbox) {
                        closeLightbox();
                    }
                });
            }

            // клавиатура
            document.addEventListener('keydown', function (e) {
                if (!lightbox || lightbox.classList.contains('hidden')) {
                    return;
                }

                if (e.key === 'Escape') {
                    closeLightbox();
                }
                if (e.key === 'ArrowRight') {
                    showNext();
                }
                if (e.key === 'ArrowLeft') {
                    showPrev();
                }
            });

            // стартовое состояние
            if (thumbs.length) {
                setActive(0);
            }
        });
    });
</script>
<? $frame->end(); ?>
