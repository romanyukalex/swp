/* swpshop
-- version 2.0
*/
function check_order_status(order_id){
		ajax_rq ("swpshop","check_order_status","order_status_"+order_id,"order_ap_"+order_id,order_id);
	}
}));
/* Обновление счетчика "В корзине сейчас N товаров "*/
function renew_shoppingcart_count(order_id){
	obj=document.getElementById('shoppingcart_count');
	obj.style.display='inline';
	ajax_rq ("swpshop","order_count_items","shoppingcartItemCount_ap","order_ap_nok_ap",order_id);
	ajax_rq ("swpshop","order_count_summ","shoppingcartItemCount_ap","order_ap_nok_ap",order_id);
	
	$('#shoppingcart_count').fadeIn(2000);
}