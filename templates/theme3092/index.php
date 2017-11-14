<?php
defined('_JEXEC') or die;
include_once ('includes/includes.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <?php
      echo $viewport;
      if ($themeLayout == 1){
          $doc->addStyleSheet('templates/'.$this->template.'/css/layout.css');
      }
      if ($hideByEdit == false){
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox-buttons.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/jquery.fancybox-thumbs.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/general-ui.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/material-design.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/material-icons.css');
        $doc->addStyleSheet('//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic');
        $doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
        if ($this->direction == 'rtl'){
          $doc->addStyleSheet('templates/' . $this->template .'/css/bootstrap-rtl.css');
        }
      }
      else{
        $doc->addStyleSheet('administrator/templates/'.$adminTemplate.'/css/template.css');
        $doc->addStyleSheet('templates/'.$this->template.'/css/edit.css');
      }
      if ($option == 'com_tmbox') {
        $vmclass = 'option-com_virtuemart ';
      }else {
        $vmclass = '';
      }
      
      
    ?>
    <jdoc:include type="head" />
  </head>
  <body class=" <?php echo $vmclass.$bodyClass; ?>">
    <?php echo $ie_warning; ?>
    <jdoc:include type="modules" name="page-loader" style="none"/>
    <!-- Body -->
    <div id="wrapper">
      <div class="wrapper-inner">
        <?php if ($this->countModules('sup-top') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Sup Top -->
        <div id="sup-top">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="sup-top" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($hideByEdit == false): ?>
        <!-- Top -->
        <div id="top">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <!-- Logo -->
                <div id="logo" class="span<?php echo $this->params->get('logoBlockWidth'); ?>">
                  <a href="<?php echo JURI::base(); ?>">
                    <?php if(isset($logo)) : ?>
                    <img src="<?php echo $logo;?>" alt="<?php echo $sitename; ?>">
                    <h1><?php echo $sitename; ?></h1>
                    <?php else : ?><h1><?php echo $sitename; ?></h1><?php endif; ?>
                  </a>
                </div>
                <jdoc:include type="modules" name="top" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <!-- Header -->
        <?php if ($this->countModules('header') && $hideByView == false && $hideByEdit == false): ?>
        <div id="header">
          <jdoc:include type="modules" name="header" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('map') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Map -->
        <div id="map">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="map" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('navigation') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Navigation -->
        <div id="navigation" role="navigation">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="navigation" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('showcase') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Showcase -->
        <div id="showcase">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                  <jdoc:include type="modules" name="showcase" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('feature') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Feature -->
        <div id="feature">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                  <jdoc:include type="modules" name="feature" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('maintop') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Maintop -->
        <div id="maintop">
          <jdoc:include type="modules" name="maintop" style="html5nosize" />
        </div>
        <?php endif; ?>
        <!-- Main Content row -->
        <div id="content">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <?php if ($this->countModules('breadcrumbs') && $hideByEdit == false): ?>
              <!-- Breadcrumbs -->
              <div id="breadcrumbs">
                <div id="breadcrumbs-row" class="<?php echo $rowClass; ?>">
                  <jdoc:include type="modules" name="breadcrumbs" style="themeHtml5" />
                </div>
              </div>
              <?php endif; ?>
              <div class="content-inner <?php echo $rowClass; ?>">   
                <?php if ($this->countModules('aside-left') && ($hideByOption) == false && $view !== 'form' && $view !== 'productdetails' && $hideByEdit == false): ?>     
                <!-- Left sidebar -->
                <div id="aside-left" class="span<?php echo $asideLeftWidth; ?>">
                  <aside role="complementary">
                    <jdoc:include type="modules" name="aside-left" style="html5nosize" />
                  </aside>
                </div>
                <?php endif; ?>       
                <div id="component" class="span<?php echo $mainContentWidth; ?>">
                  <main role="main">    
                    <?php if ($this->countModules('content-top') && $hideByView == false && $hideByEdit == false): ?> 
                    <!-- Content-top -->
                    <div id="content-top">
                      <div id="content-top-row" class="<?php echo $rowClass; ?>">
                        <jdoc:include type="modules" name="content-top" style="themeHtml5" />
                      </div>
                    </div>
                    <?php endif; ?>
                    <div id="main_component">  
                    <jdoc:include type="message" />     
                    <jdoc:include type="component" />   
                    <?php if ($this->countModules('content-bottom') && $hideByView == false && $hideByEdit == false): ?>
                    
                    <!-- Content-bottom -->
                    <div id="content-bottom">
                      <div id="content-top-row" class="<?php echo $rowClass; ?>">
                          <jdoc:include type="modules" name="content-bottom" style="themeHtml5" />
                      </div>
                    </div>
                    <?php endif; ?>
                    </div>
                  </main>
                </div>        
                <?php if ($this->countModules('aside-right') && ($hideByOption) == false && $view !== 'form' && $view !== 'productdetails' && $hideByEdit == false): ?>
                <!-- Right sidebar -->
                <div id="aside-right" class="span<?php echo $asideRightWidth; ?>">
                  <aside role="complementary">
                    <jdoc:include type="modules" name="aside-right" style="html5nosize" />
                  </aside>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php if ($this->countModules('video') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Video -->
        <div id="video">
          <jdoc:include type="modules" name="video" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom -->
        <div id="mainbottom">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-2') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom 2 -->
        <div id="mainbottom-2">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-2" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-3') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom 3 -->
        <div id="mainbottom-3">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-3" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-4') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom 4 -->
        <div id="mainbottom-4">
          <jdoc:include type="modules" name="mainbottom-4" style="html5nosize" />
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('mainbottom-5') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Mainbottom 5 -->
        <div id="mainbottom-5">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="mainbottom-5" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('bottom') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Bottom -->
        <div id="bottom">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="bottom" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('footer') && $hideByView == false && $hideByEdit == false): ?>
        <!-- Footer -->
        <div id="footer">
          <div class="row-container">
            <div class="<?php echo $containerClass; ?>">
              <div class="<?php echo $rowClass; ?>">
                <jdoc:include type="modules" name="footer" style="themeHtml5" />
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php if ($hideByEdit == false): ?>
      <div id="footer-wrapper">
        <div class="footer-wrapper-inner">    
          <!-- Copyright -->
          <div id="copyright" role="contentinfo">
            <div class="row-container">
              <div class="<?php echo $containerClass; ?>">
                <div class="<?php echo $rowClass; ?>">
                  <jdoc:include type="modules" name="copyright" style="themeHtml5" />
                  <div class="copyright span<?php echo $this->params->get('footerWidth'); ?>">
                    <?php if ($option == 'com_virtuemart') {
                      echo '<span class="copyright_text">'.JText::_('TPL_COPYRIGHT').'</span>';
                      if($this->params->get('footerCopy') == 1) echo ' <span class="copy">&copy;</span>';
                      if($this->params->get('footerYear') == 1) echo '<span class="year">'.date('Y').'</span>';
                    } ?>
                    <?php if($this->params->get('footerLogo') == 1) : ?>
                    <!-- Footer Logo -->
                    <a class="footer_logo" href="<?php echo $this->baseurl; ?>"><img src="<?php echo $footerLogo;?>" alt="<?php echo $sitename; ?>" /></a>
                    <?php else : ?>
                    <span class="siteName"><?php echo wrap_with_span($sitename); ?></span>
                    <?php endif; ?>
    					      <?php if ($option != 'com_virtuemart') {
                      if($this->params->get('footerCopy') == 1) echo '<span class="copy">&copy;</span>'; ?>
      					      <?php if($this->params->get('footerYear') == 1) echo '<span class="year">'.date('Y').'</span>.';
                    } ?>
                    <?php if($this->params->get('privacyLink') == 1) :?>
                    <a class="privacy_link" rel="license" href="<?php echo $privacy_link_url; ?>"><?php echo $this->params->get('privacy_link_title'); ?></a>
      					    <?php endif; ?>
                    <?php if($this->params->get('termsLink') == 1) :?>
                    <a class="terms_link" href="<?php echo $terms_link_url; ?>"><?php echo $this->params->get('terms_link_title'); ?></a>
      					    <?php endif; ?>
                  </div>
                  <?php echo $todesktop; ?>
                  More Design Studio Templates at <a  rel='nofollow' href='http://www.templatemonster.com/category.php?category=521&type=24' target='_blank'>TemplateMonster.com</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if($this->params->get('totop')): ?>
      <div id="back-top">
        <a href="#"><span></span><?php echo $this->params->get('totop_text') ?></a>
      </div>
      <?php endif; ?>
      <?php if ($this->countModules('modal')): ?>
      <div id="modal" class="modal hide fade loginPopup">
        <div class="modal-hide"></div>
        <div class="modal_wrapper">
          <button type="button" class="close modalClose">×</button>
          <jdoc:include type="modules" name="modal" style="modal" />
        </div>
      </div>
      <?php endif; ?>
      <?php if ($this->countModules('fixed-sidebar-left')): ?>
      <jdoc:include type="modules" name="fixed-sidebar-left" style="none" />
      <?php endif; ?>
      <?php if ($this->countModules('fixed-sidebar-right')): ?>
      <div id="fixed-sidebar-right">
        <jdoc:include type="modules" name="fixed-sidebar-right" style="sidebar" />
      </div>
      <?php endif; ?>
      <jdoc:include type="modules" name="debug" style="none"/>
    </div>
    <?php if($client->platform == JApplicationWebClient::IPHONE || $client->platform == JApplicationWebClient::IPAD){
      if(isset($_COOKIE['disableMobile'])){ ?>
        <?php if($_COOKIE['disableMobile']=='false'){ ?>
          <script src="<?php echo 'templates/'.$this->template.'/js/ios-orientationchange-fix.js'; ?>"></script>
        <?php }
      } else { ?>
        <script src="<?php echo 'templates/'.$this->template.'/js/ios-orientationchange-fix.js'; ?>"></script>
      <?php }
    }
    if($client->mobile){ ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/desktop-mobile.js'; ?>"></script>
    <?php }
    if($this->params->get('blackandwhite')): ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.BlackAndWhite.min.js'; ?>"></script>
    <script>
      ;(function($, undefined) {
      $.fn.BlackAndWhite_init = function () {
        var selector = $(this);
        selector.find('img').not(".slide-img").parent().BlackAndWhite({
          invertHoverEffect: ".$this->params->get('invertHoverEffect').",
          intensity: 1,
          responsive: true,
          speed: {
              fadeIn: ".$this->params->get('fadeIn').",
              fadeOut: ".$this->params->get('fadeOut')." 
          }
        });
      }
      })(jQuery);
      jQuery(window).load(function($){
        jQuery('.item_img a').find('img').not('.lazy').parent().BlackAndWhite_init();
      });
    </script>
    <?php endif; ?>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.rd-parallax.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox.pack.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-buttons.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-media.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.fancybox-thumbs.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.pep.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/jquery.vide.min.js'; ?>"></script>
    <script src="<?php echo 'templates/'.$this->template.'/js/scripts.js'; ?>"></script>
    <?php endif; ?>
    <div class="modalTmbox"> </div>
  </body>
</html>