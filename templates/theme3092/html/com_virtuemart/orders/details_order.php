<?php
/**
 *
 * Order detail view
 *
 * @package	VirtueMart
 * @subpackage Orders
 * @author Oscar van Eijk, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: details_order.php 7499 2013-12-18 15:11:51Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);

?>

<table class="order_details">
    <tr>
	<td   class="orders-key"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_NUMBER') ?></td>
	<td class="orders-key" align="left">
	    <?php echo $this->orderdetails['details']['BT']->order_number; ?>
	</td>
    </tr>
    <tr>
	<td class=""><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_DATE') ?></td>
	<td align="left"><?php echo vmJsApi::date($this->orderdetails['details']['BT']->created_on, 'LC4', true); ?></td>
    </tr>
    <tr>
	<td class=""><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS') ?></td>
	<td align="left"><?php echo $this->orderstatuses[$this->orderdetails['details']['BT']->order_status]; ?></td>
    </tr>
    <tr>
	<td class=""><?php echo vmText::_('COM_VIRTUEMART_LAST_UPDATED') ?></td>
	<td align="left"><?php echo vmJsApi::date($this->orderdetails['details']['BT']->modified_on, 'LC4', true); ?></td>
    </tr>
    <tr>
	<td class=""><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPMENT_LBL') ?></td>
	<td align="left"><?php
	    echo $this->shipment_name;
	    ?></td>
    </tr>
    <tr>
	<td class=""><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT_LBL') ?></td>
	<td align="left"><?php echo $this->payment_name; ?>
	</td>
    </tr>

	 <tr>
    <td><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_CUSTOMER_NOTE') ?></td>
    <td valign="top" align="left" width="50%"><?php echo $this->orderdetails['details']['BT']->customer_note; ?></td>
</tr>

     <tr>
	<td class="orders-key"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></td>
	<td class="orders-key" align="left"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_total, $this->user_currency_id); ?></td>
    </tr>
    </table>
    <div class="row-fluid">
    <div class="span6">
    <<?php echo $template->params->get('categoryItemHeading'); ?>><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_BILL_TO_LBL') ?></<?php echo $template->params->get('categoryItemHeading'); ?>>
	    <table class="bill_addr"><?php
	    foreach ($this->userfields['fields'] as $field) {
		if (!empty($field['value'])) {
		    echo '<tr><td class="key">' . $field['title'] . '</td>'
		    . '<td>' . $field['value'] . '</td></tr>';
		}
	    }
	    ?>
	    </table>
	    </div>
	    <div class="span6">
	<<?php echo $template->params->get('categoryItemHeading'); ?>>
	    <?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SHIP_TO_LBL') ?></<?php echo $template->params->get('categoryItemHeading'); ?>>
	    <table class="ship_addr"><?php
	    foreach ($this->shipmentfields['fields'] as $field) {
		if (!empty($field['value'])) {
		    echo '<tr><td class="key">' . $field['title'] . '</td>'
		    . '<td>' . $field['value'] . '</td></tr>';
		}
	    }
	    ?></table>
	    </div>
	    </div>
