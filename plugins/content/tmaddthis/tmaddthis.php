<?php 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgContentTmAddThis extends JPlugin{

  public function onContentAfterDisplay($context, &$article, &$params)
  {
    $app = JFactory::getApplication();
    $view = $app->input->getCmd('view', '');
    $layout   = $app->input->getCmd('layout', '');
    $scope =  $app->scope;

    if(($view == 'article' && $scope == 'com_content' && $layout !== 'edit' && !in_array($article->catid, $this->params->get("addthis_categories"))) || $view == 'productdetails')
    {
      $html = '
<div class="addthis_sharing_toolbox"></div>
<div class="addthis_inline_share_toolbox"></div>';

    $html .= '<script type="text/javascript">
    var addthis_config =
{
   pubid: "'.$this->params->get("addthis_id").'"
}
    </script>';
      $html .= '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid='.$this->params->get("addthis_id").'"></script>';

      return $html;
    }
  return false;
  }  
}
