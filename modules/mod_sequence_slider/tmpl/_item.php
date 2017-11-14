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

$images = json_decode($item->images);

$itemUrl='';
if(!empty($itemURLs)){
	if(!empty($itemURLs[$i])) $itemUrl = $itemURLs[$i];
	$itemUrl = preg_replace('/\s+/', '', $itemUrl);
}

if (isset($images->image_fulltext) and !empty($images->image_fulltext)){
$src = htmlspecialchars($images->image_fulltext);
if($params->get('imageLink')=="itemsLinks" || ($params->get('imageLink')=="customLinks" && !empty($itemURL))){
if($params->get('imageLink')=="itemsLinks") $itemUrl = $item->link;
?>
<a href="<?php echo $itemUrl; ?>">
	<img class="slide-img" src="<?php echo $src; ?>" alt="">
</a>
<?php } else { ?>
<img class="slide-img" src="<?php echo $src; ?>" alt="">
<?php }
}
if ($params->get('show_caption', false)){ ?>
<div class="info">
<?php $item_heading = $params->get('item_heading', 'h4');
if ($params->get('item_title', false)){ ?>
	<<?php echo $item_heading; ?> class="slide-title">
	<?php if ($params->get('link_titles') && $item->link != ''){ ?>
		<a href="<?php echo $item->link;?>"><?php echo $item->title;?></a>
	<?php } else {
		echo $item->title;
	} ?>
	</<?php echo $item_heading; ?>>
<?php }

	echo $item->afterDisplayTitle;

	echo $item->beforeDisplayContent;

if ($params->get('published')){ ?>
	<div class="item_published">
		<?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC1')); ?>
	</div>
<?php } ?>
<div class="item_introtext">
	<?php echo $item->introtext; ?>
</div>
<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')){
	$readMoreText = JText::_('MOD_SEQUENCE_SLIDER_READMORE');
	if ($item->alternative_readmore) $readMoreText = $item->alternative_readmore;
	echo '<!-- Read More link -->
			<a class="btn btn-info readmore" href="'.$item->link.'"><span>'. $readMoreText .'</span></a>';
} ?>
</div>
<?php } ?>