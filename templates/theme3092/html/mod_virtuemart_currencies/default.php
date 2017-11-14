<?php // no direct access
defined('_JEXEC') or die('Restricted access');

function getVendorAcceptedCurrenciesListCustom($vendorId = 0){

	static $currencies = array();
	if($vendorId===0){
		$multix = Vmconfig::get('multix','none');
		if(strpos($multix,'payment')!==FALSE){
			if (!class_exists('VirtueMartModelVendor'))
				require(VMPATH_ADMIN . '/models/vendor.php');
			$vendorId = VirtueMartModelVendor::getLoggedVendor();

		} else {
			$vendorId = 1;
		}
	}
	if(!isset($currencies[$vendorId])){
		$db = JFactory::getDbo();
		$q = 'SELECT `vendor_accepted_currencies`, `vendor_currency` FROM `#__virtuemart_vendors` WHERE `virtuemart_vendor_id`=' . $vendorId;
		$db->setQuery($q);
		$vendor_currency = $db->loadAssoc();
		if (!$vendor_currency['vendor_accepted_currencies']) {
			$vendor_currency['vendor_accepted_currencies'] = $vendor_currency['vendor_currency'];
			vmWarn('No accepted currencies defined');
			if(empty($vendor_currency['vendor_accepted_currencies'])) {
				$uri = JFactory::getURI();
				$link = $uri->root().'administrator/index.php?option=com_virtuemart&view=user&task=editshop';
				vmWarn(vmText::sprintf('COM_VIRTUEMART_CONF_WARN_NO_CURRENCY_DEFINED','<a href="'.$link.'">'.$link.'</a>'));
				$currencies[$vendorId] = false;
				return $currencies[$vendorId];
			}
		}
		$q = 'SELECT `virtuemart_currency_id`,CONCAT_WS(" ",`currency_symbol`,`currency_name`) as currency_txt
				FROM `#__virtuemart_currencies` WHERE `virtuemart_currency_id` IN ('.$vendor_currency['vendor_accepted_currencies'].')';
		if($vendorId!=1){
			$q .= ' AND (`virtuemart_vendor_id` = "'.$vendorId.'" OR `shared`="1")';
		}
		$q .= '	AND published = "1"
				ORDER BY `ordering`,`currency_name`';

		$db->setQuery($q);
		$currencies[$vendorId] = $db->loadObjectList();
	}

	return $currencies[$vendorId];
}

$currencies_prototype = getVendorAcceptedCurrenciesListCustom($vendorId);
$currencies = array();
foreach($currencies_prototype as $currency){
	$currencies[$currency->virtuemart_currency_id] = $currency->currency_txt;
}
?>

<!-- Currency Selector Module -->
<span class="pretext"><?php echo $text_before; ?></span>
<span class="currency_wrapper">
<span class="active_currency">
<?php echo $currencies[$virtuemart_currency_id]; ?>
<i class="fa fa-angle-down"></i>
</span>
<form action="<?php echo vmURI::getCleanUrl() ?>" method="post">
<ul>
	<?php 
	foreach($currencies as $key => $currency){
		$key == $virtuemart_currency_id ? $class = 'class="active"': $class = '';
		echo '<li><button name="virtuemart_currency_id" '.$class.' value="'.$key.'" type="submit">'.$currency.'</button></li>';
	}
	 ?>
</ul>
</form>
</span>