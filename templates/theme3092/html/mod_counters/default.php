<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStylesheet('modules/mod_counters/assets/css/counters.css');
$document->addScript('modules/mod_counters/assets/js/jquery.countdown.min.js');
$count = $params->get('max_dim') - $params->get('min_dim');
?>

<div id="counters_<?php echo $module->id; ?>" class="counters counters__<?php echo $moduleclass_sfx ?>">
	<?php $html = "";
	$script = "";
	$key = 0;
	for($i = $count; $i >=0; $i--){
		switch($i+$params->get('min_dim')){
			case 5:
				$title = JText::_('MOD_COUNTERS_YEARS');
				$class = "years";
				break;
			case 4:
				$title = JText::_('MOD_COUNTERS_MONTHS');
				$class = "months";
				break;
			case 3:
				$title = JText::_('MOD_COUNTERS_DAYS');
				$class = "days";
				break;
			case 2:
				$title = JText::_('MOD_COUNTERS_HOURS');
				$class = "hours";
				break;
			case 1:
				$title = JText::_('MOD_COUNTERS_MINUTES');
				$class = "minutes";
				break;
			case 0:
				$title = JText::_('MOD_COUNTERS_SECONDS');
				$class = "seconds";
				break;
			default:
    			$title = "";
				$class = "";
		}
		if($key%2) {
			$class .=" even";
		} else {
			$class .=" odd";
		}
		$html .= "<span class=\"".$class."\"><span class=\"value\"></span>".$title."</span>";
		$script .= "
			$('#counters_".$module->id." .".str_replace(' ', '.', $class)." .value')
          .countdown('". JHtml::_('date', $params->get('date', ''), 'Y/m/d H:i:s')."', function(event) {
          $(this).text(
            event.strftime('%".strtoupper(substr($class, 0 , 1))."')
          );
        });
		";
		$key++;
	}
	echo $html; ?>
</div>
<script>
	jQuery(function($){
		<?php echo $script; ?>
	})
</script>