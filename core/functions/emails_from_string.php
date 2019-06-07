<? # Функции для вытаскивания всех емейлов из строки

$log->LogInfo('Got this file');

function emails_from_string($str){
	global $log;
    $log->LogDebug("Called '".(__FUNCTION__)."' function with params: ".implode(',',func_get_args()));
    // Это регулярное выражение извлекает все электронные письма из строки:
    $regexp = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
    preg_match_all($regexp, $str, $m);

    return isset($m[0]) ? $m[0] : array();
}
/*
// Тестовый текст
$test_string = 'This is a test string...
        test1@example.org

        Test different formats:
        test2@example.org;
        <a href="test3@example.org">foobar</a>
        <test4@example.org>

        strange formats:
        test5@example.org
        test6[at]example.org
        test7@example.net.org.com
        test8@ example.org
        test9@!foo!.org
        foobar
';
// Получаем список адресов
print_r(extract_emails($test_string));
*/