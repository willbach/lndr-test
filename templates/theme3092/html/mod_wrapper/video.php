<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_wrapper
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="video_wrapper" style="position: relative; height: 0; padding-bottom: <?php echo ((int)$height/(int)$width)*100; ?>%">
<iframe style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; width: 100%; height: 100%;"
	name="<?php echo $target; ?>"
	src="<?php echo $url; ?>"
	scrolling="<?php echo $scroll; ?>"
	frameborder="<?php echo $frameborder; ?>"
	class="wrapper<?php echo $moduleclass_sfx; ?>"
	webkitallowfullscreen
	mozallowfullscreen
	allowfullscreen>
	<?php echo JText::_('MOD_WRAPPER_NO_IFRAMES'); ?>
</iframe>
</div>