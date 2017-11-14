;(function($){
	$.fn.ajaxremoveproduct = function(id){
		$.ajax({
            url: 'index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id='+id,
            type: 'post',
            beforeSend: function(){
                jQuery('a[data-productid='+id+']').closest('.vmcontainer').addClass('removing');
            },
            success: function (response) {
                jQuery("#vmCartModule").updateVirtueMartCartModule();
            }
        });
	}
})(jQuery);