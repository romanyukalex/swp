$(document).ready(

	function() {
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
				t.clearQueue().fadeOut(200);
				return;
			}

			t.css('display', '').clearQueue().animate({
				top: sv,
				opacity: 0.8
			}, 500);
		});
	});