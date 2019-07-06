<?

//$rr="конь@грива";
//$word_Bases=insert_module("search_morph","get_Base",$rr);
//$word_Bases=insert_module("search_morph","get_Base","сияешь","стали","колоть","сталеварил","all","fdfsd","замок");
//var_dump($word_Bases);

//insert_module("search_morph","build_index","from_categories");


//$soap_opt=array("trace" => true,'exceptions' => true,"login"=>"appadmin", "password"=>"q1");
/*
$soap_opt=array("trace" => true,'exceptions' => true,
	"stream_context" =>
    stream_context_create(array ("http"=>array( "header"=> "userName:appadmin\r\n".
                   "password:q1\r\n"
    )))
);
*/

//system("find ./ -type f -mtime -9 | xargs ls -la | awk '{print $6,$7,$8,$9}'");

insert_function('abracadabra');
$tt=abracadabra(8,'digits');
echo $tt.'<br>';
echo abracadabra(10,'human_readable');



insert_module("add_to_copy","#copy_test","<br>Подробнее: у нас на сайте",8);

?>
<div id='copy_test'>dfjsjkjfklsdjfkljsdklfj sdfj sdlfj sdjf klsdjklsdjfkl sd</div>