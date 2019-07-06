<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit();
if (!isset($_POST['action']) || $_POST['action'] !== 'load_script') exit();

function getScript()
{
    ob_start();
    $_SERVER['REQUEST_URI'] = $_POST['url'];
    include($_SERVER['DOCUMENT_ROOT'] . '/commenton/index.php');
    return ob_get_clean();
}

$echo = getScript();

exit(json_encode($echo));