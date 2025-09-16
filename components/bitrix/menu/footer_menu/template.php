<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// Собираем дерево: верхний уровень и вложенные элементы
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
            "CHILDREN" => [],
        ];
    } elseif ($depth === 2 && $parentIndex >= 0) {
        $tree[$parentIndex]["CHILDREN"][] = [
            "TEXT" => $item["TEXT"],
            "LINK" => $item["LINK"],
            "SELECTED" => !empty($item["SELECTED"]),
        ];
    }
}

if (empty($tree)) return;

$esc = static fn($s) => htmlspecialcharsbx((string)$s);
$isExternal = static fn($url) => preg_match('~^https?://~i', (string)$url);
?>

<ul class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
    <?php foreach ($tree as $node): ?>
        <li>
            <?php
            $parentText = $esc($node["TEXT"]);
            $parentLink = $esc($node["LINK"]);
            $parentClasses = "font-bold tracking-wider text-white mb-4 block";
            ?>

            <!-- Родительский пункт -->
            <?php if ($parentLink): ?>
                <a href="<?= $parentLink ?>"
                   class="<?= $parentClasses ?>"
                    <?= $isExternal($node["LINK"]) ? 'target="_blank" rel="noopener"' : '' ?>>
                    <?= $parentText ?>
                </a>
            <?php else: ?>
                <span class="<?= $parentClasses ?>">
          <?= $parentText ?>
        </span>
            <?php endif; ?>

            <!-- Дочерние пункты -->
            <?php if (!empty($node["CHILDREN"])): ?>
                <ul class="space-y-0">
                    <?php foreach ($node["CHILDREN"] as $child): ?>
                        <?php
                        $childText = $esc($child["TEXT"]);
                        $childLink = $esc($child["LINK"]);
                        $childClasses = "font-light text-gray-200 hover:text-white transition py-1 block";
                        ?>
                        <li>
                            <?php if ($childLink): ?>
                                <a href="<?= $childLink ?>"
                                   class="<?= $childClasses ?>"
                                    <?= $isExternal($child["LINK"]) ? 'target="_blank" rel="noopener"' : '' ?>>
                                    <?= $childText ?>
                                </a>
                            <?php else: ?>
                                <span class="<?= $childClasses ?>">
                  <?= $childText ?>
                </span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>