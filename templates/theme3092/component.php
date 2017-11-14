<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
include_once ('includes/includes.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="head" />
    <?php if($option == 'com_media'){
    $doc->addStyleSheet('media/jui/css/bootstrap.min.css');
		$doc->addStyleSheet('administrator/templates/'.$adminTemplate.'/css/template.css');
		} else{
		$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
		$colorScheme = $this->params->get('color_scheme', 'color_scheme_1');
		$doc->addStyleSheet('templates/'.$this->template.'/color_schemes/css/'.$colorScheme.'.css');
	} ?>
  </head>
  <body class="contentpane modal">
    <jdoc:include type="message" />
    <jdoc:include type="component" />
  </body>
</html>