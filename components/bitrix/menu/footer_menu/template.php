<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Ожидаем плоский $arResult от компонента и собираем дерево из 2-х уровней:
 * - DEPTH_LEVEL = 1 — родительский пункт
 * - DEPTH_LEVEL = 2 — дочерний пункт
 * Глубже 2 уровня игнорируем для простоты (можно расширить при желании).
 */

$tree = [];
$parentIndex = -1;

foreach ($arResult as $item) {
    $depth = (int)$item["DEPTH_LEVEL"];
    if ($depth === 1) {
        $parentIndex++;
        $tree[$parentIndex] = [
            "TEXT" => $item["TEXT"],
            "LINK" => $item["LINK"],
            "SELECTED" => !empty($item["SELECTED"]),
            "PERMISSION" => $item["PERMISSION"],
            "PARAMS" => $item["PARAMS"] ?? [],
            "CHILDREN" => [],
        ];
    } elseif ($depth === 2 && $parentIndex >= 0) {
        $tree[$parentIndex]["CHILDREN"][] = [
            "TEXT" => $item["TEXT"],
            "LINK" => $item["LINK"],
            "SELECTED" => !empty($item["SELECTED"]),
            "PERMISSION" => $item["PERMISSION"],
            "PARAMS" => $item["PARAMS"] ?? [],
        ];
    }
}

if (empty($tree)) return;

// вспомогалки
$esc = static function ($s) {
    return htmlspecialcharsbx((string)$s);
};
$isExternal = static function ($url) {
    // простая эвристика для внешних ссылок
    return (bool)preg_match('~^https?://~i', (string)$url);
};
?>

<nav class="w-full" aria-label="Footer menu">
    <!-- 1 колонка на мобиле, 3 колонки начиная с md -->
    <ul class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
        <?php foreach ($tree as $node): ?>
            <li>
                <?php
                $parentClasses = [
                    // белый/почти белый на чёрном фоне контейнера
                    "text-white",
                    "hover:text-gray-200",
                    "focus:outline-none",
                    "focus-visible:ring",
                    "focus-visible:ring-white/40",
                    "transition",
                    "inline-block",
                    "font-medium",
                    "mb-3"
                ];
                if (!empty($node["SELECTED"])) {
                    $parentClasses[] = "underline";
                    $parentClasses[] = "underline-offset-4";
                    $parentClasses[] = "decoration-white/60";
                }
                $parentClassAttr = implode(' ', $parentClasses);
                $parentLink = $esc($node["LINK"]);
                $parentText = $esc($node["TEXT"]);
                $parentIsExternal = $isExternal($node["LINK"]);
                ?>

                <!-- Родительский пункт -->
                <a
                        class="<?= $parentClassAttr ?>"
                        href="<?= $parentLink ?>"
                    <?= $parentIsExternal ? 'target="_blank" rel="noopener"' : '' ?>
                >
                    <?= $parentText ?>
                </a>

                <!-- Подменю (второй уровень), если есть -->
                <?php if (!empty($node["CHILDREN"])): ?>
                    <ul class="space-y-2">
                        <?php foreach ($node["CHILDREN"] as $child): ?>
                            <?php
                            $childClasses = [
                                "text-gray-200",      // чуть менее яркий, но всё ещё читабельный
                                "hover:text-white",
                                "focus:outline-none",
                                "focus-visible:ring",
                                "focus-visible:ring-white/40",
                                "transition",
                                "inline-block"
                            ];
                            if (!empty($child["SELECTED"])) {
                                $childClasses[] = "underline";
                                $childClasses[] = "underline-offset-4";
                                $childClasses[] = "decoration-white/50";
                            }
                            $childClassAttr = implode(' ', $childClasses);
                            $childLink = $esc($child["LINK"]);
                            $childText = $esc($child["TEXT"]);
                            $childIsExternal = $isExternal($child["LINK"]);
                            ?>
                            <li>
                                <a
                                        class="<?= $childClassAttr ?>"
                                        href="<?= $childLink ?>"
                                    <?= $childIsExternal ? 'target="_blank" rel="noopener"' : '' ?>
                                >
                                    <?= $childText ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>