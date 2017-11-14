<?php
/**
 * Sequence Slider for Joomla! Module
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Sequence Slider: http://www.sequencejs.com/ & Articles Newsflash standard module
 * 
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$app    = JFactory::getApplication(); 
$template = $app->getTemplate();

// Include Camera Slideshow styles
$document->addStyleSheet('templates/'.$template.'/css/sequence.css');

// Include Camera Slideshow scripts
$document->addScript('modules/mod_sequence_slider/js/jquery.sequence-min.js');

$thumbnails = $params->get('thumbnails', false);
$loader = $params->get('loader', false);
$navigation = $params->get('navigation', false);
$playPause = $params->get('playPause', false);
$pagination = $params->get('pagination', false);
// Item URL
if($params->get('item_url', false)){
	$itemURLs = explode(';', $params->get('item_url', false));
}

?>
<div id="sequence_<?php echo $module->id; ?>" class="sequence-slider<?php if ($thumbnails) echo " sequence-thumbnails"; ?>" style="padding-bottom:<?php echo $params->get('height'); ?>">
	<?php if($navigation){ ?>
	<div class="sequence-prev"></div>
	<div class="sequence-next"></div>
	<?php }
	if($playPause){ ?>
	<div class="sequence-pause"></div>
	<?php }
	if($loader){ ?>
	<div class="sequence-preloader">
		<svg class="preloading" xmlns="http://www.w3.org/2000/svg">
	        <circle class="circle" cx="6" cy="6" r="6"></circle>
	        <circle class="circle" cx="22" cy="6" r="6"></circle>
	        <circle class="circle" cx="38" cy="6" r="6"></circle>
	    </svg>
	</div>
	<?php }
	if($pagination) { ?>
	<div class="sequence-pagination-wrapper<?php if ($thumbnails){ ?> sequence-thumbnails<?php } ?>">
		<ul class="sequence-pagination<?php if ($thumbnails){ ?> sequence-thumbnails<?php } ?>">
		<?php $i=0;	
			foreach ($list as $item){ ?>
			<li><img class="slide-thumb" src="<?php echo htmlspecialchars(json_decode($item->images)->image_intro); ?>" alt=""></li>
			<?php $i++;
			} ?>
		</ul>
	</div>
	<?php } ?>
	<ul class="sequence-canvas">
<?php
	foreach ($list as $item){ ?>
		<li>	
			<?php require JModuleHelper::getLayoutPath('mod_sequence_slider', '_item'); ?>
		</li>
	<?php } ?>
    </ul>
</div>
<script>
	jQuery(function($){
		var options_<?php echo $module->id; ?> = {
            autoPlay: <?php echo (bool)$params->get('autoPlay', true) ? "true" : "false"; ?>,
            autoPlayDelay: <?php echo (int)$params->get('autoPlayDelay', '7000'); ?>,
            nextButton: <?php echo (bool)$navigation ? "true" : "false"; ?>,
            prevButton: <?php echo (bool)$navigation ? "true" : "false"; ?>,
            pauseButton: <?php echo (bool)$playPause ? "true" : "false"; ?>,
            pagination: <?php echo (bool)$pagination ? "true" : "false"; ?>,
			preloader: <?php echo (bool)$loader ? "true" : "false"; ?>,
			pauseOnHover: <?php echo (bool)$params->get('hover', false) ? "true" : "false"; ?>,
            fallback: {
                theme: "fade",
                speed: 500
            },
            swipeEvents: {
			    left: "next",
			    right: "prev",
			    up: "prev",
			    down: "next"
			}
        }
        var sequence = $("#sequence_<?php echo $module->id; ?>").sequence(options_<?php echo $module->id; ?>).data("sequence");
    });
</script>