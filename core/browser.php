<?php
/*
 * Функция определения браузера пользователя
 * @version 0.1
 * @author recens
 * @license GPL
 * @copyright Гельтищева Нина (http://recens.ru)
 */
 
 
 /* Не определяется Apple редирект (внутренний браузер iPhone) 
 Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en)
AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1C25 Safari/419.3
*/
$log->LogInfo('Got this file');
function user_browser($agent) {
	global $log;
	preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon|Googlebot|Yandex|Rambler)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить 90% браузеров
        list(,$browser,$version) = $browser_info; // получаем данные из массива в переменную
        if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)){ // определение _очень_старых_ версий Оперы (до 8.50), при желании можно убрать
			return 'Opera '.$opera[1];
		}
        if ($browser == 'MSIE') { // если браузер определён как IE
                preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
                if ($ie){ // если да, то возвращаем сообщение об этом
					return $ie[1].' '.$version;
				}
                return 'IE '.$version; // иначе просто возвращаем IE и номер версии
        }
        if ($browser == 'Firefox') { // если браузер определён как Firefox
                preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff); // проверяем, не разработка ли это на основе Firefox
                if ($ff){ // если да, то выводим номер и версию
					return $ff[1].' '.$ff[2];
				}
        }
        if ($browser == 'Opera' && $version == '9.80'){ // если браузер определён как Opera 9.80, берём версию Оперы из конца строки
			return 'Opera '.substr($agent,-5);
			}
        if ($browser == 'Version'){ // определяем Сафари
			return 'Safari '.$version;
		}
        if (!$browser && strpos($agent, 'Gecko')){ // для неопознанных браузеров проверяем, если они на движке Gecko, и возращаем сообщение об этом
			return 'Gecko unknown';
		}
        return $browser.' '.$version; // для всех остальных возвращаем браузер и версию
}

$browserinfo = explode(' ', user_browser($_SERVER['HTTP_USER_AGENT']));
$browser=strtolower($browserinfo[0]);
$browserversion=$browserinfo[1];
if($browserinfo) $log->LogDebug('Browser matched:'.$browser.', version - '.$browserversion.'.User agent was - '.$_SERVER['HTTP_USER_AGENT']);
?>