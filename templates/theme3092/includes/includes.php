<?php 
defined('_JEXEC') or die;

JHtml::_('bootstrap.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('formbehavior.chosen', 'select');

$client = new JApplicationWebClient();

include_once ('functions.php');

$app 		= JFactory::getApplication();
$doc 		= JFactory::getDocument();
$user 	= JFactory::getUser();		// Add current user information

$this->language  = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');
$template = $app->getTemplate();
$menu = JMenu::getInstance('site');
$db = JFactory::getDBO();
$query = "SELECT template FROM #__template_styles WHERE client_id = 1 AND home = 1";
$db->setQuery($query);
$adminTemplate = $db->loadResult();

$contentParams = $app->getParams('com_content');
$bodyClass = "body__" . $contentParams->get('pageclass_sfx') . " option-" . $option . " view-" . $view . " task-" . $task . " itemid-" . $itemid;

if($client->mobile){
  $bodyClass .= ' mobile';
  if(isset($_COOKIE['disableMobile'])){
    if($_COOKIE['disableMobile']=='false'){
      $bodyClass .= " mobile_mode";
    }
    else{
      $bodyClass .= " desktop_mode";
    }
  }
  else {
    $bodyClass .= " mobile_mode";
  }
}

$viewport = "";

if($client->mobile && ((isset($_COOKIE['disableMobile']) && $_COOKIE['disableMobile']=='false') || !isset($_COOKIE['disableMobile']))){
	$viewport = "<meta id=\"viewport\" name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
}

// Logo file
if ($this->params->get('logoFile')){
	$logo = $this->params->get('logoFile');
}

//Footer logo file
if ($this->params->get('footerLogoFile')){
	$footerLogo = $this->params->get('footerLogoFile');
}

$ie_warning = "";
if($client->browser == JApplicationWebClient::IE){
	$ie_warning ="
	    <!--[if lt IE 9]>\r\n
	      <div style=\"clear: both; text-align:center; position: relative;\">\r\n
	        <a href=\"http://windows.microsoft.com/en-us/internet-explorer/download-ie\">\r\n
	          <img src=\"templates/" . $this->template . "/images/warning_bar_0000_us.jpg\" border=\"0\" height=\"42\" width=\"820\" alt=\"You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.\" />\r\n
	        </a>\r\n
	      </div>\r\n
	    <![endif]-->\r\n";
}

//Hide module positions 
//By View (article, login, registration, search, profile, reset, remind etc)
$hideByView = false;
switch($view){
	case 'article':
	case 'login':
	case 'search':
	case 'profile':
	case 'registration':
	case 'reset':
	case 'remind':
	case 'form':
		$hideByView = true;
		break;
}

//By Component
$hideByOption = false;
switch($option){
	case 'com_users':
	case 'com_search':
		$hideByOption = true;
		break;
}

//By Component
$hideByEdit = false;
if(($option == 'com_content' && $layout == 'edit')/* || ($option == 'com_config')*/){
	//$hideByEdit = true;
	$hideByView = true;
}

//Get main content width

//Get Left column grid width
if($this->countModules('aside-left') && $hideByOption == false && $view !== 'form' && $view !== 'productdetails'){ 
	$asideLeftWidth = $this->params->get('asideLeftWidth');
} else {
	$asideLeftWidth = "";
}

//Get Right column grid width
if($this->countModules('aside-right') && $hideByOption == false && $view !== 'form' && $view !== 'productdetails'){ 
	$asideRightWidth = $this->params->get('asideRightWidth');
} else {
	$asideRightWidth = "";
}

$mainContentWidth = 12 - ($asideLeftWidth + $asideRightWidth);


// Typography variables
$this->params->get('categoryPageHeading') ? $categoryPageHeading = $this->params->get('categoryPageHeading') : $categoryPageHeading = "";


// Theme Layouts 
$themeLayout = $this->params->get('themeLayout');

switch ($themeLayout) {
	case '0':
		$containerClass = 'container';
		$rowClass = 'row';
		break;

	case '1':
		$containerClass = 'container-fluid';
		$rowClass = 'row-fluid';
		break;
	
	default:
		$containerClass = 'container';
		$rowClass = 'row';
		break;
}

// Year

// Privacy Link
$privacyMenuLink = $menu->getItem($this->params->get('privacy_link_menu'));

$privacy_link_url =  JRoute::_($privacyMenuLink->link.'&Itemid='.$privacyMenuLink->id);
	
// Terms Link	
$termsMenuLink = $menu->getItem($this->params->get('terms_link_menu'));

$terms_link_url =  JRoute::_($termsMenuLink->link.'&Itemid='.$termsMenuLink->id);

$todesktop = '';

if($this->params->get('todesktop') && $client->mobile && !$client->platform == JApplicationWebClient::IPAD){
	$todesktop = "<div class=\"span12\" id=\"to-desktop\">\r\n
  	<a href=\"#\">
  		<span class=\"";
  	if(isset($_COOKIE['disableMobile'])){
  		if($_COOKIE['disableMobile']=='false'){
  			$todesktop .= "to_desktop\">" . $this->params->get('todesktop_text');
  		}
  		else{
  			$todesktop .= "to_mobile\">" . $this->params->get('tomobile_text');
  		}
  	}
  	else{
  		$todesktop .= "to_desktop\">" . $this->params->get('todesktop_text');
  	}
  	$todesktop .= "</span>
  	</a>
</div>";
}
?>