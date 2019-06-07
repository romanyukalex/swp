<? # Функция поднимает первую букву для русских фраз


function string_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}