<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$document =& $doc;
$document->addScript('modules/mod_tm_bg_youtube/assets/js/jquery.tubular.1.0.js');
?>


<div class="tm_bg_youtube tm_bg_youtube_<?php echo $moduleclass_sfx ?>" id="module_id_<?php echo $module->id; ?>" style="background: url(<?php echo JURI::base().$params->get("myimage"); ?>) left top no-repeat;background-size: cover;">
	<?php echo $module->content;?>
</div>

<script>
jQuery(function(){
	jQuery('#module_id_<?php echo $module->id; ?>').tubular({
		videoId: '<?php echo $params->get("youtube_id"); ?>',
		mute: <?php echo $params->get("mute"); ?>
	})
})
</script>
<style type="text/css">
	@media (min-width: 320px) and (max-width: 767px) {
      #tubular-container , #tubular-shield {display: none!important;}
    }
</style>