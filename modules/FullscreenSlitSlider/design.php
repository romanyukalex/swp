<?php
 /*******************************************************************
  * Snippet Name : module template           					 	*
  * Scripted By  : RomanyukAlex		           					 	*
  * Website      : http://popwebstudio.ru	   					 	*
  * Email        : admin@popwebstudio.ru     					 	*
  * License      : GPL (General Public License)					 	*
  * Purpose 	 : some functions								 	*
  * Access		 : include this script, insert_module("modulename")	*
  ******************************************************************/
  /*
  $pics_array=array("/modules/FullscreenSlitSlider/images/1.jpg"=>'<h2>A bene placito.</h2>
	<blockquote><p>You have just dined/</p><cite>Ralph Waldo Emerson</cite></blockquote>',
	"/modules/FullscreenSlitSlider/images/2.jpg"=>'<h2>Regula aurea.</h2>
	<blockquote><p>Until he extends</p><cite>Albert Schweitzer</cite></blockquote>');*/

$log->LogInfo(basename (__FILE__)." | Got ".(__FILE__));
if ($nitka=="1"){
    $slider_config=$param[2];
	$pics_array=$param[1];?>
		<link rel="stylesheet" type="text/css" href="/modules/FullscreenSlitSlider/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="/modules/FullscreenSlitSlider/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/modules/FullscreenSlitSlider/css/custom.css" />
		<style>
		

		
		<? for ($hf=1;$hf<count($pics_array);$hf++){?>
		/* <?=$hf?> Slide */
.demo-1 .bg-<?=$hf?> .sl-slide-inner,
.demo-1 .bg-<?=$hf?> .sl-content-slice {
	background: #ffeb41;
}

.demo-1 .bg-<?=$hf?> .deco {
	border-color: #ECD82C;
}

.demo-1 .bg-<?=$hf?> .deco:after {
	color: #000;
	text-shadow: 0 0 1px #000;
}

.demo-1 .bg-<?=$hf?> h2,
.demo-1 .bg-<?=$hf?> blockquote{
	color: #000;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}

.demo-1 .bg-<?=$hf?> blockquote:before {
	color: #ecd82c;
}
		<?}?>
		
		.demo-2 .sl-slider-wrapper {
			width: <?=$slider_config['slider_width']?>;
			height: <?=$slider_config['slider_height']?>;
		}
		
		<?=$slider_config['some_style']?>
		</style>
		<script type="text/javascript" src="/modules/FullscreenSlitSlider/js/modernizr.custom.79639.js"></script>
		<noscript>
			<link rel="stylesheet" type="text/css" href="/modules/FullscreenSlitSlider/css/styleNoJS.css" />
		</noscript>
  <div class="container demo-2">
		
			

      

            <div id="slider" class="sl-slider-wrapper">

				<div class="sl-slider">
				
				<? $dataslicescalearr=array("1","2","1.5");
				foreach($pics_array as $pic_path=>$pic_html){
				?>
				<div class="sl-slide" data-orientation="<?$orient=rand(0,1);if($orient==0){?>horizontal<?}else{?>vertical<?};?>" 
					data-slice1-rotation="<?$znak=rand(0,1);if($znak==0){?>-<?};echo rand(0,25)?>" data-slice2-rotation="<?$znak=rand(0,1);if($znak==0){?>-<?};echo rand(0,25)?>" data-slice1-scale="<?=array_rand($dataslicescalearr)?>" data-slice2-scale="<?=array_rand($dataslicescalearr)?>">
						<div class="sl-slide-inner">
							<div class="bg-img" style="background-image: url(<?=$pic_path?>);"></div>
							<?=$pic_html?>
						</div>
					</div>
			<?	}?>
				
				
				
				</div><!-- /sl-slider -->

				<nav id="nav-dots" class="nav-dots">
					<span class="nav-dot-current"></span>
					<? for($hf=1;$hf<count($pics_array);$hf++){?><span></span><?}?>
				</nav>

			</div><!-- /slider-wrapper -->

        </div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="/modules/FullscreenSlitSlider/js/jquery.ba-cond.min.js"></script>
		<script type="text/javascript" src="/modules/FullscreenSlitSlider/js/jquery.slitslider.js"></script>
		<script type="text/javascript">	
			$(function() {
			
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' ),
						$nav = $( '#nav-dots > span' ),
						slitslider = $( '#slider' ).slitslider( {
							onBeforeChange : function( slide, pos ) {

								$nav.removeClass( 'nav-dot-current' );
								$nav.eq( pos ).addClass( 'nav-dot-current' );

							}
						} ),

						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':last' ).on( 'click', function() {

								slitslider.next();
								return false;

							} );

							$navArrows.children( ':first' ).on( 'click', function() {
								
								slitslider.previous();
								return false;

							} );

							$nav.each( function( i ) {
							
								$( this ).on( 'click', function( event ) {
									
									var $dot = $( this );
									
									if( !slitslider.isActive() ) {

										$nav.removeClass( 'nav-dot-current' );
										$dot.addClass( 'nav-dot-current' );
									
									}
									
									slitslider.jump( i + 1 );
									return false;
								
								} );
								
							} );

						};

						return { init : init };

				})();

				Page.init();

				/**
				 * Notes: 
				 * 
				 * example how to add items:
				 */

				/*
				
				var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');
				
				// call the plugin's add method
				ss.add($items);

				*/
			
			});
		</script>

<? }?>