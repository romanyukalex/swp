<div class="cn_set_menu">
    <a class="<?php if (!isset($_GET['s'])) echo 'cn_set_menu_select' ?>" href="?u=setting"><?php echo CN_COMMON; ?></a>
    <a class="<?php if (isset($_GET['s']) && $_GET['s'] == 'social') echo 'cn_set_menu_select' ?>" href="?u=setting&s=social"><?php echo CN_SOCIAL; ?></a>
    <a class="<?php if (isset($_GET['s']) && $_GET['s'] == 'admin') echo 'cn_set_menu_select' ?>" href="?u=setting&s=admin"><?php echo CN_ADMINISTRATOR; ?></a>
    <a class="<?php if (isset($_GET['s']) && $_GET['s'] == 'guests') echo 'cn_set_menu_select' ?>" href="?u=setting&s=guests"><?php echo CN_GUESTS; ?></a>
</div>