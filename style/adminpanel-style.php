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

<? //.settings_table td.valuestd input{background-color:#BBB;}?>
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
