var Technoserv = {

	isIE6: false,

	initialize: function() {
		if ( $.browser.msie && '6.0' == $.browser.version ) {
			this.isIE6 = true;
			jQuery.fx.off = true;
		}


		this.Banners.initialize();

		this.HoverFix.initialize();
		this.TopMenu.initialize();
		this.PNGFix.initialize();
		this.Placeholders.initialize();
		this.LangSelect.initialize();
		this.FastNews.initialize();
		this.Desaturate.initialize();
		this.IndexServices.initialize();
		this.Footer.initialize();
		this.InnerSlider.initialize();
		this.SidebarMenu.initialize();

		this.Window.initialize();

		$("form.jqtransform").jqTransform();

		$('.b-window form').validator({
			messageClass: 'form-error',
			onSuccess: function(e, b) {
				$(b).parent().removeClass('error-field-textarea');
				$(b).parent().removeClass('error-field');
			},
			onFail: function(e, b) {
				var w = $(b[0].input).closest('.b-window');
				var form = w.find('input[type="image"]').attr('src', '/img/buttons/send_error.png');
				w.addClass('b-window_with-errors');
				jQuery.each(b, function(index, el){
					if ( 'TEXTAREA' == $(el.input).attr('tagName') ) {
						$(el.input).parent().addClass('error-field-textarea');
					} else $(el.input).parent().addClass('error-field');
				});


			}
		});

		if ( $('#type-select').length ) {

			var list = [];
			$('#type-select .switch').each(function(index, el){
				if ( $(el).hasClass('switch_active'))
					list.push(index);
			});
			$('#type-request').val(list.join(','));

			$('#type-select .switch').click(function(e){
				var target = $(e.target);
				target.toggleClass('switch_active');
				list = [];
				$('#type-select .switch').each(function(index, el){
					if ( $(el).hasClass('switch_active'))
					list.push($(el).attr('value'));
				});
				$('#type-request').val(list.join(','));
			})
		}
	},

	Form: {

		submit: function(window) {
			var form = $(window).find('form');
			$(form).validator();

		}

	},

	Banners: {

		initialize: function() {
			Technoserv.IndexSlider.flash = 0 != window.flashembed.getVersion()[0] && '#js-banners' != document.location.hash;
			var frames = $('#banners .frame');
			frames.each(function(index, frame){
				$(frame).data('index', index);
			});
			if ( Technoserv.IndexSlider.flash ) {
				if ( frames.length ) {
					frames.each(function(index, frame){
						var flash = $(frame).attr('flash');
						if ( !flash ) {
							$(frame).remove();
						} else {
							$(frame).empty();
							$(frame).css('background-image', 'none');
							$(frame).flashembed({
								src: flash,
								wmode: 'opaque'
							});
						}
					});
				}
			}
			$('#banners').css('visibility', 'visible');
			Technoserv.IndexSlider.initialize();
		}

	},

	SidebarMenu: {

		last: null,

		initialize: function() {
			$('.js-sidebar-menu').click($.proxy(this.onClick, this));

			if ( $('.js-sidebar-menu li.open:first').length ) {
				this.last =  $('.js-sidebar-menu li.open:first');
				this.last.find('.submenu').css('display', 'block');
			}

		},

		onClick: function(e) {
			var target = $(e.target);
			var submenu = target.next('.submenu:first');
			if ( submenu.length ) {
				var item = target.parent('li');
				if ( !item.hasClass('open') ) {
					if ( this.last ) {
						this.last.removeClass('open');
						this.last.find('.submenu:first').slideUp();
					}
				}
				if ( item.hasClass('open') ) {
					submenu.stop().slideUp();
				} else {
					submenu.stop().hide();
					submenu.slideDown();
				}
				item.toggleClass('open');
				this.last = target.parent('li');

				return(false);
			} else return(true);
		}

	},

	Window: {

		initialize: function() {
			var mask = {

				color: 'black',
				loadSpeed: 200,
				opacity: 0.6
			};
			if ( jQuery.browser.msie && jQuery.browser.version < '8.0' ) {
				mask = false;
			}
			$('.js-relative-window').overlay({
				left: 735,
				top: 400,
				mask: mask,
				closeOnClick: true,
				closeOnEsc: true,
				fixed: false
			});

			$('.js-window').overlay({
				mask: mask,
				closeOnClick: true,
				closeOnEsc: true,
				fixed: !Technoserv.isIE6
			});


		}

	},

	InnerSlider: {

		years: [],
		force: false,

		initialize: function() {
			this.slider = $('.js-inner-slider:first');
			if (this.slider.length ) {

				this.body = $('#inner-slider-control');

				this.items = this.slider.find('.item');

				this.items.each($.proxy(function(index, el){
					this.years.push($(el).attr('title'))
				}, this));

				this.drawYears();

				this.slider.scrollable({
					circular: true,
					onSeek: $.proxy(function(){
						if ( !this.force ) {
							this.body.slider('option', 'value', this.slider.data('scrollable').getIndex());
							this.activate(this.slider.data('scrollable').getIndex());
						}
						this.force = false;
					}, this)
				});

				var item = $('.vtab-content_active:first');
				if( item.length ) {
					item = item.index();
					this.labels = this.body.find('span');
					this.labels.removeClass('label_active');
					this.labels.eq(item).addClass('label_active');
				} else item = 0;

				this.body.slider({
					min: 0,
					max: this.years.length - 1,
					value: item,
					slide: $.proxy(function(e, ui) {
						this.slider.data('scrollable').seekTo(ui.value);
						this.force = true;
						this.activate(ui.value);
					}, this)
				});

			}
		},

		activate: function(index) {
			this.labels.removeClass('label_active');
			this.labels.eq(index).addClass('label_active');

			var host = $('.js-vtabs:first');
			var block = host.find('.tab-content_active');
			if ( !block.length ) {
				block = host;
			}
			var items = block.find('.vtab-content');
			items.removeClass('vtab-content_active');
			items.eq(index).addClass('vtab-content_active');
		},

		drawYears: function() {
			var width = this.body.width()/(this.years.length - 1);
			jQuery.each(this.years, $.proxy(function(index, value){
				var left = 	width * index;
				var span = jQuery('<span/>',{
					className: 'label',
					text: value
				});
				this.body.append(span);
				span.css('left', left - span.width()/2 +10);
			}, this));
			this.labels = this.body.find('span');
			this.labels.eq(0).addClass('label_active');
		}
	},

	IndexSlider: {

		current: null,
		time: 7000,
		navigationHideTimer: null,
		speed: 800,
		isBubbleOpen: false,
		startTouch: false,

		initialize: function() {
			this.host = $('#index-slider');
			if ( this.host.length ) {
				this.holder = this.host.find('.frames');
				this.frames = this.host.find('.frame');
				this.firstFrame = this.frames.eq(0);
				this.itemSize = this.firstFrame.width() + parseInt(this.firstFrame.css('marginRight'));
				this.holder.width(this.itemSize * this.frames.length);
				this.slider = this.host.find('.slider .body');

				this.navigation = this.host.find('.arrow');

				this.navigation.hide();

				this.navigation.hover($.proxy(function(){
					if ( this.navigationHideTimer ) clearTimeout(this.navigationHideTimer);
				}, this), $.proxy(function(){
					if ( this.navigationHideTimer ) clearTimeout(this.navigationHideTimer);
					this.navigationHideTimer = setTimeout($.proxy(this.hideNavigation, this), 500);
				}, this));

				this.holder.hover($.proxy(function(){
					if ( this.navigationHideTimer ) clearTimeout(this.navigationHideTimer); else {
						this.navigation.eq(0).show('drop', { direction: 'left' });
						this.navigation.eq(1).show('drop', { direction: 'right' });
					}
				}, this), $.proxy(function(){
					if ( this.navigationHideTimer ) clearTimeout(this.navigationHideTimer);
					this.navigationHideTimer = setTimeout($.proxy(this.hideNavigation, this), 2000);
				}, this));

				this.current = this.frames.eq(0);

				this.holder.hover($.proxy(function(){
					if ( this.autorotateTimer ) clearTimeout(this.autorotateTimer);
				}, this), $.proxy(function(){
					this.autorotate();
				}, this));

				if ( this.frames.length > 1 ) {
					this.slider.slider({
						min: 1,
						max: this.itemSize * this.frames.length - 1,
						step: 1,
						animate: true,
						slide: $.proxy(this.slide, this)
					});

					this.autorotate();
				}

				if ( !this.flash ) {

					$('#filials-map .point').click($.proxy(function(e){
						var target = $(e.target);
						var id = target.attr('id').split('-')[1];
						this.showBubble(id);
					}, this));

					$('#filials-map .city-list').hide();

					$('#filials-map .transparent').css('opacity', .8);
					$('#filials-map li.item').hover($.proxy(function(e){
						var target = $(e.target);
						$(target).animate({
							marginLeft: 5
						}, 100).addClass('item_hover');
					}, this), $.proxy(function(e){
						var target = $(e.target);
						$(target).animate({
							marginLeft: 0
						}, 100).removeClass('item_hover');
					}, this)).click($.proxy(function(e){
						var id = $(e.target).attr('id').split('-')[1];
						this.showBubble(id);
					}, this));

					this.animate();
				}

			}
		},

		showBubble: function(id) {
			if ( this.bubbleTimeout ) clearTimeout(this.bubbleTimeout);
			var target = $('#point-'+id);
			var position = target.position();
			var left = position.left > 480 ? position.left - 218 : position.left - 28 ;
			if ( position.left > 480 ) {
				$('#banner-bubble').css('background-position', 'left bottom');
			} else {
				$('#banner-bubble').css('background-position', 'left top');
			}
			$('#banner-bubble').css({
				left: left,
				top: position.top - $('#banner-bubble').height()
			});
			$('#banner-bubble').fadeIn();

			$('#banner-bubble .content').html(target.attr('text'));
			this.isBubbleOpen = true;
		},

		hideBubble: function(force) {
			if ( this.bubbleTimeout ) clearTimeout(this.bubbleTimeout);
			if ( force ) {
				$('#banner-bubble').fadeOut()
			} else {
				this.bubbleTimeout = setTimeout(function(){
					$('#banner-bubble').fadeOut();
				}, 2000);
			}
		},

		hideNavigation: function() {
			this.navigation.eq(0).hide('drop', { direction: 'left' });
			this.navigation.eq(1).hide('drop', { direction: 'right' });
			this.navigationHideTimer = null;
		},

		autorotate: function() {
			if ( this.autorotateTimer ) clearTimeout(this.autorotateTimer);
			this.autorotateTimer = setInterval($.proxy(function(){
				this.next();
			}, this), this.time);
		},

		flag: false,

		next: function() {
			var index = this.current.index() - 1;
			this.current = this.current.next();
			if ( !this.current.length ) {
				this.flag = true;
				for (var i =0;i!=this.frames.length-1;i++) {
					this.frames.eq(i).appendTo(this.holder);
				}
				this.holder.css({
					marginLeft: 0
				});
				this.frames = this.host.find('.frame');
				this.current = this.frames.eq(1);
			}
			index = this.current.index();
			this.slide(null, { value: index * this.itemSize }, true);
			this.slider.slider('option', 'value', this.current.data('index') * this.itemSize);
		},

		prev: function() {
			this.current = this.current.prev();
			if ( !this.current.length ) {
				this.frames.eq(this.frames.length-1).prependTo(this.holder);
				this.holder.stop(false, false).css({
					marginLeft:  -1 * this.itemSize
				});
				this.frames = this.host.find('.frame');
				this.current = this.frames.eq(0);
			}
			var index = this.current.index();
			this.slide(null, { value: index * this.itemSize }, true);
			this.slider.slider('option', 'value', this.current.data('index') * this.itemSize);
		},

		animate: function() {
			if ( this.flash ) return;
			var text = this.current.find('.text-01');
			text.css({
				opacity: 0,
				display: 'block',
				marginLeft: 200

			});
			text.animate({
				opacity: 1,
				marginLeft: 40
			}, 1300, 'easeOutExpo');

			text = this.current.find('.text-02');
			text.css({
				opacity: 0,
				display: 'block',
				marginLeft: 200

			});
			setTimeout(function(){
				text.animate({
					opacity: 1,
					marginLeft: 40
				}, 900, 'easeOutExpo');
			}, 200)

			var index = $('#filials-map').index();

			if ( index == this.current.index()) {
				this.current.find('.point').each(function(index, el){
					setTimeout(function(){
						$(el).show('drop', { direction: 'up'});
					}, index*50);
				});

				$('#filials-map .city-list').show('drop', { direction: 'right' })
			}

			if ( this.current.hasClass('b-chess') ) {
				this.current.find('.block').show('drop', { direction: 'right' });
			}


		},

		slide:function(e, ui, force, direction) {
			this.autorotate();
			var current = Math.floor(ui.value/this.itemSize);
			if (current != this.current.index() || force) {
				if ( !this.flash ) {
					this.holder.find('.text-01, .text-02').hide();
					this.current.find('.point').hide();
					$('#filials-map .city-list').hide();
					$('#chess').find('.block').hide();
				}
				this.holder.stop(false, false).animate({
					marginLeft: -1 * current * this.itemSize
				}, this.speed, 'easeOutQuint', $.proxy(function(){
					this.animate();
					this.autorotate();
					if ( this.flag ) {
						this.frames = this.host.find('.frame');
						this.holder.css('marginLeft', 0);
						var a = this.frames.eq(0).detach();
						a.appendTo(this.holder);
						this.frames = this.host.find('.frame');
						this.flag = false;
					}

				}, this));
				this.current = this.frames.eq(current);
			}
		}

	},

	IndexServices: {

		current: null,
		speed: 1000,
		time: 10000,
		controlsTimer: null,
		timer: null,
		isControlActive: false,

		initialize: function() {
			this.mainHolder = $('#index-services');
			if ( this.mainHolder.length ) {
				this.holder = this.mainHolder.find('.frames');
				this.controls = this.mainHolder.find('.control');
				this.controls.hide();
				this.items = this.mainHolder.find('.frame');
				this.itemSize = this.items.eq(0).width();
				this.holder.width(this.itemSize * this.items.length);
				this.current = this.items.eq(0);
				this.autorotate();

				this.holder.hover($.proxy(function(){
					if ( this.controlsTimer ) clearTimeout(this.controlsTimer);
					if ( !this.isControlActive ) {
						this.controls.eq(0).show('drop', { direction: 'right' });
						this.controls.eq(1).show('drop', { direction: 'left' });
						this.isControlActive = true;
					}
				}, this), $.proxy(function(){
					this.controlsTimer = setTimeout($.proxy(function(){
						this.controls.eq(0).hide('drop', { direction: 'right' });
						this.controls.eq(1).hide('drop', { direction: 'left' });
						this.isControlActive = false;
					}, this), 1000);
				}, this));

				this.controls.hover($.proxy(function(){
					if ( this.controlsTimer ) clearTimeout(this.controlsTimer);
					this.isControlActive = true;
				}, this), $.proxy(function(){
					this.controlsTimer = setTimeout($.proxy(function(){
						this.controls.eq(0).hide('drop', { direction: 'right' });
						this.controls.eq(1).hide('drop', { direction: 'left' });
						this.isControlActive = false;
					}, this), 1000);
				}, this));

				this.holder.hover($.proxy(function(){
					if ( this.timer ) clearTimeout(this.timer);
				}, this), $.proxy(function(){
					this.autorotate();
				}, this));


			}

		},

		autorotate: function() {
			if ( this.timer ) clearInterval(this.timer);
			this.timer = setInterval($.proxy(this.next, this), this.time);
		},

		next: function() {
			var index = this.current.index() - 1;
			this.current = this.current.next();
			if ( this.current.index() + 3 > this.items.length ) {
				this.items.eq(0).appendTo(this.holder);
				this.items = this.mainHolder.find('.frame');
				this.holder.stop(false, false).css({
					marginLeft:  -1 * index * this.itemSize
				});
			}
			this.set();
		},

		prev: function() {
			this.current = this.current.prev();
			if ( !this.current.length ) {
				this.items.eq(this.items.length-1).prependTo(this.holder);
				this.holder.stop(false, false).css({
					marginLeft:  -1 * this.itemSize
				});
				this.items = this.mainHolder.find('.frame');
				this.current = this.items.eq(0);
			}
			this.set();
		},

		set: function(isBack) {
			var index = this.current.index();
			this.holder.animate({
				marginLeft: -1 * index  * this.itemSize
			}, this.speed);
			this.autorotate();
		}

	},

	Desaturate: {

		initialize: function() {
			this.img = $('.js-desaturate');
			if ( this.img.length ) {
				this.img.desaturate();
			}
		}

	},

	TopMenu: {

		initialize: function() {
			$('#top-menu .item').hover(function(){
				$(this).addClass('hover');
				var submenu = $(this).find('.submenu');
				submenu.width(submenu.hasClass('no-margin') ? $(this).width() : $(this).width() - 2);
				$('#top-menu').find('.submenu').stop(true, true).hide();
				submenu.show('fade');
			}, function(){
				$(this).removeClass('hover');
				$(this).find('.submenu').hide();
			});
		}

	},

	PNGFix: {

		initialize: function() {
			if ( Technoserv.isIE6 ) DD_belatedPNG.fix('.png');
		}

	},

	HoverFix: {

		initialize: function() {
			if ( Technoserv.isIE6 ) {
				$('.hover-fix').hover(function(){
					$(this).addClass('hover');
				}, function(){
					$(this).removeClass('hover');
				});
				$('.switch').hover(function(){
					$(this).addClass('switch_hover');
				}, function(){
					$(this).removeClass('switch_hover');
				});
			}
		}

	},

	LangSelect: {

		initialize: function() {
			$('#lang-select').hover($.proxy(this.toggle, this), $.proxy(this.toggle, this));
		},

		toggle: function() {
			$('#lang-select li').slice(1).toggleClass('hidden');
		}

	},

	Placeholders: {

		initialize: function() {
			var items = $('.js-placeholder[title]');
			$(items).each($.proxy(function(index, item){
				if ( $(item).attr('title') ) {
					$(item).val($(item).attr('title'));
					$(item).addClass('placeholder');

					$(item).focus($.proxy(this.onFocus, this));
					$(item).blur($.proxy(this.onBlur, this));
				}
			}, this));

		},

		onFocus: function(e) {
			var target = $(e.target);
			if ( target.val() == target.attr('title') ) {
				target.val('');
				target.removeClass('placeholder');
			}
		},

		onBlur: function(e) {
			var target = $(e.target);
			if ( !target.val() ) {
				target.val(target.attr('title'));
				target.addClass('placeholder');
			}
		}

	},

	Footer: {

		state: true,
		title: ['<?=GetMessage("pokaz")?>', '<?=GetMessage("pokaznet")?>'],

		initialize: function() {
			$('#footer').height($('#footer').height());
			this.updateTitle();
			if (  0 == jQuery.cookie('footerState') ) {
				$('#footer').hide();
//				this.toggle(true);
				this.state = false;
			}
		},

		toggle: function(set) {
			this.timer = setInterval($.proxy(function(){
				$(window).scrollTop($(document).height() - $(window).height());
			}, this), 5);
			$('#footer').slideToggle($.proxy(function(){
				clearInterval(this.timer);
			}, this));
			if ( !set ) {
				this.state = !this.state;
				jQuery.cookie('footerState', this.state * 1);
			}
			this.updateTitle();
		},

		updateTitle: function() {
			$('#footer-toggler').html('<span>'+(this.title[this.state*1])+'</span>');
		}

	},

	FastNews: {

		current: null,
		time: 6000,
		speed: 800,
		timer: null,
		inProcess: false,

		initialize: function() {
			if ( $('#fast-news').length ) {
				this.holder = $('#fast-news');
				this.news = this.holder.find('.frame');
				this.itemSize = this.news.eq(0).width();
				this.holder.width(this.itemSize * this.news.length);
				this.navigation = $('.b-fast-news .arrow');
				this.navigation.eq(0).css('opacity', .5);
				this.current = this.news.eq(0);
				this.autorotate();
			}
		},

		autorotate: function() {
			if ( this.timer ) clearInterval(this.timer);
			this.timer = setInterval($.proxy(this.next, this), this.time);
		},

		next: function() {
			this.navigation.css('opacity', 1);
			if ( !this.current.next().next().length ) this.navigation.eq(1).css('opacity', .5);

			if ( this.current.next().length ) {
				this.current = this.current.next();
			}
			this.set();
		},

		prev: function() {
			this.navigation.css('opacity', 1);
			var backup = this.current;
			if ( !this.current.prev().prev().length ) this.navigation.eq(0).css('opacity', .5);
			if ( this.current.prev().length ) {
				this.current = this.current.prev();
			}
			this.set();
		},

		set: function() {
			if ( !this.inProcess ) {
				var index = this.current.index();

				this.current.prev().fadeOut(this.speed);
				this.current.next().fadeOut(this.speed);

				this.inProcess = true;
				this.holder.animate({
					marginLeft: -1 * index * this.itemSize
				}, this.speed, $.proxy(function(){
					this.inProcess = false;
					this.news.show();
				}, this));
				this.autorotate();
			}
		}

	}

};

jQuery($.proxy(Technoserv.initialize, Technoserv));