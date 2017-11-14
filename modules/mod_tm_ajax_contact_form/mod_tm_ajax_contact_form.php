<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 2.1.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$document = JFactory::getDocument();

$document->addStylesheet('modules/mod_tm_ajax_contact_form/css/style.css');

$labels_pos = $params->get('labels_pos', '');
$success = $params->get('success_notify', '');
$error = $params->get('failure_notify', '');
$captcha_error = $params->get('captcha_failure_notify', '');

JHtml::_('jquery.framework', true, null, true);
$document->addScript('modules/mod_tm_ajax_contact_form/js/jquery.validate.min.js');
$document->addScript('modules/mod_tm_ajax_contact_form/js/additional-methods.min.js');
$document->addScript('modules/mod_tm_ajax_contact_form/js/autosize.min.js');
$document->addScript('modules/mod_tm_ajax_contact_form/js/moment.js');
$document->addScript('modules/mod_tm_ajax_contact_form/js/bootstrap-datetimepicker.min.js');
$document->addScriptdeclaration(';(function($){$(document).ready(function(){autosize($("textarea"))})})(jQuery);');
$captcha = ($params->get('captcha_req', false) && JPluginHelper::isEnabled('captcha', 'recaptcha')) ? true : false;
if($captcha) {
	$document->addScript('modules/mod_tm_ajax_contact_form/js/ajaxcaptcha.js');
}
$document->addScript('modules/mod_tm_ajax_contact_form/js/ajaxsendmail.js');

require JModuleHelper::getLayoutPath('mod_tm_ajax_contact_form', $params->get('layout', 'default'));

?>