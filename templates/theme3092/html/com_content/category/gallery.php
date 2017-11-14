<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);
$document = JFactory::getDocument();
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
jimport( 'joomla.filter.filteroutput' );
$functions_path = 'templates/'.$template->template.'/includes/';
include_once $functions_path.'functions.php';
if ($this->params->get('user_hover')){
  $hover_active = 'hover_true';
  $item_hover_style = $this->params->get('hover_style', 'style1');
  $document->addStyleSheet('templates/'. $template->template .'/css/hover_styles/'.$item_hover_style.'.css');
} else {
  $item_hover_style = "";
  $hover_active = "hover_false";
}
if($this->params->get('show_layout_mode') || $this->params->get('show_filter') || $this->params->get('show_sort')){
JHtml::_('jquery.framework', true, null, true);
$document->addScript('templates/'.$template->template.'/js/jquery.mixitup.min.js');
}

$document->addStyleSheet('templates/'. $template->template .'/css/portfolio.css'); ?>
<div class="note"></div>
<section class="page-gallery page-gallery__<?php echo $this->pageclass_sfx;?>">
  <?php if ($this->params->get('show_page_heading', 1)) : ?>
  <header class="page_header">
    <<?php echo $template->params->get('categoryPageHeading', 'h3'); ?>><?php echo $this->escape($this->params->get('page_heading')); ?></<?php echo $template->params->get('categoryPageHeading', 'h3'); ?>>
  </header>
  <?php endif;
  if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
  <header class="category_title">
    <h2> <?php echo $this->escape($this->params->get('page_subheading'));
      if ($this->params->get('show_category_title')) : ?>
      <span class="subheading-category"><?php echo $this->category->title;?></span>
      <?php endif; ?>
    </h2>
  </header>
  <?php endif;
  if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
  <div class="category_desc">
    <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
    <img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
    <?php endif;
    if ($this->params->get('show_description') && $this->category->description) :
    echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category');
    endif; ?>
    <div class="clr"></div>
  </div>
  <?php endif;
  $galleryCategories = array();
  foreach ($this->intro_items as $key => &$item){
      $categoryTitle = $item->category_title;
      $galleryCategories[] = $categoryTitle;
     // $galleryCategoriesAll[] = $item->parent_title;
  };
  $galleryCategories = array_unique($galleryCategories);
  if((!empty($this->lead_items) || (!empty($this->intro_items)))): ?>
  <!-- Filter -->
  <?php 
  if($this->params->get('show_filter')): ?>
  <div class="filters">
    <b><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_BY_CATEGORY'); ?></b>
    <ul id="filters" class="btn-group">
      <?php print_r($galleryCategoriesAll); ?>
      <li><a class="filter btn mixitup-control-active" data-filter="all"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_SHOW_ALL'); ?></a></li>
      <?php foreach ($galleryCategories as $key => $value) : ?>
      <li><a class="filter btn" data-filter=".<?php echo JFilterOutput::stringURLSafe($value); ?>"><?php echo $value; ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif;
  if($this->params->get('show_sort')): ?>
  <div class="sorting">
    <ul id="sort" class="nav">
      <li><a class="sort asc" data-sort="name:asc" data-order="asc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_NAME'); ?></a>
          <a class="sort desc" data-sort="name:desc" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_NAME'); ?></a>
      </li>
      <li><a class="sort asc" data-sort="date:asc" data-order="asc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_DATE'); ?></a>
          <a class="sort desc" data-sort="date:desc" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_DATE'); ?></a>
      </li>
      <li><a class="sort asc" data-sort="popularity:asc" data-order="asc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_POPULARITY'); ?></a>
          <a class="sort desc" data-sort="popularity:desc" data-order="desc"><?php echo JText::_('TPL_COM_CONTENT_GALLERY_FILTER_POPULARITY'); ?></a>
      </li>
    </ul>
  </div>
  <?php endif;
  endif;
  $leadingcount = 0;
  if (!empty($this->lead_items)) : ?>
  <div class="items-leading">
    <?php foreach ($this->lead_items as &$item) : ?>
    <article class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
      <?php
      $this->item = &$item;
      echo $this->loadTemplate('item');
      ?>
    </article>
    <div class="clearfix"></div>
    <?php $leadingcount++;
    endforeach; ?>
  </div><!-- end items-leading -->
  <div class="clearfix"></div>
  <?php endif;

    $introcount = (count($this->intro_items));
    $counter = 0;

  if (!empty($this->intro_items)) :
  $row = $counter / $this->columns; ?>
  <ul id="isotopeContainer" class="gallery items-row row cols-<?php echo (int) $this->columns;?> <?php echo $hover_active; ?>">
    <?php foreach ($this->intro_items as $key => &$item) :
    $rowcount = (((int) $key) % (int) $this->columns) + 1;
    $itemwidth = 12 / ((int) $this->columns);
    if ($rowcount == 1) :  
    endif;
  
    $this->item = &$item; ?>
    <li class="gallery-item mix mix_all gallery-grid span-<?php echo $itemwidth;?> <?php if($this->params->get('show_filter')){ echo JFilterOutput::stringURLSafe($item->category_title);} ?>" data-date="<?php echo JHtml::_('date', $this->item->publish_up, 'YmdHis'); ?>" data-name="<?php echo $this->item->title; ?>" data-popularity="<?php echo $this->item->hits; ?>">
    <div class="gallery-item__content">
      <?php
      $this->item = &$item;
      echo $this->loadTemplate('item');
      $counter++; ?>
      <div class="clearfix"></div>
    </div>
    </li>
    <?php endforeach; ?>
    <li class="gap col-sm-<?php echo $itemwidth;?>"></li>
    <li class="gap col-sm-<?php echo $itemwidth;?>"></li>
    <li class="gap col-sm-<?php echo $itemwidth;?>"></li>
  </ul>
  <?php endif;
  
  if (!empty($this->link_items)) : ?>
  <div class="items-more">
    <?php echo $this->loadTemplate('links'); ?>
  </div>
  <?php endif;


  if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
  <div class="category_children">
    <div class="row">
      <!-- <h3> <?php /*echo JTEXT::_('JGLOBAL_SUBCATEGORIES');*/ ?> </h3> -->
      <?php echo $this->loadTemplate('children'); ?>
    </div>
  </div>
  <?php endif;

  if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>  
  <div class="pagination">
    <?php  if ($this->params->def('show_pagination_results', 1)) : ?>
    <p class="counter"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
    <?php endif;
    echo $this->pagination->getPagesLinks(); ?> </div>
  <?php  endif; ?>
</section>
<?php if($this->params->get('show_layout_mode') || $this->params->get('show_filter') || $this->params->get('show_sort')){
$js = '
  ;(function($){
    $(window).load(function(){

      var mixer = mixitup($("#isotopeContainer"), {
        load: {
            sort: "name:desc"
        },
        animation: {
          effects: "fade translateZ(-100px)",
          duration: 250
        },
        selectors: {
          target: ".gallery-item",
        },
        classNames: {
          elementFilter: "#filters",
          elementSort: ".sort"
        }
      });
      
    })
  })(jQuery);
     ';

} ?>
<?php
if($this->params->get('show_sort')){
  $js .= '
  jQuery(document).ready(function($){
    $("#sort .sort").on("click",function(){
      $("#sort .sort").removeClass("selected").removeClass("active");
      $("#sort .sort").closest("li").removeClass("active");
      if($(this).attr("data-order")=="desc"){
        $(this).removeClass("block mixitup-control-active");
        $(this).prev().removeClass("none").addClass("mixitup-control-active");
      }
      else{
        $(this).addClass("none");
        $(this).next().addClass("block mixitup-control-active");
      }
    })
  });

  ;(function($){
    
  })(jQuery);

';
$document->addScriptdeclaration($js);
$document->addStyledeclaration('
  @media screen and (min-width: 1281px) {
    .mix,
    .gap {
        width: calc(100%/'.$this->columns.' - (((5 - 1) * 1rem) / 5));
    }
  }
  ');
}