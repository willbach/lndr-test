<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('params');
$query->from($db->quoteName('#__extensions'));
$query->where($db->quoteName('name')." = ".$db->quote('com_content'));
$db->setQuery($query);
$params = $db->loadResult();
$params = json_decode($params);

////////////////

function checkFilterOrderCustom($toCheck){

		if(empty($toCheck)) return $this->_selectedOrdering;

		if(!in_array($toCheck, $this->_validOrderingFieldName)){

			$break = false;
			vmSetStartTime();
			foreach($this->_validOrderingFieldName as $name){
				if(!empty($name) and strpos($name,$toCheck)!==FALSE){
					$this->_selectedOrdering = $name;
					$break = true;
					break;
				}
			}
			if(!$break){
				$app = JFactory::getApplication();
				$view = vRequest::getCmd('view');
				if (empty($view)) $view = 'virtuemart';
				$app->setUserState( 'com_virtuemart.'.$view.'.filter_order',$this->_selectedOrdering);
			}
		} else {
			$this->_selectedOrdering = $toCheck;
		}

		return $this->_selectedOrdering;
	}

	function getOrderByListCustom ($virtuemart_category_id = FALSE) {

		$getArray = vRequest::getGet();
		ksort($getArray);

		$fieldLink = '';

		foreach ($getArray as $key => $value) {
			if (is_array ($value)) {
				foreach ($value as $k => $v) {
					if(empty($v)) continue;
					$fieldLink .= '&' . urlencode($key) . '[' . urlencode($k) . ']' . '=' . urlencode($v);
				}
			}
			else {
				if($key=='dir' or $key=='orderby') continue;
				if(empty($value)) continue;
				$fieldLink .= '&' . urlencode($key) . '=' . urlencode($value);
			}
		}

		$fieldLink = 'index.php?'. ltrim ($fieldLink,'&');

		$orderDirLink = '';
		$orderDirConf = VmConfig::get ('prd_brws_orderby_dir');
		$orderDir = vRequest::getCmd ('dir', $orderDirConf);
		if ($orderDir != $orderDirConf ) {
			$orderDirLink .= '&dir=' . $orderDir;	//was '&order='
		}

		$orderbyTxt = '';
		$orderby = vRequest::getString ('orderby', VmConfig::get ('browse_orderby_field'));

		$orderbyCfg = VmConfig::get ('browse_orderby_field');
		if ($orderby != $orderbyCfg) {
			$orderbyTxt = '&orderby=' . $orderby;
		}

		$manufacturerTxt = '';
		$manufacturerLink = '';
		if (VmConfig::get ('show_manufacturers')) {

			$manuM = VmModel::getModel('manufacturer');
			vmSetStartTime('mcaching');
			$mlang=(!VmConfig::get('prodOnlyWLang',false) and VmConfig::$defaultLang!=VmConfig::$vmlang and Vmconfig::$langCount>1);
			if(true){
				$cache = JFactory::getCache('com_virtuemart_cat_manus','callback');
				$cache->setCaching(true);
				$manufacturers = $cache->call( array( 'VirtueMartModelManufacturer', 'getManufacturersOfProductsInCategory' ),$virtuemart_category_id,VmConfig::$vmlang,$mlang);
				vmTime('Manufacturers by Cache','mcaching');
			} else {
				$manufacturers = $manuM ->getManufacturersOfProductsInCategory($virtuemart_category_id,VmConfig::$vmlang,$mlang);
				vmTime('Manufacturers by function','mcaching');
			}

			// manufacturer link list
			$manufacturerLink = '';
			$virtuemart_manufacturer_id = vRequest::getInt ('virtuemart_manufacturer_id', '');
			if ($virtuemart_manufacturer_id != '') {
				$manufacturerTxt = '&virtuemart_manufacturer_id=' . $virtuemart_manufacturer_id;
			}

			if (count ($manufacturers) > 0) {
				//$manufacturerLink = '<div class="orderlist">';
				$manufacturerLink = '';
				if ($virtuemart_manufacturer_id > 0) {
					$allLink = str_replace($manufacturerTxt,'',$fieldLink);
					$manufacturerLink .= '<option value="' . JRoute::_ ($allLink . $orderbyTxt . $orderDirLink , FALSE) . '">' . vmText::_ ('COM_VIRTUEMART_SEARCH_SELECT_ALL_MANUFACTURER') . '</option>';
				}
				if (count ($manufacturers) > 1) {
					foreach ($manufacturers as $mf) {
						$link = JRoute::_ ($fieldLink . '&virtuemart_manufacturer_id=' . $mf->virtuemart_manufacturer_id . $orderbyTxt . $orderDirLink,FALSE);
						if ($mf->virtuemart_manufacturer_id != $virtuemart_manufacturer_id) {
							$manufacturerLink .= '<option value="' . $link . '">' . $mf->mf_name . '</option>';
						}
						else {
							$currentManufacturerLink = '<div class="title">' . vmText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') . '</div><select><option selected>' . $mf->mf_name . '</option>';
						}
					}
				}
				elseif ($virtuemart_manufacturer_id > 0) {
					$currentManufacturerLink = '<div class="title">' . vmText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') . '</div><select><option selected>' . $manufacturers[0]->mf_name . '</option>';
				}
				else {
					$currentManufacturerLink = '<div class="title">' . vmText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') . '</div><select><option selected> ' . $manufacturers[0]->mf_name . '</option>';
				}
				$manufacturerLink .= '</select>';
			}
		}

		/* order by link list*/
		$orderByLink = '';
		$fields = VmConfig::get ('browse_orderby_fields');
		if (count ($fields) > 1) {
			//$orderByLink = '<div class="orderlist">';
			$orderByLink = '';
			foreach ($fields as $field) {

					$dotps = strrpos ($field, '.');
					if ($dotps !== FALSE) {
						$prefix = substr ($field, 0, $dotps + 1);
						$fieldWithoutPrefix = substr ($field, $dotps + 1);
					}
					else {
						$prefix = '';
						$fieldWithoutPrefix = $field;
					}
				if ($fieldWithoutPrefix != $orderby && $field != $orderby) {

					$text = vmText::_ ('COM_VIRTUEMART_' . strtoupper ($fieldWithoutPrefix));

					$field = explode('.',$field);
					if(isset($field[1])){
						$field = $field[1];
					} else {
						$field = $field[0];
					}
					$link = JRoute::_ ($fieldLink . $manufacturerTxt . '&orderby=' . $field,FALSE);

					//$orderByLink .= '<div><a title="' . $text . '" href="' . $link . '">' . $text . '</a></div>';
					$orderByLink .= '<option value="' . $link . '">' . $text . '</option>';
				}
			}
			//$orderByLink .= '</div>';
		}

		$orderDirAct = $orderDir;

		$orderDir = $orderDir == 'ASC' ? 'DESC' : 'ASC';
		
		$orderDirLink = $orderDir != $orderDirConf ? '&dir=' . $orderDir : '';

		$orderDirLinkAct = $orderDirAct != $orderDirConf ? '&dir=' . $orderDirAct : '';

		$orderDirTxt = vmText::_ ('COM_VIRTUEMART_'.$orderDir);

		$orderDirTxtAct = vmText::_ ('COM_VIRTUEMART_'.$orderDirAct);

		$link = JRoute::_ ($fieldLink . $orderbyTxt . $orderDirLink . $manufacturerTxt,FALSE);

		$act_link = JRoute::_ ($fieldLink . $orderbyTxt . $orderDirLinkAct . $manufacturerTxt,FALSE);

		// full string list
		$orderby = $orderby == '' ? strtoupper($orderbyCfg) : strtoupper($orderby);


		$dotps = strrpos ($orderby, '.');
		if ($dotps !== FALSE) {
			$prefix = substr ($orderby, 0, $dotps + 1);
			$orderby = substr ($orderby, $dotps + 1);
		}
		else {
			$prefix = '';
		}

		//$orderByList = '<div class="orderlistcontainer sorting"><div class="title">' . vmText::_ ('COM_VIRTUEMART_ORDERBY') . '</div><div class="sort_list"><div class="activeOrder"><a href="' . $link . '">' . vmText::_ ('COM_VIRTUEMART_SEARCH_ORDER_' . $orderby) . ' ' . $orderDirTxt . '</a></div>';
		//$orderByList .= $orderByLink . '</div></div>';
		$orderByList = '<div class="orderlistcontainer sorting span4"><div class="title">' . vmText::_ ('COM_VIRTUEMART_ORDERBY') . '</div><select><option selected value="' . $act_link . '">' . vmText::_ ('COM_VIRTUEMART_SEARCH_ORDER_' . $orderby) . ' ' . $orderDirTxtAct . '</option>
		<option value="' . $link . '">' . vmText::_ ('COM_VIRTUEMART_SEARCH_ORDER_' . $orderby) . ' ' . $orderDirTxt . '</option>';
		$orderByList .= $orderByLink . '</select></div>';

		$manuList = '';
		if (VmConfig::get ('show_manufacturers')) {
			if (empty ($currentManufacturerLink)) {
				$currentManufacturerLink = '<div class="title">' . vmText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') . '</div><select><option selected>' . vmText::_ ('COM_VIRTUEMART_SEARCH_SELECT_MANUFACTURER') . '</option>';
			}
			$manuList = '<div class="orderlistcontainer manufacturer span5">'.$currentManufacturerLink;
			$manuList .= $manufacturerLink . '</div>';

		}

		return array('orderby'=> $orderByList, 'manufacturer'=> $manuList);
	}

///////////////

$this->orderByListCustom = getOrderByListCustom($this->categoryId);
?>
<div id="com_virtuemart" class="page-blog">
<div class="category-view"> <?php
$js = "
jQuery(document).ready(function ($) {
	jQuery('.listcontainer').hover(
		function() { jQuery(this).addClass('show')},
		function() { jQuery(this).removeClass('show')}
	)
	$('.orderlistcontainer select').change(function(){
		window.location.href = $(this).val();
	})
});
";
vmJsApi::addJScript('vm.hover',$js); ?>
<?php
		if(empty($this->category->virtuemart_vendor_id == 0)){ ?>
<div class="category">
	
	<div class="item_img img-intro__none">

		<?php
		if(empty($this->category->virtuemart_vendor_id == 0)){
			echo $this->category->images[0]->displayMediaFull("",false, "", false); 
		}
		 ?>
		
			<?php if($this->category->category_name) { ?>
			<div class="category_content">
			<h1><?php echo $this->category->category_name; ?></h1>
			<?php }
			if (empty($this->keyword) and !empty($this->category)) { ?>
			<div class="category_desc">
				<?php echo $this->category->category_description; ?>
			</div>
			</div>
			<?php } ?>
		
	</div>
	
</div>
<?php } ?>
<?php // Show child categories
if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		echo ShopFunctionsF::renderVmSubLayout('categories',array('categories'=>$this->category->children));

	}
}

if($this->showproducts){
?>
<div class="browse-view">
<?php

if (!empty($this->keyword)) {
	//id taken in the view.html.php could be modified
	$category_id  = vRequest::getInt ('virtuemart_category_id', 0); ?>
	<h3><?php echo $this->keyword; ?></h3>

	<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

		<!--BEGIN Search Box -->
		<div class="virtuemart_search">
			<?php echo $this->searchcustom ?>
			<?php echo $this->searchCustomValues ?>
			<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
			<button type="submit" value="<?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="btn button" onclick="this.form.keyword.focus();"><?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?></button>
		</div>
		<input type="hidden" name="search" value="true"/>
		<input type="hidden" name="view" value="category"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

	</form>
	<!-- End Search Box -->
<?php  } ?>

<?php // Show child categories

	?>
<div class="orderby-displaynumber row-fluid">
	<?php echo $this->orderByListCustom['orderby']; ?>
	<?php echo $this->orderByListCustom['manufacturer']; ?>
	<div class="display-number span3"><div class="title"><?php echo $this->vmPagination->getResultsCounter ();?></div><?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?></div>
	<div class="clearfix"></div>
	<?php if($this->vmPagination->getPagesLinks ()): ?>
	<div class="pagination vm-pagination-top">
		<?php echo $this->vmPagination->getPagesLinks (); ?>
		<?php if($params->show_pagination_results): ?>
		<span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
		<?php endif; ?>
	</div>
	<?php endif; ?>

</div> <!-- end of orderby-displaynumber -->

	<?php
	if (!empty($this->products)) {
	$products = array();
	$products[0] = $this->products;
	echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));

	?>
<?php if($this->vmPagination->getPagesLinks ()): ?>
<div class="pagination vm-pagination-bottom">
<?php echo $this->vmPagination->getPagesLinks (); ?>
<?php if($params->show_pagination_results): ?>
<span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
<?php endif; ?>
</div>
<?php endif; ?>
	<?php
} elseif (!empty($this->keyword)) {
	echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div>

<?php } ?>
</div>

<?php
$j = "Virtuemart.container = jQuery('.category-view');
Virtuemart.containerSelector = '.category-view';";

vmJsApi::addJScript('ajaxContent',$j);
?>
<!-- end browse-view -->
</div>

<script>
	jQuery.extend(Virtuemart, {
		product: function(carts){
			carts.each(function(){
				var cart = jQuery(this),
				quantityInput=cart.find('input[name="quantity[]"]'),
				plus   = cart.find('.quantity-plus'),
				minus  = cart.find('.quantity-minus'),
				select = cart.find('select:not(.no-vm-bind)'),
				radio = cart.find('input:radio:not(.no-vm-bind)'),
				virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val(),
				quantity = cart.find('.quantity-input');

				var Ste = parseInt(quantityInput.attr("step"));

				//Fallback for layouts lower than 2.0.18b
				if(isNaN(Ste)){
					Ste = 1;
				}

		        jQuery(plus).off('click', Virtuemart.incrQuantity);
		        jQuery(plus).on('click', {cart:cart}, Virtuemart.incrQuantity);

		        jQuery(minus).off('click', Virtuemart.decrQuantity);
		        jQuery(minus).on('click', {cart:cart},Virtuemart.decrQuantity);

		        jQuery(select).off('change', Virtuemart.eventsetproducttype);
		        jQuery(select).on('change', {cart:cart,virtuemart_product_id:virtuemart_product_id},Virtuemart.eventsetproducttype);

		        jQuery(radio).off('change', Virtuemart.eventsetproducttype);
		        jQuery(radio).on('change', {cart:cart,virtuemart_product_id:virtuemart_product_id},Virtuemart.eventsetproducttype);

		        jQuery(quantity).off('keyup', Virtuemart.eventsetproducttype);
		        jQuery(quantity).on('keyup', {cart:cart,virtuemart_product_id:virtuemart_product_id},Virtuemart.eventsetproducttype);

		        this.action ="#";
		        addtocart = cart.find('.addtocart-button[name="addtocart"]');
		        jQuery(addtocart).off('click',Virtuemart.addtocart);
		        jQuery(addtocart).on('click',{cart:cart},Virtuemart.addtocart);
			});
		}
	});
</script>