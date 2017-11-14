<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

$n = count($list);

$columns = $n < $columns ? $n : $columns;

$rows = ceil($n/$columns);

$class1 = 'span'.floor($params->get('bootstrap_size')/$columns);

$document = JFactory::getDocument();

JFactory::getLanguage()->load('com_content', JPATH_SITE, null, true);

if($params->get('masonry')) $document->addScript('modules/mod_articles_news_adv/js/masonry.pkgd.min.js');

?>
<div class="mod-newsflash-adv mod-newsflash-adv__<?php echo $moduleclass_sfx; ?> cols-<?php echo $columns; ?>" id="module_<?php echo $module->id; ?>">
  <?php if ($params->get('pretext')): ?>
  <div class="pretext">
    <?php echo $params->get('pretext') ?>
  </div>
  <?php endif;
  if($params->get('masonry')) : ?>
  <div class="masonry row-fluid" id="mod-newsflash-adv__masonry<?php echo $module->id; ?>">
  <?php else: ?>
  <div class="row-fluid">
  <div class="<?php echo $class1; ?>">
  <?php endif;
  foreach ($list as $key => $item){
    $class = '';
    if($item->featured){
      $class .= " featured";
    }
    if($key == $n-1){
      $class .= " lastItem";
    }
    if($key % 2){
      $class .= " item_even";
    }
    else{
      $class .= " item_odd";
    }
    if($key !== 0 && $key % $rows == 0 && !$params->get('masonry')){
      echo '</div><div class="'.$class1.'">';
    }
  ?>  
  <article class="<?php echo $class; ?> item item_num<?php echo $key; ?> item__module" id="item_<?php echo $item->id; ?>">
    <?php require JModuleHelper::getLayoutPath('mod_articles_news_adv', '_features-2'); ?>
  </article>
  <?php } ?>
  </div>
  </div> 
  <div class="clearfix"></div>
  <?php if($params->get('mod_button') == 1): ?>   
  <div class="mod-newsflash-adv_custom-link">
    <?php $menuLink = $menu->getItem($params->get('custom_link_menu'));
        switch ($params->get('custom_link_route')){
          case 0:
            $link_url = $params->get('custom_link_url');
            break;
          case 1:
            $link_url = JRoute::_($menuLink->link.'&Itemid='.$menuLink->id);
            break;            
          default:
            $link_url = "#";
            break;
        }
        echo '<a class="btn btn-info" href="'. $link_url .'">'. $params->get('custom_link_title') .'</a>';
    ?>
  </div>
  <?php endif; ?>
</div>
<?php if($params->get('masonry')) : ?>
<script>
  jQuery(function($){
      $(window).load(function(){
        var $container = $('#mod-newsflash-adv__masonry<?php echo $module->id; ?>');
        $container.masonry({
          itemSelector: '.item'
        });
      });
  }); 
</script>
<?php endif; ?>