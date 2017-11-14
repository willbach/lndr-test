<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-3/Modules/JoomImages/trunk/tmpl/default.php $
// $Id: default.php 4120 2013-02-28 21:51:03Z erftralle $
defined('_JEXEC') or die('Restricted access');
JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addScript(JURI::base().'templates/'.$template.'/js/jquery.mixitup.min.js');

$client = new JApplicationWebClient();

// Defining sectiontableentry class
$sectiontableentry = "jg_row";
$secnr = 1;
$count_img_per_row = 0;

$csstag = $joomimgObj->getConfig("csstag");
$countobjects = count($imgobjects);

$ambit = new JoomAmbit();

$allcats = $ambit->getCategoryStructure();

$catids = array();

foreach($imgobjects as $obj){
  $catids[] = $obj->catid;
}

$catids = array_unique($catids);

$cats = array();

$key = 0;
foreach($allcats as $cat){
  if(in_array($cat->cid, $catids)){
    $cats[$key] = new stdClass;
    $cats[$key]->cid = $cat->cid;
    $cats[$key]->name = $cat->name;
    $key++;
  }
}

// Global module div
?>
<div class="<?php echo $csstag; ?>main">
<?php if($joomimgObj->getConfig('scrollthis')): ?>
  <marquee behavior="scroll" direction="<?php echo $joomimgObj->getConfig('scrolldirection'); ?>" loop="infinite"
  height="<?php echo $joomimgObj->getConfig('scrollheight'); ?>" width="<?php echo $joomimgObj->getConfig('scrollwidth'); ?>"
  scrollamount="<?php echo $joomimgObj->getConfig('scrollamount'); ?>" scrolldelay="<?php echo $joomimgObj->getConfig('scrolldelay'); ?>"
  <?php echo $joomimgObj->scrollmousecode; ?> class="<?php echo $joomimgObj->getConfig('csstag');?>scroll">
<?php
endif;
if($joomimgObj->getConfig('pagination') && $joomimgObj->getConfig('paginationpos') == 0):
  $paglinks = ceil($countobjects / $joomimgObj->getConfig('paginationct')); ?>
  <div class="<?php echo $csstag."pagnavi";?>">
    <span id="<?php echo $csstag."paglink_1"?>" class="<?php echo $csstag."paglinkactive";?>">1</span>
<?php for($linkct = 2; $linkct <= $paglinks; $linkct++ ): ?>
    <span id="<?php echo $csstag."paglink_".$linkct?>" class="<?php echo $csstag."paglink";?>"><?php echo $linkct;?></span>
<?php endfor; ?>
  </div>
<?php endif;
$imgct=0;
if($countobjects > 0): ?>
<div class="gallery row-fluid cols-<?php echo $joomimgObj->getConfig("img_per_row"); ?>">
  <?php foreach($imgobjects as $obj):
    $imgct++;
    $link_arr = explode('" ', $obj->link);
    $obj->link = $link_arr[0];
    if ($joomimgObj->getConfig('pagination')
        && $imgct > $joomimgObj->getConfig('paginationct')):
      break;
    endif; ?>
    <div class="span12 gallery_<?php echo $obj->catid;?> gallery-item">
      <div class="gallery-item__container">
      <a href="<?php echo $obj->link; ?>" data-fancybox="fancybox" data-fancybox-group="joomgallerymodji" data-fancybox-type="image">
        <?php echo '<img src="'.$obj->imagesource.'" alt="">'; ?>
      </a>
      </div>
    </div>
<?php endforeach; ?>
</div>
<?php
elseif($joomimgObj->getConfig('show_empty_message')):
    echo JText::_('JINO_PICTURES_AVAILABLE');
  endif;
if($joomimgObj->getConfig('scrollthis') == 1): ?>
</marquee>
<?php endif;
// Pagination if active
// Output all image elements in hidden container
// and the links for pagination
if($joomimgObj->getConfig('pagination')):
  if($joomimgObj->getConfig('paginationpos') == 1):
    $paglinks = ceil($countobjects / $joomimgObj->getConfig('paginationct')); ?>
  <div class="<?php echo $csstag."pagnavi";?>">
    <span id="<?php echo $csstag."paglink_1"?>" class="<?php echo $csstag."paglinkactive";?>">1</span>
<?php for($linkct = 2; $linkct <= $paglinks; $linkct++ ): ?>
    <span id="<?php echo $csstag."paglink_".$linkct?>" class="<?php echo $csstag."paglink";?>"><?php echo $linkct;?></span>
<?php  endfor; ?>
  </div>
<?php endif; ?>
  <div id="<?php echo $csstag."pagelems";?>" style="display:none">
<?php
  // Output the html code of all image elements
  $imgct=0;
  foreach($imgobjects as $obj):
    $imgct++; ?>
    <div id="<?php echo $csstag."pagelem_".$imgct;?>" class="<?php echo $csstag."pagelem";?>">
<?php echo $obj->pagelem; ?>
    </div>
<?php endforeach; ?>
  </div>
<?php endif; ?>
</div>
<script>
  jQuery(function($){
    var click = true;
      $('a[data-fancybox="fancybox"]').fancybox({
        padding: 0,
        margin: 0,
        loop: true,
        openSpeed:500,
        closeSpeed:500,
        nextSpeed:500,
        prevSpeed:500,
        afterLoad : function (){
          <?php if($client->mobile){ ?>
          $('body').swipe({
            swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
              click = false;
              if(direction == 'left'){
                $.fancybox.next()
              }
              if(direction == 'right'){
                $.fancybox.prev()
              }
              setTimeout(function(){
                click = true;
              },100)
            }
          })*
          <?php } ?>
          $('.fancybox-inner').click(function(){
            if(click == true){
              $('body').toggleClass('fancybox-full');
            }
          })
        },
        beforeShow: function() {
          $('body').addClass('fancybox-lock');
        },
        afterClose : function() {
          $('body').removeClass('fancybox-lock');
          <?php if($client->mobile){ ?>
          $('body').swipe('destroy')
          <?php } ?>
        },
        tpl : {
          image    : '<div class="fancybox-image" style="background-image: url(\'{href}\');"></div>'
        },
        helpers: {
          title : null,
          thumbs: {
            height: 50,
            width: 80
          },
          overlay : {
            css : {
              'background' : '#191919'
            }
          }
        }
      });
}); 
</script>