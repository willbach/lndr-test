<?php
/**
*
* Modify user form view
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 8768 2015-03-02 12:22:14Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);

// Implement Joomla's form validation
JHtml::_('behavior.formvalidation');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/'); // VM_THEMEURL
?>
<div id="com_virtuemart">
<?php vmJsApi::vmValidator(); ?>
<?php
$url = vmURI::getCleanUrl();
$cancelUrl = $url.'?task=cancel';
if(!JFactory::getConfig()->get('sef',0)){
	$cancelUrl = $url.'&task=cancel';
}
?>
<<?php echo $template->params->get('categoryPageHeading'); ?>><?php echo $this->page_title ?></<?php echo $template->params->get('categoryPageHeading'); ?>>

<?php if($this->userDetails->virtuemart_user_id==0) {
	echo '<h4 class="reg">'.vmText::_('COM_VIRTUEMART_YOUR_ACCOUNT_REG').'</h4>';
}?>
<form method="post" id="adminForm" name="userForm" action="<?php echo $url ?>" class="form-validate">
<?php // Loading Templates in Tabs
if($this->userDetails->virtuemart_user_id!=0) {
    $tabarray = array();

    $tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';

	if($this->userDetails->user_is_vendor){
		if(!empty($this->add_product_link)) {
			//echo $this->manage_link;
			//echo $this->add_product_link;
		}
		//$tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';
	}

    //$tabarray['user'] = 'COM_VIRTUEMART_USER_FORM_TAB_GENERALINFO';
    if (!empty($this->shipto)) {
	    //$tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
    }
    if (($_ordcnt = count($this->orderlist)) > 0) {
	    //$tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
    }

    shopFunctionsF::buildTabs ( $this, $tabarray);

 } else {
 	echo $this->captcha;
    echo $this->loadTemplate ( 'shopper' );

 }

// captcha addition
// end of captcha addition
?>
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="controller" value="user" />
<?php echo JHtml::_( 'form.token' ); ?>

<?php if($this->userDetails->user_is_vendor){ ?>
    <div class="buttonBar-right">
	<button class="button btn" type="reset" onclick="window.location.href='<?php echo $cancelUrl ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
	<button class="button btn" type="submit" onclick="javascript:return myValidator(userForm, true);" ><?php echo $this->button_lbl ?></button>
	&nbsp;
</div>
    <?php } ?>
</form>

</div>