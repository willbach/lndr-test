<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Class Module Helper
 * @author olejenya
 */
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
// Load the language file of com_virtuemart.
JFactory::getLanguage()->load('com_virtuemart');
if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'calculationh.php');
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'models'.DS.'vendor.php');
if (!class_exists( 'VmImage' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'image.php');
if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');
if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'cart.php');
if (!class_exists( 'VirtueMartModelProduct' )){
   JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
if (!class_exists( 'VirtueMartModelRatings' )){
 	JLoader::import( 'ratings', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
class modTmboxHelper
{

	/**
	 * getData method
	 * @param $params
	 * @return array
	 */
	static function getData( $params )
	{
		$ratingModel = VmModel::getModel('ratings');
		$product_model = VmModel::getModel('product');
		$mainframe = JFactory::getApplication();
		$compareIds = $mainframe->getUserState("com_tmbox.site.compareIds", array());
		if (isset($compareIds));
		if (!empty($compareIds)){
		$products = $compareIds;
			//unset($_SESSION['ids']);

		$prods = $product_model->getProducts($products);
		$product_model->addImages($prods,1);
		$currency = CurrencyDisplay::getInstance();
		}
		return $prods;

	}
	static function getData2( $params )
	{
		$user =& JFactory::getUser();
		$ratingModel = VmModel::getModel('ratings');
		$product_model = VmModel::getModel('product');
		if ($user->guest) {
			$mainframe = JFactory::getApplication();
            $wishlistIds = $mainframe->getUserState("com_tmbox.site.wishlistIds", array());
			if (!empty($wishlistIds)){
			$products = $wishlistIds;
			$prods = $product_model->getProducts($products);
			$product_model->addImages($prods,1);
			$currency = CurrencyDisplay::getInstance();
			}
		}else {
		   $db =& JFactory::getDBO();
		   $q ="SELECT virtuemart_product_id FROM #__tmbox WHERE userid =".$user->id;
			$db->setQuery($q);
			$allproducts = $db->loadAssocList();
			foreach($allproducts as $productbd){
				$allprod['id'][] = $productbd['virtuemart_product_id'];
			}
			$product = $allprod['id'];
			$prods = $product_model->getProducts($product);
			$product_model->addImages($prods,1);
			$currency = CurrencyDisplay::getInstance();
		}
		return $prods;

	}

}