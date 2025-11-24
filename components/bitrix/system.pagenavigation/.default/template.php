<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>

<? if (!$arResult["bDescPageNumbering"]) : ?>

    <div class="flex items-center justify-center gap-4 my-8 text-sm">

        <? // Номера страниц ?>
        <div class="flex items-center gap-1">
            <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]) : ?>

                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) : ?>
                    <span
                            class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-full bg-slate-300 text-slate-900 px-3 text-sm font-semibold">
						<?= $arResult["nStartPage"] ?>
					</span>
                <? else : ?>
                    <a
                            href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"
                            class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-full border border-slate-300 bg-white px-3 text-sm text-slate-700 hover:bg-slate-100 hover:border-slate-400 transition">
                        <?= $arResult["nStartPage"] ?>
                    </a>
                <? endif; ?>

                <? $arResult["nStartPage"]++; ?>
            <? endwhile; ?>
        </div>

        <? // Кнопки "назад/вперёд" ?>
        <div class="flex items-center gap-2">

            <? $isPrevDisabled = ($arResult["NavPageNomer"] < 2); ?>
            <div class="inline-flex">
                <a
                        <? if ($isPrevDisabled): ?>
                            href="javascript:void(0);"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white opacity-40 cursor-default pointer-events-none"
                        <? else: ?>
                            href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 bg-white hover:bg-slate-100 hover:border-slate-400 transition"
                        <? endif; ?>
                >
                    ‹
                </a>
            </div>

            <? $isNextDisabled = ($arResult["NavPageNomer"] >= $arResult["NavPageCount"]); ?>
            <div class="inline-flex">
                <a
                        <? if ($isNextDisabled): ?>
                            href="javascript:void(0);"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white opacity-40 cursor-default pointer-events-none"
                        <? else: ?>
                            href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 bg-white hover:bg-slate-100 hover:border-slate-400 transition"
                        <? endif; ?>
                >
                    ›
                </a>
            </div>

        </div>
    </div>

<? endif; ?>