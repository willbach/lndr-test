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

  if($n<$columns){
    $columns = $n;
  }

        $spanClass = 'span'.floor($params->get('bootstrap_size')/$columns);
        $rows = ceil($n/$columns);

$app    = JFactory::getApplication(); 
$doc = JFactory::getDocument();
$document =& $doc;
$template = $app->getTemplate();

JFactory::getLanguage()->load('com_content', JPATH_SITE, null, true);

if($params->get('masonry')){
  $document->addScript(JURI::base() . 'modules/mod_articles_news_adv/js/masonry.pkgd.min.js');
}

?>
<div class="mod-newsflash-adv mod-newsflash-adv__<?php echo $moduleclass_sfx; ?>" id="module_<?php echo $module->id; ?>">
  <?php if ($params->get('pretext')): ?>
  <div class="pretext">
    <?php echo $params->get('pretext') ?>
  </div>
  <?php endif; ?>
  <?php for ($i = 0, $n; $i < $n; $i ++) :
    $item = $list[$i];
    $class="";
    if($item->featured){
      $class .= " featured";
    }

    if($i == $n-1){
      $class.=" lastItem";
    }
    if($i%2){
      $class.=" even";
    }
    else{
      $class.=" odd";
    }
  ?>
  <article class="item item_num<?php echo $i; ?> item__module  <?php echo $class; ?>" id="item_<?php echo $item->id; ?>">
    <?php require JModuleHelper::getLayoutPath('mod_articles_news_adv', '_about2'); ?>
  </article>
  <?php endfor; ?>

  <?php if($params->get('mod_button') == 1): ?>   
  <div class="mod-newsflash-adv_custom-link">
    <?php 
      $menuLink = $menu->getItem($params->get('custom_link_menu'));

        switch ($params->get('custom_link_route')) 
        {
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