<?php defined('_JEXEC') or die('Restricted access'); 
error_reporting('E_ALL'); 
JFactory::getLanguage()->load('mod_tmbox');
vmJsApi::jQuery();
vmJsApi::jPrice();
echo vmJsApi::writeJS();

vmJsApi::addJScript("/components/com_tmbox/assets/scripts/tmbox.js",false,false);

if($tmbox){
$items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_tmbox' );
//print_r($items);
foreach ( $items as $item ) {
    if($item->query['view'] === 'comparelist'){
		//print_r($item->id);
        $itemid= $item->id;
		
    }
}
?>
<div class="module<?php echo $moduleclass_sfx; ?>" id="mod_tmboxcompare">
    <div class="not_text compare"><?php echo JText::_('YOU_HAVE_NO_PRODUCT_TO_COMPARE');?></div>
	<div class="vmproduct">
			<?php
			foreach ($compare as $product) {
				?>
				<div id="compare_prod_<?php echo $product->virtuemart_product_id; ?>" class="modcompareprod clearfix">
	                    <div class="image fleft">
	                    <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
	                    	<?php
	                    	$image = $product->images[0];
	                    	 echo $image->displayMediaThumb('class="product-image"',false,$image->file_description);  ?>
	                    </a>
	                    </div>
	                    <div class="extra-wrap">
	                        <div class="name">
	                              <?php echo JHTML::link($product->link, $product->product_name); ?> 
	                        </div>
	                        <div class="remcompare"><a title="remove"  onclick="TmboxRemoveCompare('<?php echo $product->virtuemart_product_id ;?>');"><?php echo JText::_('COM_COMPARE_REMOVE') ?></a></div>
	                    </div>
				</div>
		<?php }
	?>
		</div>
  <div class="clear"></div>
  <div id="btncompare" > <a class="btn_compare btn btn-info" href="<?php echo JRoute::_('index.php?option=com_tmbox&Itemid='.$itemid.''); ?>"><?php echo JText::_('COM_COMPARE_GO'); ?></a></div>

</div>
<?php } else {
	$items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_tmbox' );
	//print_r($items);
    foreach ( $items as $item ) {
        if($item->query['view'] === 'mywishlist'){
			//print_r($item->id);
            $itemid= $item->id;
			
        }
    } ?>
    <div class="module<?php echo $moduleclass_sfx; ?>" id="mod_tmboxwishlist">
    <div class="not_text wishlists"><?php echo JText::_('YOU_HAVE_NO_PRODUCT_TO_WISHLISTS');?></div>
    	<div class="vmproduct">
		<?php
		foreach ($wishlist as $product) {
			?>
			<div id="wishlists_prod_<?php echo $product->virtuemart_product_id; ?>" class="modwishlistsprod clearfix">
                    <div class="image fleft">
                    <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
                    <?php
                    	$image = $product->images[0];
                    	echo $image->displayMediaThumb('class="product-image"',false,$image->file_description);  
                    ?>
                    </a>
                    </div>
                    <div class="extra-wrap">
                        <div class="name">
                              <?php echo JHTML::link($product->link, $product->product_name); ?> 
                        </div>
                        <div class="remwishlists"><a title="remove"  onclick="TmboxRemoveWishlists('<?php echo $product->virtuemart_product_id ;?>');"><?php echo JText::_('COM_WHISHLISTS_REMOVE') ?></a></div>
                    </div>
			</div>
            <div class="clear"></div>
			<?php }
		?>
		</div>
	  	<div class="clear"></div>
  	    <div id="btnwishlist" > <a class="btn_compare btn btn-info" href="<?php echo JRoute::_('index.php?option=com_tmbox&Itemid='.$itemid.''); ?>"><?php echo JText::_('COM_WISHLISTS_GO'); ?></a></div>
    </div>
<?php } ?>
<style type="text/css">
.displayNone {
	display: none;
}
</style>