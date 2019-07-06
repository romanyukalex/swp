<img src="/project/cindict/files/notcommonfacts.png" height="60px" style="vertical-align:middle"> ★ Циничный словарь ★<br><br>
<? $slider_config=array(
	'slider_width'=>'100%',
	'slider_height'=>'500px',
	'some_style'=>'.demo-2 .sl-slider blockquote cite{
				font-family: "ProximaNova Black"; 
				
				}
			   .demo-2 .sl-slider h2 {font-family: "ProximaNova Reg";
			  /* text-shadow: 0 1px 0 #ccc,
			   0 2px 0 #c9c9c9,
				0 3px 0 #bbb,
				0 4px 0 #b9b9b9,
				0 5px 0 #aaa,
				   0 6px 1px rgba(0,0,0,.1),
				   0 0 5px rgba(0,0,0,.1),
				   0 1px 3px rgba(0,0,0,.3),
				   0 3px 5px rgba(0,0,0,.2),
				   0 5px 10px rgba(0,0,0,.25),
				   0 10px 10px rgba(0,0,0,.2),
				   0 20px 20px rgba(0,0,0,.15);*/
			   
			   }
			   .demo-2 .sl-slider blockquote p{color:white;padding:5px 0px 5px 10px;}
			   .demo-2 .sl-slider blockquote p span{color:white;padding:10px;}'
);
$cinmessages_data_q=mysql_query("select * from `cindict-cinmessages` m,`cindict-photos` p where m.`picture_id`=p.`photo_id` order by `id` desc");


//$fgf=0;
while($cinmessages_data=mysql_fetch_array($cinmessages_data_q)){

	if (!$cinmessages_data['photo_path']){$cinmessages_data['photo_path']="/project/cindict/files/Alien_Xpress_by_nmsmith.jpg";}
	$text_color=explode(";",$cinmessages_data['text_color']);
	$cin_message_text="<h2 style='color:".$text_color[0].";'>".$cinmessages_data['word']."</h2>
	<blockquote>";
	if(mb_strlen($cinmessages_data['text'])<57){
		$cin_message_text.="<p><span style='color:".$text_color[1].";background-color:".$text_color[2].";'>".$cinmessages_data['text']."</span></p>";
	} else {$cin_message_text.="<p style='color:".$text_color[1].";background-color:".$text_color[2].";'>".$cinmessages_data['text']."</p>";
	}
	$cin_message_text.="<cite>Циничный словарь</cite>
	</blockquote>";
	$pics_array[$cinmessages_data['photo_path']]=$cin_message_text;
}
//var_export($pics_array);

insert_module("FullscreenSlitSlider",$pics_array,$slider_config);?>
