<?php
if (!isset($_SESSION[CN_S_SORT])) {
    $getSort = CN_SET_SORT;
} else {
    $getSort = $_SESSION[CN_S_SORT];
}

if ($getSort == 'new') echo CN_SORT_BY_NEW;
elseif ($getSort == 'old') echo CN_SORT_BY_OLD;
elseif ($getSort == 'best') echo CN_SORT_BY_BEST;
?>
<div class="cn_sort_block">
    <div class="cn_sort_box">
        <?php if ($getSort != 'new'): ?>
            <div class="cn_sort_point" data-cn-sort="new"><? echo CN_SORT_BY_NEW; ?></div>
        <? endif; ?>
        <?php if ($getSort != 'old'): ?>
            <div class="cn_sort_point" data-cn-sort="old"><? echo CN_SORT_BY_OLD; ?></div>
        <? endif; ?>
        <?php if (CN_SET_HYPE == 'on'): ?>
            <?php if ($getSort != 'best'): ?>
                <div class="cn_sort_point" data-cn-sort="best"><? echo CN_SORT_BY_BEST; ?></div>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>