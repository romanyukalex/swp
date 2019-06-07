<?php
/*Функции выдают HTML или текст по названию класса из DomDocument

$content=get_html_code_url($url);
if($dom) unset($dom);
$dom = new DOMDocument;
@$dom->loadHTML($content);
$classname = 'article__content';
$artcl= DOM_getHTMLByClass($dom, $classname);
#А далее что угодно:
$artcl =  preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i','<$1$2>', $artcl); // у всех тегов вырезаем атрибуты   
*/

	
 function DOM_getHTMLByClass(&$parentNode, $classname) {
        global $log;
        $log->LogDebug("Called '".(__FUNCTION__)."' function with params: classname - ".$classname);
        $finder = new DomXPath($parentNode);
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        $tmp_dom = new DOMDocument(); 
        foreach ($nodes as $node) {$tmp_dom->appendChild($tmp_dom->importNode($node,true));}
        $innerHTML.=trim($tmp_dom->saveHTML());
        unset($tmp_dom);
        return  html_entity_decode ($innerHTML);
}

function DOM_getTextByClass(&$parentNode, $tagName, $className) {
    $nodes=array();

    $childNodeList = $parentNode->getElementsByTagName($tagName);
	
    for ($i = 0; $i < $childNodeList->length; $i++) {

        $temp = $childNodeList->item($i);

        if (stripos($temp->getAttribute('class'), $className) !== false) {
			$nodes[]=$temp;
        }
    }

    return $nodes;
}
#Выбрать HTML из какого то item
/*$tags = $dom->getElementsByTagName('div');
foreach ($tags as $item) {
	if($item->getAttribute('class')=="someclass"){ $jokehtml= DOM_getInnerHTML($item);}
}*/
function DOM_getInnerHTML($element) { 
    $innerHTML = ""; 
    $children  = $element->childNodes;

    foreach ($children as $child) 
    { 
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }

    return $innerHTML; 
} 
?>
