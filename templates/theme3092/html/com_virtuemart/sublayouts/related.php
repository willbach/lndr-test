<?php defined('_JEXEC') or die('Restricted access');
$related = $viewData['related'];
$customfield = $viewData['customfield']; ?>
<div class="vm-product-media-container">
<a href="<?php echo JRoute::_($related->link) ?>">
	<?php echo  $viewData['thumb']; ?>
	<?php if($related->allPrices[0]["basePrice"] > $related->allPrices[0]["salesPrice"]) echo '<span class="sale_icon">'.vmText::_("TPL_SALE").'</span>'; ?>
</a>
</div>
<?php //juri::root() For whatever reason, we used this here, maybe it was for the mails
$app = JFactory::getApplication();
$view = $app->input->getCmd('view', '');

if($view !=='cart'){
	echo '<h5 class="heading-style-5">'.JHtml::link (JRoute::_($related->link), $related->product_name, array('target'=>'_blank')).'</h5>';
} else {
	echo '<h6 class="heading-style-6">'.JHtml::link (JRoute::_($related->link), $related->product_name, array('target'=>'_blank')).'</h6>';
} ?>
<div class="vm-product-details-container">
<?php // Product Short Description
  if (!empty($related->product_s_desc) && $customfield->wDescr && $view !=='cart') { ?>
    <p class="product_s_desc">
      <?php echo shopFunctionsF::limitStringByWord (JFilterOutput::cleanText($related->product_s_desc), 120, '...') ?>
    </p>
<?php }
if($customfield->wPrice){
$currency = calculationHelper::getInstance()->_currencyDisplay; ?>
<div class="vm3pr">
  <?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$related,'currency'=>$currency)); ?>
</div>
<?php } ?>
</div>  