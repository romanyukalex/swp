<? # Функция поднимает первую букву в предложении


function string_sentenceCase($s){
    $str = strtolower($s);
    $cap = true;
    
    for($x = 0; $x < strlen($str); $x++){
        $letter = substr($str, $x, 1);
        if($letter == "." || $letter == "!" || $letter == "?"){
            $cap = true;
        }elseif($letter != " " && $cap == true){
            $letter = strtoupper($letter);
            $cap = false;
        }
        
        $ret .= $letter;
    }
    
    return $ret;
}

/*
Example Usage:
echo sentenceCase("HELLO WORLD!!! THIS IS A CAPITALISED SENTENCE. this isn't.");

Returns:
Hello world!!! This is a capitalised sentence. This isn't.
*/
