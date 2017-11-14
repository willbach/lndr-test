<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

include ('includes/includes.php');

if($this->params->get('countdown_time')){
  $timestamp = JHtml::_('date', $this->params->get('countdown_time', ''), 'U') - date('Z') - date('U');
}

?>
 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="head" />
    <?php
      echo $viewport;
      if ($themeLayout == 1){
          $doc->addStyleSheet('templates/'.$this->template.'/css/layout.css');
      }
      $doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
      $doc->addStyleSheet('//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic');
      if(isset($timestamp) && $timestamp>0){
        $doc->addScript('templates/'.$this->template.'/js/jquery.countdown.min.js');
      }
    ?>
  </head>
  <body>
    <?php echo $ie_warning; ?>
    <div class="offline_container">
      <div class="container">
        <div class="row">
          <div class="span12">
            <?php if ($app->getCfg('offline_image')) : ?>
            <img src="<?php echo $app->getCfg('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->getCfg('sitename')); ?>" />
            <?php endif; ?>
            <div id="logo">
              <a href="<?php echo JURI::base(); ?>">
                <?php if(isset($logo)) : ?>
                <img src="images/logo_2.png" alt="<?php echo $sitename; ?>">
                <h1><?php echo $sitename; ?></h1>
                <?php else : ?><h1><?php echo $sitename; ?></h1><?php endif; ?>
              </a>
            </div>
            <?php 
            if(isset($timestamp) && $timestamp>0) : ?>
            <div class="countdown">
              <span class="days"><span class="value"></span><?php echo JText::_('TPL_DAYS');?></span>
              <span class="hours"><span class="value"></span><?php echo JText::_('TPL_HOURS');?></span>
              <span class="minutes"><span class="value"></span><?php echo JText::_('TPL_MINUTES');?></span>
              <span class="seconds"><span class="value"></span><?php echo JText::_('TPL_SECONDS');?></span>
            </div>
            <?php endif;
            if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != ''): ?>
            <div class="offline_message"><?php echo $app->getCfg('offline_message'); ?></div>
            <?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', JText::_('JOFFLINE_MESSAGE')) != ''): ?>
            <div class="offline_message">><?php echo JText::_('JOFFLINE_MESSAGE'); ?></div>
            <?php  endif; ?>
            <jdoc:include type="message" />
          </div>
          <jdoc:include type="modules" name="offline-newsletter" style="themeHtml5" />
        </div>
      </div>
    </div>
    <!-- Copyright -->
        <div id="copyright" role="contentinfo">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <div class="copyright span<?php echo $this->params->get('footerWidth'); ?>">
                  <span class="siteName"><?php echo wrap_with_span($sitename); ?></span>
                  <?php if($this->params->get('footerCopy') == 1) echo '<span class="copy">&copy;</span>'; ?>
                  <?php if($this->params->get('footerYear') == 1) echo '<span class="year">'.date('Y').'</span>.'; ?>
                  <?php if($this->params->get('privacyLink') == 1) :?>
                  <a class="privacy_link" rel="license" href="<?php echo $privacy_link_url; ?>"><?php echo $this->params->get('privacy_link_title'); ?></a>
                  <?php endif; ?>
                  <?php if($this->params->get('termsLink') == 1) :?>
                  <a class="terms_link" href="<?php echo $terms_link_url; ?>"><?php echo $this->params->get('terms_link_title'); ?></a>
                  <?php endif; ?>
                </div>
                <?php echo $todesktop; ?>
                <!-- {%FOOTER_LINK} -->
              </div>
            </div>
          </div>
        </div>
    <?php if ($this->countModules('fixed-sidebar-left')): ?>
    <jdoc:include type="modules" name="fixed-sidebar-left" style="none" />
    <?php endif; ?>
    <?php if ($this->countModules('fixed-sidebar-right')): ?>
    <div id="fixed-sidebar-right">
      <jdoc:include type="modules" name="fixed-sidebar-right" style="sidebar" />
    </div>
    <?php endif; ?>
    <?php if($timestamp>0){ ?>
    <script>
      jQuery(function($){
        $(".countdown .days .value")
          .countdown("<?php echo JHtml::_('date', $this->params->get('countdown_time', ''), 'Y/m/d H:i:s'); ?>", function(event) {
          $(this).text(
            event.strftime('%D')
          );
        });
        $(".countdown .hours .value")
          .countdown("<?php echo JHtml::_('date', $this->params->get('countdown_time', ''), 'Y/m/d H:i:s'); ?>", function(event) {
          $(this).text(
            event.strftime('%H')
          );
        });
        $(".countdown .minutes .value")
          .countdown("<?php echo JHtml::_('date', $this->params->get('countdown_time', ''), 'Y/m/d H:i:s'); ?>", function(event) {
          $(this).text(
            event.strftime('%M')
          );
        });
        $(".countdown .seconds .value")
          .countdown("<?php echo JHtml::_('date', $this->params->get('countdown_time', ''), 'Y/m/d H:i:s'); ?>", function(event) {
          $(this).text(
            event.strftime('%S')
          );
        });
      })
    </script>
    <?php } ?>
  </body>
</html>