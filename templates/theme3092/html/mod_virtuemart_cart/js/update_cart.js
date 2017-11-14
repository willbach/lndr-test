;
(function (jQuery) {
    jQuery.fn.extend({
        updateVirtueMartCartModule : function (arg) {
            return this.each(function () {
                // Local Variables
                var $this = jQuery(this);
                jQuery.ajaxSetup({ cache: false });
                jQuery.getJSON(window.vmSiteurl + "index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json" + window.vmLang,
                    function (datas, textStatus) {
                        if(datas.billTotal.match(/<strong>(.*)<\/strong>/)[1]) datas.billTotal = datas.billTotal.match(/<strong>(.*)<\/strong>/)[1];
                        $this.find(".vm_cart_products").html("");
                        $this.find(".show_cart").html("");
                        $this.find(".total").html("");
                        if (datas.totalProduct > 0) {
                            i = 0;
                            $this.find("#vm_cart_products").removeClass('empty');
                            jQuery.each(datas.products, function (key, val) {
                                jQuery("#hiddencontainer .vmcontainer").clone().appendTo(".vmCartModule .vm_cart_products");
                                $this.find(".vmcontainer:last").find('.remove_product a').attr('data-productid', key);
                                jQuery.each(val, function (key, val) {
                                    if (jQuery("#hiddencontainer .vmcontainer ." + key)) $this.find(".vm_cart_products ." + key + ":last").html(val);
                                });
                                i++;
                            });
                            $this.find(".show_cart").html(datas.cart_show);
                            $this.find(".show_cart a").removeAttr('style').addClass('btn');
                            $this.find(".total").html(datas.billTotal);
                            $this.find(".total_products a").removeClass('disabled').find('i').html(datas.totalProduct);
                        }
                        else{
                            $this.find("#vm_cart_products").addClass('empty');
                            $this.find(".total_products a").addClass('disabled').find('i').html(datas.totalProduct);
                        }
                        jQuery('.remove').tooltip()
                    }
                );
            });
        }
    })
})(jQuery);