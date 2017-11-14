<?php // no direct access
defined('_JEXEC') or die('Restricted access');
if($module->position == 'map' || $module->position == 'content-top'){
	$cols = VmConfig::get ('homepage_categories_per_row', 3);
	if($cols < 1) $cols = 1;
?>
<div class="row-fluid cols-<?php echo $cols; ?>">
	<?php foreach ($categories as $category){
	//var_dump($category); ?>
	<div class="span12 item">
		<?php $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattthumb = '<img src="'.$category->file_url_thumb.'" alt="'.$category->category_name.'">';
		$cattext = $category->category_name;
		echo '<figure class="vm-product-media-container">'.JHTML::link($caturl, $cattthumb).'</figure>';
		echo '<h3 class="vm-category__title">'.JHTML::link($caturl, $cattext).'</h3>'; ?>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
<ul class="menu_<?php echo $class_sfx ?> virtuemart_categories">
<?php foreach ($categories as $category){
	$active_menu = '';
	$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
	$cattext = $category->category_name;
	if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu .= ' active';
	if ($category->childs ) $active_menu .= ' parent'; ?>
	<li class="<?php echo $active_menu ?>">
		<?php echo JHTML::link($caturl, $cattext); ?>
		<?php if ($category->childs ) { ?>
		<ul class="menu<?php echo $class_sfx; ?>">
			<?php foreach ($category->childs as $child){
				$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
				$cattext = $child->category_name; ?>
			<li>
				<?php echo JHTML::link($caturl, $cattext); ?>
			</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</li>
<?php } ?>
</ul>
<?php } ?>