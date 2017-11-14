<?php // no direct access
defined('_JEXEC') or die('Restricted access');

/* ID for jQuery dropdown */
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
//
?>

<dl class="VMmenu<?php echo $class_sfx ?>" id="<?php echo "VMmenu".$ID ?>" >
	<?php require JModuleHelper::getLayoutPath('mod_virtuemart_category', $params->get('layout', 'default').'_item'); ?>
</dl>
<script>
jQuery(document).bind('ready', function(){
	jQuery('#VMmenu<?php echo $ID ?> dt.parent').bind('click', function(){
		if(!jQuery(this).hasClass('opened') && !jQuery(this).next().hasClass('current')){
			jQuery(this).addClass('opened').next().stop().slideDown().siblings('dd').not('.current').slideUp();
			jQuery(this).find('>a').addClass('active');
			jQuery(this).siblings('dt').removeClass('opened').find('>a').removeClass('active');
			return false;
		}
	})
})
</script>