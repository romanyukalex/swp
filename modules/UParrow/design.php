<?php
 /****************************************************************
  * Snippet Name : UParrow				     					 * 
  * Scripted By  : RomanyukAlex		           					 * 
  * Website      : http://popwebstudio.ru	   					 * 
  * Email        : admin@popwebstudio.ru     					 * 
  * License      : GPL (General Public License)					 * 
  * Purpose 	 : JS link to get page' top						 *
  * Access		 : include									 	 *
  ***************************************************************/
 $log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){  
	?>
	<style>
	.gp{
	background: url(/modules/UParrow/Upload00.png) center center no-repeat;
	width: 20px;
	height: 20px;
	color: #fff;
	font-family: verdana;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	-o-border-radius: 5px;
	cursor: pointer;
	padding: 15px;
	margin: 20px;
	}
	</style>
	<!-- scroll page -->
	<!--<script type="text/javascript" src="jquery-2.js"></script> обычный jquery-->
	<script type="text/javascript">
	$(document).ready(function() {
		var t = $('<div class="gp"></div>'),
			d = $(document);
		$('body').append(t);
		
		t.css({
			opacity: 0,
			position: 'absolute',
			top: 0,
			right: '5%'
		});

		t.click(function() {
			$('html,body').animate({
				scrollTop: 0
			}, 1000);
		});

		$(window).scroll(function() {
			var sv = d.scrollTop();
			if (sv < 10) {
				t.fadeOut(200);
				return;
			}

			t.css('display', '').animate({
				top: sv,
				opacity: 0.8
			}, 500);
		});
	});
	</script>
<? } ?>