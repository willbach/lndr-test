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
jimport( 'joomla.filter.filteroutput' );

$product = $viewData['product'];
$position = $viewData['position'];
$customTitle = isset($viewData['customTitle']) ? $viewData['customTitle'] : false;;
if(isset($viewData['class'])){
	$class = $viewData['class'];
} else {
	$class = 'product-fields';
}
if (!empty($product->customfieldsSorted[$position])) { ?>
	<div class="<?php echo $class?>">
		<?php if($position === 'related_products' || $position === 'related_categories'){
			$doc = JFactory::getDocument();
			$template = JFactory::getApplication()->getTemplate();
			$js = false;
			if(file_exists(JPATH_ROOT.'/templates/'.$template.'/js/jquery.caroufredsel.js')){
				$doc->addScript('templates/'.$template.'/js/jquery.caroufredsel.js');
				$js = true;
			}
			else if(file_exists(JPATH_ROOT.'/modules/mod_caroufredsel/js/jquery.caroufredsel.js')){
				$doc->addScript('modules/mod_caroufredsel/js/jquery.caroufredsel.js');
				$js = true;
			}
			if($js){
				if($position === 'related_products'){
					$doc->addScriptdeclaration('
					jQuery(function($) {
						var carousel = $("#caroufredsel_'.$class.'")
						carousel.carouFredSel({
							responsive	: true,
							width: \'100%\',
							items		: {
								width : 270,
								height: \'variable\',
								visible		: {
									min			: 1,
									max			: 4
								},
								minimum: 1
							},
							scroll: {
								items: 1,
								fx: "scroll",
								easing: "swing",
								duration: 500,
								queue: true
							},
							auto: false,
							next: "#'.$class.'_carousel_next",
							prev: "#'.$class.'_carousel_prev",
							swipe:{
								onTouch: true
							}
						});
						$(window).load(function(){
							setTimeout(function(){
								carousel.trigger(\'configuration\', {reInit: true})
							}, 100);
						});
					});
				');
				}
				else{
					$doc->addScriptdeclaration('
						jQuery(function($) {
							var carousel = $("#caroufredsel_'.$class.'")
							carousel.carouFredSel({
								responsive	: true,
								width: \'100%\',
								items		: {
									width : 370,
									height: \'variable\',
									visible		: {
										min			: 1,
										max			: 3
									},
									minimum: 1
								},
								scroll: {
									items: 1,
									fx: "scroll",
									easing: "swing",
									duration: 500,
									queue: true
								},
								auto: false,
								next: "#'.$class.'_carousel_next",
								prev: "#'.$class.'_carousel_prev",
								swipe:{
									onTouch: true
								}
							});
							$(window).load(function(){
								setTimeout(function(){
									carousel.trigger(\'configuration\', {reInit: true})
								}, 100);
							});
						});
					');
				}
			}
			if($customTitle and isset($product->customfieldsSorted[$position][0])){
				$field = $product->customfieldsSorted[$position][0]; ?>
				<h3 class="heading-style-4"><?php echo vmText::_ ($field->custom_title) ?></h3>
			<?php } ?>
		<div class="mod_caroufredsel">
		<div id="list_carousel_<?php echo $class; ?>" class="list_carousel">
		<ul id="caroufredsel_<?php echo $class; ?>">
			<?php $custom_title = null;
			foreach ($product->customfieldsSorted[$position] as $field) {
				if ( $field->is_hidden || $field->field_type === 'C') //OSP http://forum.virtuemart.net/index.php?topic=99320.0
				continue; ?>
				<li class="item">
					<?php if (!$customTitle and $field->custom_title != $custom_title and $field->show_title) { ?>
						<span class="product-fields-title-wrapper"><span class="product-fields-title"><strong><?php echo vmText::_ ($field->custom_title) ?></strong></span>
							<?php if ($field->custom_tip) {
								echo JHtml::tooltip (vmText::_($field->custom_tip), vmText::_ ($field->custom_title), 'tooltip.png');
							} ?></span>
					<?php }
					if (!empty($field->display)){
						?><div class="product-field-display"><?php echo $field->display ?></div><?php
					}
					if (!empty($field->custom_desc)){
						?><div class="product-field-desc"><?php echo vmText::_($field->custom_desc) ?></div> <?php
					}
					?>
				</li>
			<?php
				$custom_title = $field->custom_title;
			} ?>
		</ul>
		<div id="<?php echo $class; ?>_carousel_prev" class="caroufredsel_prev"><i class="fa fa-angle-left"></i></div>
		<div id="<?php echo $class; ?>_carousel_next" class="caroufredsel_next"><i class="fa fa-angle-right"></i></div>
		</div>
		</div>
		<?php } else {
			if($customTitle and isset($product->customfieldsSorted[$position][0])){
			$field = $product->customfieldsSorted[$position][0]; ?>
		<div class="product-fields-title-wrapper"><span class="product-fields-title"><strong><?php echo vmText::_ ($field->custom_title) ?></strong></span>
			<?php if ($field->custom_tip) {
				echo JHtml::tooltip (vmText::_($field->custom_tip), vmText::_ ($field->custom_title), 'tooltip.png');
			} ?>
		</div> <?php
		}
		$custom_title = null;
		foreach ($product->customfieldsSorted[$position] as $field) {
			if ( $field->is_hidden ) //OSP http://forum.virtuemart.net/index.php?topic=99320.0
			continue;
			?><div class="product-field product-field-type-<?php echo $field->field_type ?>">
				<?php if (!$customTitle and $field->custom_title != $custom_title and $field->show_title) { ?>
					<span class="product-fields-title-wrapper"><span class="product-fields-title"><?php echo vmText::_ ($field->custom_title) ?></span>
						<?php if ($field->custom_tip) {
							echo JHtml::tooltip (vmText::_($field->custom_tip), vmText::_ ($field->custom_title), 'tooltip.png');
						} ?></span>
				<?php }
				if (!empty($field->display)){
					?><div class="product-field-display"><?php echo $field->display ?></div><?php
				}
				if (!empty($field->custom_desc)){
					?><div class="product-field-desc"><?php echo vmText::_($field->custom_desc) ?></div> <?php
				}
				?>
			</div>
		<?php
			$custom_title = $field->custom_title;
		}
		} ?>
      <div class="clear"></div>
	</div>
<?php } ?>