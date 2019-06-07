<?php 
$log->LogInfo("Got ".(__FILE__));?> 


/* ADMINPANEL STYLES */
body{background-color:<?=$adminpanelbckclr?>;}


<? # Градиент?>
 .gradient_to_top_1{ background: linear-gradient(to bottom, #56a7d4, #2b7ca0);}
 .gradient_to_top_2{ background: linear-gradient(to bottom, #56a7d4 0%, #828c95 36%, #b7ca0 100%);}
 .gradient_to_top_green{ background: linear-gradient(to bottom, #92d91d, #74c22f);}
<?# Стили для админки?>
.admintable th{background-color: #CCCCCC}
.admintable tr{background-color:#DDDDDD}
.admintable tr:hover{background-color:#FFFFFF;cursor:pointer}
.admintable img,.smallimg{border:none; height:32px;vertical-align:middle;margin-right:3px;}

.actionstd{ cursor:text}
#adminblock{height:100%}
#adminblocktable{width:100%}
.settings_table td{
	padding:7px;
	border:2px solid #D5D5D5;
	background-color:#FFFFFF;
}

.settings_table td.valuestd input{background-color:#BBB;}
.settings_table td.actiontd{
	padding-left:20px
}
.settings_table th{
	color:#FFFFFF;
}
.settings_table{
	background-color : transparent;
	border-spacing:0;
	border-collapse: separate;
	border:none none;
}
.ap_table td{
	font-size:12;
}
a{	cursor:pointer;
	color:#2d7ea2;
}
.example{
	display: none;
	border:2px solid #D5D5D5;
	padding:5px;
	width:75%;
}

.users-management-menu-button {
	text-decoration: none;
}
#ap_topmenu_tr td div{
	padding: 0 20px 0;
	float:left;
}
#ap_topmenu_tr img{
	height:60px;
}
<? # Модальное окно?>
/* Контейнер */
.modal {

/* Слой перекрытия */
position: fixed;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: rgba(0,0,0,0.5);
z-index: 10000;

/* Трансформации прозрачности при открытии  */
-webkit-transition: opacity 500ms ease-in;
-moz-transition: opacity 500ms ease-in;
transition: opacity 500ms ease-in;

/* Скрываем изначально */
opacity: 0;
pointer-events: none;
}

/* Показываем модальное окно */
.modal:target {
opacity: 1;
pointer-events: auto;
}

/* Содержание */
.modal > div {
width: 500px;
background: #fff;
position: relative;
margin: 10% auto;

/* По умолчанию минимизируем анимацию */
-webkit-animation: minimise 500ms linear;

/* Придаем хороший вид */
padding: 30px;
-moz-border-radius: 7px;
border-radius: 7px;
-webkit-box-shadow: 0 3px 20px rgba(0,0,0,0.9);
-moz-box-shadow: 0 3px 20px rgba(0,0,0,0.9);
box-shadow: 0 3px 20px rgba(0,0,0,0.9);
background: -moz-linear-gradient(#fff, #ccc);
background: -webkit-gradient(linear, right bottom, right top, color-stop(1, rgb(255,255,255)), color-stop(0.57, rgb(230,230,230)));
text-shadow: 0 1px 0 #fff;
}

/* Изменяем анимацию при открытии модального окна*/
.modal:target > div {
-webkit-animation-name: bounce;
}

.modal h2 {
font-size: 36px;
padding: 0 0 20px;
}

@-webkit-keyframes bounce {
  0% {
  	-webkit-transform: scale3d(0.1,0.1,1);
  	-webkit-box-shadow: 0 3px 20px rgba(0,0,0,0.9);
  }
  55% {
  	-webkit-transform: scale3d(1.08,1.08,1);
  	-webkit-box-shadow: 0 10px 20px rgba(0,0,0,0);
  }
  75% {
  	-webkit-transform: scale3d(0.95,0.95,1);
  	-webkit-box-shadow: 0 0 20px rgba(0,0,0,0.9);
  }
  100% {
  	-webkit-transform: scale3d(1,1,1);
  	-webkit-box-shadow: 0 3px 20px rgba(0,0,0,0.9);
  }
}

@-webkit-keyframes minimise {
  0% {
  	-webkit-transform: scale3d(1,1,1);
  }
  100% {
  	-webkit-transform: scale3d(0.1,0.1,1);
  }
}

/* Ссылка на кнопку Закрыть */
.modal a[href="#close"] {
position: absolute;
right: 0;
top: 0;
color: transparent;
}

/* Сбрасываем изменения */
.modal a[href="#close"]:focus {
outline: none;
}

/* Создаем кнопку Закрыть */
.modal a[href="#close"]:after {
content: 'X';
display: block;

/* Позиционируем */
position: absolute;
right: -10px;
top: -10px;
width: 1.5em;
padding: 1px 1px 1px 2px;

/* Стили */
text-decoration: none;
text-shadow: none;
text-align: center;
font-weight: bold;
background: #000;
color: #fff;
border: 3px solid #fff;
-moz-border-radius: 20px;
border-radius: 20px;
-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
box-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.modal a[href="#close"]:focus:after,
.modal a[href="#close"]:hover:after {
-webkit-transform: scale(1.1,1.1);
-moz-transform: scale(1.1,1.1);
}

.modal a[href="#close"]:focus:after {
outline: 1px solid #000;
}

/* Открываем модальное окно */
a.openModal {
margin: 1em auto;
display: block;
width: 200px;
background: #ccc;
text-align: center;
padding: 10px;
-moz-border-radius: 7px;
border-radius: 7px;
background: -moz-linear-gradient(#fff, #ddd);
background: -webkit-gradient(linear, right top, right bottom, from(rgb(255,255,255)), to(rgb(230,230,230)));
text-shadow: 0 1px 0 #fff;
border: 1px solid rgba(0,0,0,0.1);
-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.3);
-moz-box-shadow: 0 1px 1px rgba(0,0,0,0.3);
box-shadow: 0 1px 1px rgba(0,0,0,0.3);
}

a.openModal:hover,
a.openModal:focus {
background: -moz-linear-gradient(#fff, #ccc);
background: -webkit-gradient(linear, right top, right bottom, from(rgb(255,255,255)), to(rgb(200,200,200)));
}