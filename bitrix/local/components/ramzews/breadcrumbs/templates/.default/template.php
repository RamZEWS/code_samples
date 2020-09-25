<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<div class="col-xs-12 nospace">
    <div class="breadcrumbs">
        <ul>
            <?php
            $lastKey = end(array_keys($arResult["LIST"]));
            foreach($arResult["LIST"] as $k => $l) {
                $isLast = false;
                if($lastKey === $k) {
                    $isLast = true;
                    $l['link'] = "javascript:void(0)";
                }
            ?>
                <li><a href="<?= $l['link'] ?>" class="<?= $isLast ? "link-disabled" : "" ?>"><?= $l['name'] ?></a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>