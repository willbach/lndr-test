<?php // no direct access

defined('_JEXEC') or die('Restricted access');

$app    = JFactory::getApplication(); 
$template = $app->getTemplate();


vmJsApi::addJScript("/templates/".$template."/html/mod_virtuemart_cart/js/update_cart.js",false,false);
vmJsApi::addJScript("/templates/".$template."/html/mod_virtuemart_cart/js/ajaxremoveproduct.js",false,false);

if (false && $data->dataValidated == true) {
	$taskRoute = '&task=confirm';
	$linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
} else {
	$taskRoute = '';
	$linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
}
$useSSL = VmConfig::get('useSSL',0);
$useXHTML = true;
$data->cart_show = '<a class="btn" href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';

// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" 

?>
<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?> vmCartModule_<?php echo $module->id; ?>" id="vmCartModule">
<?php 
preg_match('|<strong>(.*)</strong>|', $data->billTotal, $match);
if(!empty($match)) $data->billTotal = $match[1]; ?>
<div class="total_products"><a class="<?php if(!count($data->products)) echo ' disabled'; ?>" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>" rel="nofollow"><i class="material-design-shopping232"><?php echo $data->totalProduct; ?></i></a></div>
<?php if ($show_product_list){ ?>
	<div id="hiddencontainer" style=" display: none; ">
		<div class="vmcontainer">
			<div class="removing_title"><?php echo Jtext::_('TPL_REMOVING') ?></div>
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>
				<div class="remove_product"><a href="#" data-productid="" title="<?php echo Jtext::_('TPL_REMOVE_PRODUCT') ?>" class="remove"><i class="fa fa-times-circle"></i></a></div>
				<div class="subtotal_with_tax"></div>
			</div>
		</div>
	</div>
	<div id="vm_cart_products"<?php if(!count($data->products)) echo ' class="empty"'; ?>>
	<div class="cart_title"><?php echo Jtext::_('TPL_CART_TITLE') ?></div>
	<div class="vm_cart_products">
		<?php foreach ($data->products as $key => $product){ ?>
		<div class="vmcontainer">
		<div class="removing_title"><?php echo Jtext::_('TPL_REMOVING') ?></div>
		<div class="product_row">
				<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo $product['product_name'] ?></span>
				<div class="remove_product"><a href="#" data-productid="<?php echo $key; ?>" title="<?php echo Jtext::_('TPL_REMOVE_PRODUCT') ?>" class="remove"><i class="fa fa-times-circle"></i></a></div>
				  <div class="subtotal_with_tax" style="float: right;"><?php echo $product['subtotal_with_tax'] ?></div>
			</div>
		</div>
		<?php } ?>
	</div>
		<div class="total">
			<?php if ($data->totalProduct and $show_price) { ?>
			<?php echo $data->billTotal; ?>
			<?php } ?>
		</div>
		<div class="show_cart">
			<?php if ($data->totalProduct) echo  $data->cart_show; ?>
		</div>
		<div style="clear:both;"></div>
		<noscript>
		<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
		</noscript>
		</div>
	</div>
<?php } ?>
<script>
	jQuery(function(){
		if(jQuery('body').hasClass('mobile')){
			jQuery('.vmCartModule_<?php echo $module->id; ?> .total_products a').on('click',function(){
				jQuery('.vmCartModule_<?php echo $module->id; ?> #vm_cart_products').stop().toggleClass('shown');
				return false;
			})
			jQuery('.vm-customfield-mod .product-field-type-C span').each(function(){
				jQuery(this).text(jQuery(this).text().split('/')[0]);
			})
			jQuery('.remove').tooltip()
		}
		else{
			jQuery('.vmCartModule_<?php echo $module->id; ?>').hover(function(){
				jQuery('.vmCartModule_<?php echo $module->id; ?> #vm_cart_products').stop().addClass('shown')
			},function(){
				jQuery('.vmCartModule_<?php echo $module->id; ?> #vm_cart_products').stop().delay(1000)
	                .queue(function(n){
	                    jQuery(this)
	                    .removeClass('shown')
	                    n();
	                });
			})
		}
		jQuery('.vmCartModule_<?php echo $module->id; ?> .remove_product a').live('click', function(){
			id = jQuery(this).attr('data-productid');
			jQuery('.remove').tooltip('destroy')
			jQuery(this).ajaxremoveproduct(id);
			return false;
		})
		jQuery('.vm-customfield-mod .product-field-type-C span').each(function(){
			jQuery(this).text(jQuery(this).text().split('/')[0]);
		})
		jQuery('.remove').tooltip()
	})
</script>