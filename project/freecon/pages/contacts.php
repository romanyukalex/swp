<div style="padding:20px 0 20px 0;">

<!-- About -->
    
	<div class="row">
       <div class="col-md-12" itemscope itemtype="https://schema.org/Organization"> 
		   <span itemprop="name">Клуб Здорового Сознания</span>
		   <br>
		   
		   <i class="fas fa-at"></i>&nbsp;&nbsp;
			
			<?insert_function("email_encode");
			echo email_encode("$officialemail","$officialemail", 'itemprop="email" class="header__phone fancybox-popup_callback justlink"' );?>
			<br>
			
			
				<i class="fas fa-mobile-alt"></i>
				<span>&nbsp;<a class="justlink" href="tel:<?=$contactphone?>" itemprop="telephone"><?=$contactphone?></a></span>
			<br>
			<i class="fab fa-wpforms"></i>&nbsp;&nbsp;<a href="" class="justlink" data-toggle="modal" data-target="#request_form_modal">Форма обратной связи на сайте</a><br>
			<i class="fab fab fa-vk"></i>&nbsp;&nbsp;<a href="" class="justlink" data-toggle="modal" data-target="#vk_request_modal">Форма обратной связи через VK</a>
		</div>
	
		
	</div>

<div class="row">
	<div class="col-md-12">
		<i class="fas fa-map-marker-alt"></i>
		 
		<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
			<span itemprop="postalCode">125009</span>
			<span itemprop="streetAddress">Средний Кисловский пер., 5/6, к.3</span>
			<span itemprop="addressLocality" class="hidden" >Москва</span>
			<span itemprop="addressRegion">Москва</span><br>
			<i class="far fa-window-maximize"></i> <a href="https://soznanie.club" class="justlink" itemprop="url">https://soznanie.club</a>
		</div>
		
		<img itemprop="logo" class="hidden" src="<?=$logofile?> логотип" alt="Клуб здорового сознания логотип">		
</div>

</div>		


</div>

<div class="modal fade" id="request_form_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Форма обратной связи</h4></span>
      </div>
      <div class="modal-body">
	 <? insert_module("contact_form");?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vk_request_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:360px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Обратиться через VK</h4></span>
      </div>
      <div class="modal-body">
		 
		 <? insert_module("vk-api","show_group_widget");?>
		
      </div>
    </div>
  </div>
</div>
