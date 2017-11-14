<?php
/**
 * Articles Newsflash Advanced
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Articles Newsflash standard module
 * 
*/
defined('_JEXEC') or die;
require_once (JPATH_BASE.'/components/com_content/helpers/icon.php');
$item_heading = $params->get('item_heading', 'h4');
$item_images = json_decode($item->images);
$urls    = json_decode($item->urls);
jimport( 'joomla.filter.filteroutput' );

if($layout!='edit'){
	$canEdit = $item->params->get('access-edit');
	if ($canEdit) : ?>
	<!-- Icons -->
	<?php if ($canEdit || $item->params->get('show_print_icon') || $item->params->get('show_email_icon')) : ?>
		<?php echo JFilterOutput::ampReplace(html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $item->params, 'item' => $item, 'print' => false)))); ?>
	<?php endif;
	endif;
} ?>

<div class="item_content">
<?php if ($params->get('link_titles') && $item->readmore) : ?>
<a href="<?php echo $item->link;?>">
<?php endif; ?>
<?php if ($params->get('intro_image')): ?>
	<div class="row-fluid">
<div class="item_container span7">
<?php endif; ?>
<?php if ($item_images->image_intro_caption) : ?>
<i class="<?php echo $item_images->image_intro_caption; ?>"></i>
<?php endif; ?>
	<!-- Item title -->
	<?php if ($params->get('item_title')) : ?>
	<<?php echo $item_heading; ?> class="item_title item_title__<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php echo $item->title; ?>
	</<?php echo $item_heading; ?>>
	<?php endif; ?>
<div class="subtitle"><?php echo htmlspecialchars($item_images->image_intro_alt); ?></div>
	<?php if ($params->get('show_tags', 1) && !empty($item->tags)) :
	$item->tagLayout = new JLayoutFile('joomla.content.tags');

	echo $item->tagLayout->render($item->tags->itemTags);
	endif;

	if ($params->get('published')) : ?>
	<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
		<?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC1')); ?>
	</time>
	<?php endif;

	if ($params->get('createdby')) : ?>
	<div class="item_createdby">
		<?php $author = $item->author;
		$author = ($item->created_by_alias ? $item->created_by_alias : $author);
		echo JText::sprintf('MOD_ARTICLES_NEWS_ADV_BY', $author); ?>
	</div>
	<?php endif;

	echo $item->beforeDisplayContent;

	if ($params->get('show_introtext')) : ?>
	<!-- Introtext -->
	<div class="item_introtext">
		<?php echo $item->introtext; ?>
	</div>
	<?php endif; ?>
	<?php if ($params->get('intro_image')): ?>
	</div>
<div class="imgs_container span5">
<?php if (isset($item_images->image_intro) and !empty($item_images->image_intro)) : ?>
<figure class="item_img img-intro"> 
	<img src="<?php echo htmlspecialchars($item_images->image_intro); ?>" alt="">
</figure>
<?php endif;
if (isset($item_images->image_fulltext) and !empty($item_images->image_fulltext)) : ?>
<figure class="item_img img-full"> 
	<img src="<?php echo htmlspecialchars($item_images->image_fulltext); ?>" alt="">
</figure>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php if ($params->get('link_titles') && $item->readmore) : ?>
</a>
<?php endif; ?>
</div>
<div class="clearfix"></div>