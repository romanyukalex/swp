<?php
 /****************************************************************
  * Snippet Name : breadcrumb		           					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : Навигационная цепочка						 *
  * Access		 : include									 	 *
  ***************************************************************/
$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
?>
<ul id="breadcrumb">
    <li><a href="/">Главная</a></li>
    <li id="firstlevelcrumb"><a href="">Первый уровень</a></li>
    <li id="pagelink"><a href="" class="current">Вы здесь</a></li>
</ul>
<style>
	#breadcrumb{
	  background: #eee;
	  border-width: 1px;
	  border-style: solid;
	  border-color: #f5f5f5 #e5e5e5 #ccc;
	  -moz-border-radius: 5px;
	  -webkit-border-radius: 5px;
	  border-radius: 5px;
	  -moz-box-shadow: 0 0 2px rgba(0,0,0,.2);
	  -webkit-box-shadow: 0 0 2px rgba(0,0,0,.2);
	  box-shadow: 0 0 2px rgba(0,0,0,.2);
	  /* Сбрасываем обтекание текста */
	  overflow: hidden;
	  /*width: 50%;*/
	}
	
	#breadcrumb li{
	  float: left;
	}
	
	#breadcrumb a{
	  padding: .7em 1em .7em 2em;
	  float: left;
	  text-decoration: none;
	  color: #444;
	  position: relative;
	  text-shadow: 0 1px 0 rgba(255,255,255,.5);
	  background-color: #ddd;
	  background-image: -webkit-gradient(linear, left top, right bottom, from(#f5f5f5), to(#ddd));
	  background-image: -webkit-linear-gradient(left, #f5f5f5, #ddd);
	  background-image: -moz-linear-gradient(left, #f5f5f5, #ddd);
	  background-image: -ms-linear-gradient(left, #f5f5f5, #ddd);
	  background-image: -o-linear-gradient(left, #f5f5f5, #ddd);
	  background-image: linear-gradient(to right, #f5f5f5, #ddd);  
	}
	
	#breadcrumb li:first-child a{
	  padding-left: 1em;
	  -moz-border-radius: 5px 0 0 5px;
	  -webkit-border-radius: 5px 0 0 5px;
	  border-radius: 5px 0 0 5px;
	}
	
	#breadcrumb a:hover{
	  background: #fff;
	}
	
	#breadcrumb a::after,
	#breadcrumb a::before{
	  content: "";
	  position: absolute;
	  top: 50%;
	  margin-top: -1.5em;   
	  border-top: 1.5em solid transparent;
	  border-bottom: 1.5em solid transparent;
	  border-left: 1em solid;
	  right: -1em;
	}
	
	#breadcrumb a::after{ 
	  z-index: 2;
	  border-left-color: #ddd;  
	}
	
	#breadcrumb a::before{
	  border-left-color: #ccc;  
	  right: -1.1em;
	  z-index: 1; 
	}
	
	#breadcrumb a:hover::after{
	  border-left-color: #fff;
	}
	
	#breadcrumb .current,
	#breadcrumb .current:hover{
	  font-weight: bold;
	  background: none;
	}
	
	#breadcrumb .current::after,
	#breadcrumb .current::before{
	  content: normal;  
	}
	
</style>
<? } ?>