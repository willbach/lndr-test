<?php
/**
 * sublayout products
 *
 * @package	VirtueMart
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
 * @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
 */

defined('_JEXEC') or die('Restricted access');
$products_per_row = empty($viewData['products_per_row'])? 1:$viewData['products_per_row'] ;
$currency = $viewData['currency'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');
$showRating = $viewData['showRating'];
$tabshome = $viewData['tabshome'];
$prodslider = $viewData['prodslider'];
$layaoutwhishlist = $viewData['layaoutwhishlist'];
//print_r($tabshome);
if ($tabshome == 'tabshome'){
	$listing_class = 'tabpane ';
	$link_params = 'role="tab" data-toggle="tab"';
} else {
	$listing_class = '';
	$link_params = '';
}


$app    = JFactory::getApplication();
$template = $app->getTemplate(true);
$params = $template->params;
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

$dynamic = false;
if (vRequest::getInt('dynamic',false)) {
	$dynamic = true;
}
if ($option == "com_virtuemart" && $view == "category") {
if(isset($viewData['products']['featured'])) {
	unset($viewData['products']['featured']);
}
if(isset($viewData['products']['discontinued'])) {
	unset($viewData['products']['discontinued']);
}
if(isset($viewData['products']['latest'])) {
	unset($viewData['products']['latest']);
}
if(isset($viewData['products']['topten'])) {
	unset($viewData['products']['topten']);
}
if(isset($viewData['products']['recent'])) {
	unset($viewData['products']['recent']);
}
}

$themeLayout = 1;

switch ($themeLayout) {
  case '0':
    $rowClass = 'row';
    break;

  case '1':
    $rowClass = 'row';
    break;
  
  default:
    $rowClass = 'row';
    break;
}
if ($prodslider == 'prodslider') {	
	echo '<div class="slider-box">';
}
if ($tabshome == 'tabshome'){	
//var_dump($viewData['products']['featured']); ?>
<div class="bs-tabs">
<div class="tabcontent">
<?php }

foreach ($viewData['products'] as $type => $products ) {

	$col = 1;
	$nb = 1;
	$row = 1;

	if($dynamic){
		$rowsHeight[$row]['product_s_desc'] = 1;
		$rowsHeight[$row]['price'] = 1;
		$rowsHeight[$row]['customfields'] = 1;
		$col = 2;
		$nb = 2;
	} else {
		$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);
	}


	if(!empty($type)){

		$productTitle = vmText::_('COM_VIRTUEMART_'.$type.'_PRODUCT');
		?>
		<h2><?php echo $productTitle ?></h2>
		<div id="<?php echo $type ?>-view" class="<?php echo $listing_class; ?> <?php echo $type ?>-view <?php echo $type == 'featured' ? 'active' : '' ?>" id="<?php echo $type ?>">
		<?php // Start the Output
	}

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);

	$col = 1;
	$nb = 1;
	$row = 1;

	foreach ( $products as $product ) {

		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) {
			if ($prodslider == 'prodslider') {	
		 ?>
			<div class='itemslide'>
		<?php } else { ?>		
			<div class="<?php echo $rowClass; ?> prod">
		<?php
			}  
		}

		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = 'last-border';
		} else {
			$show_vertical_separator = $verticalseparator;
		}
		if($layaoutwhishlist) { 
		 	$idprod = 'wishlists_prod_';
		 	$styleblockremove = 'block';
		 	$styleblockadd = 'none';

		 }else {
	 		$idprod = 'producthorizon';
	 		$styleblockremove = 'none';
	 		$styleblockadd = 'block';
		 }
    // Show Products ?>
<div id="<?php echo $idprod.$product->virtuemart_product_id; ?>" class="product vm-product-horizon <?php if ($prodslider == 'prodslider') { echo 'slide';}else{echo 'vm-col-' . $products_per_row . ' '.$show_vertical_separator. ' vm-col span' . floor(12/$products_per_row);}  ?>">
		<?php 
        	//$class="";
        	//var_dump($product->prices['priceWithoutTax']);
			if ($product->prices['salesPrice'] < $product->prices['basePrice']) {
				$class=" with_discount_col";
			} else {
				$class="";
			}
        ?>
		<div id="producthorizont" class="prod-box<?php echo $class; ?> spacer product-container">
			
			<div class="vm-product-media-container">
				<a href="<?php echo $product->link.$ItemidStr; ?>">
				<?php if($product->allPrices[0]["basePrice"] > $product->allPrices[0]["salesPrice"]) echo '<span class="sale_icon">'.vmText::_("TPL_SALE").'</span>';
				echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false); ?>
			</a>
			<div class="btn-used">
				<?php  if (is_file(JPATH_BASE . "/components/com_tmbox/template/mywishlists.tpl.php")) : ?>
	                <div style="display:<?php echo $styleblockadd; ?>;"
	                    class="wishlist list_wishlists<?php echo $product->virtuemart_product_id; ?>">
	                    <?php require(JPATH_BASE . "/components/com_tmbox/template/mywishlists.tpl.php"); ?>
	                </div>
	                 <div style="display:<?php echo $styleblockremove; ?>;" class="wishlist remove list_wishlists_remove<?php echo $product->virtuemart_product_id; ?>">
	                    <a class="btn remove_wishlist hasTooltips" title="<?php echo JText::_('REMOVE_TO_WHISHLIST'); ?>" onclick="TmboxRemoveWishlists('<?php echo $product->virtuemart_product_id; ?>');"><i class="fa fa-heart-o"></i><span> <?php echo JText::_("REMOVE_TO_WHISHLIST"); ?></span>   </a>
	                </div>
	            <?php endif; ?>
	            <?php if (is_file(JPATH_BASE . "/components/com_tmbox/template/comparelist.tpl.php")) : ?>
	                <div
	                    class="compare list_compare<?php echo $product->virtuemart_product_id; ?>">
	                    <?php require(JPATH_BASE . "/components/com_tmbox/template/comparelist.tpl.php"); ?>
	                </div>
	            <?php endif; ?>
			</div>
			</div>
			<div class="fleft-box">
				<div class="vm-product-stockhandle-container">
				<?php 
				if ( VmConfig::get ('display_stock', 1)) { ?>
					<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
				<?php 
					echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$product));
				}
				?>
				</div>
				<div class="vm-product-descr-container-<?php echo $rowsHeight[$row]['product_s_desc'] ?>">
					<h5 class="item_name product_title"><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h5>
					<?php // Product Short Description
					if (!empty($product->product_s_desc)) { ?>
					<div class="product_s_desc hidden">
					<?php 	echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 120, ' ...') ?>
					</div>
					<?php } ?>					
				</div>
				<?php //echo $rowsHeight[$row]['price'] ?>
				<div class="vm3pr vm3pr-<?php echo $rowsHeight[$row]['price'] ?>"> <?php
					echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$currency)); ?>
					<div class="clear"></div>
				</div>
			
			<div class="box-btn">
			<?php 
				$addcart = array();
				$fieldtype = array();
				foreach ($product->customfieldsSorted as $key => $value) {
					$addcart[] = $key;
					$fieldtype[] = $value[0]->field_type;
					//variants
				}
				if (in_array('addtocart', $addcart, true) && in_array('C', $fieldtype, true)  || (in_array('addtocart', $addcart, true) && in_array('S', $fieldtype, true))) {
					$class = "option";
					$customs = 'select';
					//echo $customs;
					 ?>
					<div class="vm3pr-<?php echo $rowsHeight[$row]['customfields'] ?> addcart-box"> 
					<?php
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product, 'customs' =>$customs,'rowHeights'=>$rowsHeight[$row], 'position' => array('ontop', 'addtocart'))); ?>
					</div>
				<?php }else { 
					$customs = ''; ?>
					<div class="vm3pr-<?php echo $rowsHeight[$row]['customfields'] ?> addcart-box">
					<?php
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product, 'customs' =>$customs,'rowHeights'=>$rowsHeight[$row], 'position' => array('ontop', 'addtocart'))); ?>
					</div>
					
				<?php } 
			?>
			
			</div>
			<div class="vm-rating">
	         	<?php
		          	//print_r($showRating);
		            echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); 
	            ?>
        	</div>
			</div><div class="clearfix"></div>
			<?php if(vRequest::getInt('dynamic')){
				echo vmJsApi::writeJS();
			} ?>
		</div>
	</div>

	<?php 
		if ($prodslider == 'prodslider') {	
		 
			$nb ++;

		// Do we need to close the current row now?
		if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
			</div>
			<?php
			$col = 1;
			$row++;
		} else {
			$col ++;
		}
		 } else { 		
			$nb ++;

		// Do we need to close the current row now?
		if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
			</div>
			<?php
			$col = 1;
			$row++;
		} else {
			$col ++;
		}
	}  
	}
	if(!empty($tabshome)){ 
		echo '</div>';	
	}
  
}  
if ($tabshome == 'tabshome'){ 
	echo '</div></div><div class="seeall"><a href="'.JRoute::_ ("index.php?option=com_virtuemart&view=category&virtuemart_category_id=1").'" class="btn">See all products</a></div>';
}
if ($prodslider == 'prodslider') {	
	echo '</div>';
}