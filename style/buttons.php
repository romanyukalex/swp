<? $log->LogInfo("Got ".(__FILE__)); ?>
<? # Красивые кнопки на CSS
/*
Вызывать их так:
 <div id="light">   
       <ul>
        <li><a class="super button pink">Pink Button</a>
        <a class="large button green">Green Button</a></li>

       <li> <a class="large button blue">Blue Button</a>
        <a class="large button red">Red Button</a></li>
        <li><a class="large button orange">Orange Button</a>
        <a class="large button yellow">Yellow Button</a></li>
        </ul>
 </div>
*/
?>
.button, .button:visited {
background: #222 url(overlay.png) repeat-x; 
display: inline-block; 
padding: 5px 10px 6px; 
color: #fff; 
text-decoration: none;
-moz-border-radius: 6px; 
-webkit-border-radius: 6px;
-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
border-bottom: 1px solid rgba(0,0,0,0.25);
position: relative;
cursor: pointer
}

.button:hover{ background-color: #111; color: #fff; }
.button:active{ top: 1px; }
.small.button, .small.button:visited{ font-size: 11px}
.button, .button:visited,
.medium.button, .medium.button:visited { font-size: 13px; 
font-weight: bold; 
line-height: 1; 
text-shadow: 0 -1px 1px rgba(0,0,0,0.25); 
}
.large.button, .large.button:visited{font-size: 14px; padding: 8px 14px 9px; }

.super.button, .super.button:visited {font-size: 34px;padding: 8px 14px 9px; }

.pink.button, .magenta.button:visited {background-color: #e22092; }
.pink.button:hover { background-color: #c81e82; }
.green.button, .green.button:visited { background-color: #91bd09; }
.green.button:hover { background-color: #749a02; }
.red.button, .red.button:visited 	{ background-color: #e62727; }
.red.button:hover { background-color: #cf2525; }
.orange.button, .orange.button:visited { background-color: #ff5c00; }
.orange.button:hover { background-color: #d45500; }
.blue.button, .blue.button:visited     { background-color: #2981e4; }
.blue.button:hover { background-color: #2575cf; }
.yellow.button, .yellow.button:visited { background-color: #ffb515; }
.yellow.button:hover { background-color: #fc9200; }




<? # Эти же кнопки, но с уникальными именами

// <a class="super swp_button pink">Pink Button</a> ?>

.swp_button, .swp_button:visited {
background: #222 url(overlay.png) repeat-x; 
display: inline-block; 
padding: 5px 10px 6px; 
color: #fff; 
text-decoration: none;
-moz-border-radius: 6px; 
-webkit-border-radius: 6px;
-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
border-bottom: 1px solid rgba(0,0,0,0.25);
position: relative;
cursor: pointer
}

.swp_button:hover{ background-color: #111; color: #fff; }
.swp_button:active{ top: 1px; }
.small.swp_button, .small.swp_button:visited{ font-size: 11px}
.swp_button, .swp_button:visited,
.medium.swp_button, .medium.swp_button:visited { font-size: 13px; 
font-weight: bold; 
line-height: 1; 
text-shadow: 0 -1px 1px rgba(0,0,0,0.25); 
}
.large.swp_button, .large.swp_button:visited{font-size: 14px; padding: 8px 14px 9px; }

.super.swp_button, .super.swp_button:visited {font-size: 34px;padding: 8px 14px 9px; }

.pink.swp_button, .magenta.swp_button:visited {background-color: #e22092; }
.pink.swp_button:hover { background-color: #c81e82; }
.green.swp_button, .green.swp_button:visited { background-color: #91bd09; }
.green.swp_button:hover { background-color: #749a02; }
.red.swp_button, .red.swp_button:visited 	{ background-color: #e62727; }
.red.swp_button:hover { background-color: #cf2525; }
.orange.swp_button, .orange.swp_button:visited { background-color: #ff5c00; }
.orange.swp_button:hover { background-color: #d45500; }
.blue.swp_button, .blue.swp_button:visited     { background-color: #2981e4; }
.blue.swp_button:hover { background-color: #2575cf; }
.yellow.swp_button, .yellow.swp_button:visited { background-color: #ffb515; }
.yellow.swp_button:hover { background-color: #fc9200; }