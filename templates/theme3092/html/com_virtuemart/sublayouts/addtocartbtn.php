<?php
/**
 *
 * loads the add to cart button
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @version $Id: addtocartbtn.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');

if($viewData['orderable']) {
	echo '<a type="submit" name="addtocart" class="addtocart-button btn btn-primary" value="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" title="'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'"><i class="material-icons-shopping_cart "></i><span>'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'</span></a>';
} else {
	echo '<span name="addtocart" class="addtocart-button-disabled btn" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="material-icons-shopping_cart "></i><span>'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</span></span>';
}