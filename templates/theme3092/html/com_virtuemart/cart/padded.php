<?php
/**
*
* Layout for the add to cart popup
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2013 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$doc = JFactory::getDocument();
 ?>
<div id="com_virtuemart">
	<div class="row-container">
		<div class="container-fluid">
		<?php if($this->products){
			foreach($this->products as $product){
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select($db->quoteName('file_url'))
				->from($db->quoteName('#__virtuemart_medias'))
				->where($db->quoteName('virtuemart_media_id') . ' = '. $db->quote($product->virtuemart_media_id[0]));
				$db->setQuery($query);
				$result = $db->loadResult();
				if($product->quantity>0){
					echo '<h4 class="heading-style-4">'.vmText::sprintf('TPL_PRODUCT_ADDED').'</h4>';
					echo '<div class="product_img"><img src="'.JURI::base(true).'/'.$result.'" alt=""></div>';
					echo '<h5 class="heading-style-5 vm_product_title">'.$product->quantity.' x '.$product->product_name.'</h5>';
				} else {
					if(!empty($product->errorMsg)){
						echo '<div>'.$product->errorMsg.'</div>';
					}
				}
			}
		} ?>
		<div class="clearfix"></div>
		<a class="btn close_facebox" href="#" ><?php if($doc->direction != 'rtl') { ?><i class="fa fa-chevron-left"></i> <?php } else { ?><i class="fa fa-chevron-right"></i> <?php } ?><?php echo vmText::_('COM_VIRTUEMART_CONTINUE_SHOPPING'); ?></a>
		<a class="btn fright" href="<?php echo $this->cart_link; ?>"><?php echo vmText::_('COM_VIRTUEMART_CART_SHOW'); ?><?php if($doc->direction == 'rtl') { ?> <i class="fa fa-chevron-left"></i><?php } else { ?> <i class="fa fa-chevron-right"></i><?php } ?></a>
		<?php if(VmConfig::get('popup_rel',1) && $this->products and is_array($this->products) && count($this->products)>0){
			$product = reset($this->products);
			$customFieldsModel = VmModel::getModel('customfields');
			$product->customfields = $customFieldsModel->getCustomEmbeddedProductCustomFields($product->allIds,'R');
			$customFieldsModel->displayProductCustomfieldFE($product,$product->customfields);
			if(!empty($product->customfields)){ ?>
				<div class="product-related-products">
					<h4 class="heading-style-4"><?php echo vmText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h4>
					<div class="row-fluid cols-<?php echo count($product->customfields) < 4 ? count($product->customfields) : 3 ; ?>">
					<?php $i = 0;
					foreach($product->customfields as $rFields){
						if($i > 2) continue;
						if(!empty($rFields->display)){ ?>
						<div class="span12">
							<div class="product-field-display"><?php echo $rFields->display ?></div>
						</div>
					<?php $i++;
						}
					} ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
</div>
<script>
	jQuery(function(){
		jQuery('#facebox').prepend('<div id="facebox_overlay_inner"/>');
		jQuery('.close_facebox, #facebox_overlay_inner').click(function(){
			jQuery(document).trigger('close.facebox');
			return false;
		})
	})
</script>