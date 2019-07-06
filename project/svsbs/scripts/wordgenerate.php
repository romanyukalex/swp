<?php
     
//$fp = fopen("customer_contract_with_svsbs.doc", 'r');
// $text = fread($fp, filesize('customer_contract_with_svsbs.doc'));
// echo $text;
//  fclose($fp);
  $fp = fopen("customer_contract_with_svsbs.doc", 'w+');
   $text = "							Командиру в/ч № ______________ г. _____________________
   как дела )) ";
    echo $text;
   fwrite($fp, $text);
   fclose($fp);
/*
header("Content-Type: application/vnd.ms-word");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=customer_contract_with_svsbs.doc");*/
?>