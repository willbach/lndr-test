<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc->addStylesheet('templates/'.$template.'/css/introjs.min.css');
$doc->addScript('templates/'.$template.'/js/intro.js');
$doc->addScriptdeclaration('function startIntro(){
	var intro = introJs();
        intro.setOptions({
            steps: [
				{ 
					intro: "<b>Welcome to the Tour</b><br><br>Simply click through the Elements and see the functions behind and if needed the name of the Module Position<br><br><b>Enjoy Wegy!</b>"
				},
				{
					element: "#logo",
					intro: "Logo Area. It can be configurated in Template parameters."
				},
				{
					element: "#icemegamenu",
					intro: "Mega Menu Area. Also the whole Menu can be configurated in this Module.<br /><br />Moduleposition: <b>top</b>"
				},
				{
					element: ".icemega_modulewrap.top_search",
					intro: "Main Search Area. This is the menu item in Mega Menu."
				},
				{
					element: "#breadcrumbs",
					intro: "<b>Breadcrumbs</b>"
				},
				{
					element: "#aside-left > aside",
					intro: "Several Modules can be placed in the Sidebar.<br /><br />Moduleposition: <b>aside-left</b>",
					position: "right"
				},
				{
					element: "#aside-right > aside",
					intro: "Several Modules can be placed in the Sidebar.<br /><br />Moduleposition: <b>aside-right</b>",
					position: "left"
				},
				{
					element: "#content-top",
					intro: "This is a Moduleposition over the Main Component.<br /><br />Moduleposition: <b>content-top</b>",
					position: "bottom"
				},
				{
					element: "#main_component",
					intro: "<b>This is the Main Component Area of the Wegy Joomla Template</b>",
					position: "bottom"
				},
				{
					element: "#content-bottom",
					intro: "This is a Moduleposition under the Main Component.<br /><br />Moduleposition: <b>content-bottom</b>",
					position: "top"
				},
				{
					element: ".copyright",
					intro: "The Copyright can be controlled over the Template Options.",
					position: "top"
				},
				{
					element: ".social-icons_home3",
					intro: "Easy and lightweight Joomla Module to display the Social links.<br /><br />Moduleposition: <b>copyright</b>",
					position: "top"
				}
            ]
        });
        intro.start();
    }
    window.onload = function(){
	    startIntro();
	    document.querySelector("#show-intro").onclick = function(){
	      	startIntro();
	    }
    }');
?>
<div class="mod-custom mod-custom__<?php echo $moduleclass_sfx ?>" <?php if ($params->get('backgroundimage')): ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?>>
	<?php echo $module->content;?>
</div>