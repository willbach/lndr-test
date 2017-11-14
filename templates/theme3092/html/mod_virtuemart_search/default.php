<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<input type="radio" class="search_toggle" id="search_toggle_<?php echo $module->id?>_1" name="search_toggle_<?php echo $module->id?>">
<label class="search_toggle_button_1" for="search_toggle_<?php echo $module->id?>_1"><i class="material-design-search100"></i></label>
<div class="search_box">
<!--BEGIN Search Box -->
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get" class="mod_virtuemart_search">
<div class="search<?php echo $params->get('moduleclass_sfx'); ?>">
<?php $output = '<input name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" placeholder="'.$text.'" required>';

			if ($button) :
			    if ($imagebutton) :
			        $button = '<button type="submit" value="'.$button_text.'" class="btn button'.$moduleclass_sfx.'" onclick="this.form.keyword.focus();"><i class="material-design-search100"></i></button>';
			    else :
			        $button = '<button type="submit" value="'.$button_text.'" class="btn button'.$moduleclass_sfx.'" onclick="this.form.keyword.focus();">'.$button_text.'</button>';
			    endif;
		

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;

			    case 'right' :
				    $output = $output.$button;
				    break;

			    case 'left' :
			    default :
				    $output = $button.$output;
				    break;
			endswitch;
			endif;
			
			echo $output;
?>
</label>
</div>
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>
<?php if(!empty($set_Itemid)){
	echo '<input type="hidden" name="Itemid" value="'.$set_Itemid.'" />';
} ?>

	  </form>
<input type="radio" class="search_toggle" id ="search_toggle_<?php echo $module->id?>_2" checked name="search_toggle_<?php echo $module->id?>">
<label class="search_toggle_button_2" for="search_toggle_<?php echo $module->id?>_2"><i class="material-design-close47"></i></label>
<!-- End Search Box -->
</div>