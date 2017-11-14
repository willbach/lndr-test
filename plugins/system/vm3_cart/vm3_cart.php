<?php
defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
jimport('joomla.plugin.plugin');

class plgSystemVM3_Cart extends JPlugin {
	private $_cart=null;
	
	function __construct($event,$params){
		parent::__construct($event,$params);
				$this->_baseurl = str_replace('modules/mod_virtuemart_cart_tm/', '', JURI::base());

	}
	
	function onAfterInitialise() {
		if(JFactory::getApplication()->isAdmin()) {
			return;
		}
		//var_dump(VMPATH_SITE);
		if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.'/administrator/components/com_virtuemart/helpers/config.php');
		if(!class_exists('VirtueMartCart')) require(JPATH_ROOT.'/components/com_virtuemart/helpers/cart.php');

		VmConfig::loadConfig();

		if(JRequest::getCmd('option')=='com_virtuemart' && JRequest::getCmd('view')=='cart' && JRequest::getCmd('task')=='viewJS' && JRequest::getCmd('format')=='json') {
			JFactory::getLanguage()->load('mod_virtuemart_cart_tm');
			
			$cart = $this->prepareAjaxData();
			if ($cart->totalProduct > 1)
			    $cart->totalProductTxt = JText::sprintf('TM_VIRTUEMART_CART_X_PRODUCTS', $cart->totalProduct);
			else if ($cart->totalProduct == 1)
			    $cart->totalProductTxt = JText::_('TM_VIRTUEMART_ITEM');
			else
			    $cart->totalProductTxt = JText::_('TM_VIRTUEMART_EMPTY_CART');
				$cart->totalProductTxt = '<span class="cart_num"><span class="crt-text">'.JText::_('TM_VIRTUEMART_NOW_IN_YOUR_CART').'</span><a href="#cart">' . $cart->totalProductTxt . '</a></span>';
			if ($cart->dataValidated == true) {
			    $taskRoute = '&task=confirm';
			    $linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
			} else {
			    $taskRoute = '';
			    $linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
			}
			$cart->cart_show = '<a class="btn btn-default" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, true, VmConfig::get('useSSL', 0)) . '"><span><span>' . $linkName . '</span></span></a>';
			$cart->billTotal = '<div class="total2"><span>'.JText::_('COM_VIRTUEMART_CART_TOTAL').':</span>'.'<strong>' . $cart->billTotal . '</strong></div>';
			echo json_encode($cart);
			
			jexit();
		}
	}
	// Render the code for Ajax Cart
	function prepareAjaxData(){
		defined('DS') or define('DS', DIRECTORY_SEPARATOR);
		//error_reporting( E_ERROR );
		$this->_cart = VirtueMartCart::getCart(false);
		$this->_cart->prepareCartData(false);
		$weight_total = 0;
		$weight_subtotal = 0;

		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//]
		$data = new stdClass();
		$data->products = array();

		
		$data->totalProduct = 0;
		$i=0;
		
		if (!class_exists('CurrencyDisplay'))
		require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
		$currencyDisplay = CurrencyDisplay::getInstance();
		
		foreach ($this->_cart->products as $priceKey=>$product){
			//var_dump($priceKe);
			$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
			//Create product URL
			$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
			// @todo Add variants
			$data->products[$i]['virtuemart_product_id'] = $product->virtuemart_product_id;
			$data->products[$i]['product_cart_id'] = $priceKey;
			$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name);

			// Add the variants
				if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');
				//  custom product fields display for cart
				$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);
			$data->products[$i]['product_sku'] = $product->product_sku;
			// product Price total for ajax cart
			//$data->products[$i]['prices'] = $currency->priceDisplay($this->_cart->pricesUnformatted[$priceKey]['salesPrice']);
			$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPrice']);
			// other possible option to use for display
			
			$data->products[$i]['subtotal'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal']);
			$data->products[$i]['subtotal_tax_amount'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_tax_amount']);
			$data->products[$i]['subtotal_discount'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal_discount']);
			$data->products[$i]['subtotal_with_tax'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_with_tax']);

			/**			
            * Line for adding images to minicart
            **/
            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->file_url_thumb.'" />';
						$productModel = VmModel::getModel('Product');
			$product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
			$productModel->addImages($product_images,1);

			$data->products[$i]['image']='<img src="'.$this->_baseurl.$product_images->images[0]->file_url.'" />';


			// UPDATE CART / DELETE FROM CART
			$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
			$data->totalProduct += $product->quantity ;
			$i++;

		}
		//JFactory::getLanguage()->load('mod_vm2cart');
		//$data->billTotal = count($data->products)?$this->_cart->prices['billTotal']:JText::_('MOD_VM2CART_CART_EMPTY');
		//$data->billTotal = $currencyDisplay->priceDisplay( $this->_cart->pricesUnformatted['billTotal'] );
		//print_r($this->_cart->pricesUnformatted);
		if(empty($this->_cart->pricesUnformatted['billTotal']) or $this->_cart->pricesUnformatted['billTotal'] < 0){
			$this->_cart->pricesUnformatted['billTotal'] = 0.0;
		}
		if($data->totalProduct){
			//echo '1';
			$data->billTotal = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span><span class="totalprice">'.$currencyDisplay->priceDisplay( $this->_cart->pricesUnformatted['billTotal']).'</span>';
		} else {
			$this->_cart->pricesUnformatted['billTotal'] = 0.0;
			$data->billTotal = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span><span class="totalprice">'.$currencyDisplay->priceDisplay( $this->cartPrices['billTotal'] ).'</span>';
		}
		

		$data->cart_empty_text  = JText::_('TM_VIRTUEMART_CART_EMPTY');
		$data->carttotaltext = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span>';
		$data->cart_recent_text  = JText::_('TM_VIRTUEMART_CART_ADD_RECENTLY');
		//$data->dataValidated = $this->_dataValidated ;
		$data->dataValidated=false;
		//var_dump($data->products);
		
		return $data;
	}
	function prepareAjaxData2(){
		defined('DS') or define('DS', DIRECTORY_SEPARATOR);
		//error_reporting( E_ERROR );
		$this->_cart = VirtueMartCart::getCart(false);
		$this->_cart->prepareCartData(false);
		$weight_total = 0;
		$weight_subtotal = 0;

		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//]
		$data = new stdClass();
		$data->products = array();

		
		$data->totalProduct = 0;
		$i=0;
		
		if (!class_exists('CurrencyDisplay'))
		require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
		$currencyDisplay = CurrencyDisplay::getInstance();
		$popprodid = JRequest::get('POST');

		//print_r($popprodid['pid']);
		foreach ($this->_cart->products as $priceKey=>$product){
			if($popprodid['pid'] == $product->virtuemart_product_id ){
			//var_dump('test');
			$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
			//Create product URL
			$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
			// @todo Add variants
			$data->products[$i]['virtuemart_product_id'] = $product->virtuemart_product_id;
			$data->products[$i]['product_cart_id'] = $priceKey;
			$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name);

			// Add the variants
				if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');
				//  custom product fields display for cart
				$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);
			$data->products[$i]['product_sku'] = $product->product_sku;
			// product Price total for ajax cart
			//$data->products[$i]['prices'] = $currency->priceDisplay($this->_cart->pricesUnformatted[$priceKey]['salesPrice']);
			$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPrice']);
			// other possible option to use for display
			$data->products[$i]['sales'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPriceTt']);

			$data->products[$i]['subtotal'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal']);
			$data->products[$i]['subtotal_tax_amount'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_tax_amount']);
			$data->products[$i]['subtotal_discount'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal_discount']);
			$data->products[$i]['subtotal_with_tax'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_with_tax']);

			/**			
            * Line for adding images to minicart
            **/
            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->file_url_thumb.'" />';
						$productModel = VmModel::getModel('Product');
			$product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
			$productModel->addImages($product_images,1);

			$data->products[$i]['image']='<img src="'.$this->_baseurl.$product_images->images[0]->file_url.'" />';


			// UPDATE CART / DELETE FROM CART
			$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
			$data->totalProduct += $product->quantity ;
			//$i++;
			}
		}
		//JFactory::getLanguage()->load('mod_vm2cart');
		//$data->billTotal = count($data->products)?$this->_cart->prices['billTotal']:JText::_('MOD_VM2CART_CART_EMPTY');
		//$data->billTotal = $currencyDisplay->priceDisplay( $this->_cart->pricesUnformatted['billTotal'] );
		//print_r($this->_cart->pricesUnformatted);
		if(empty($this->cartPrices['billTotal']) or $this->cartPrices['billTotal'] < 0){
			$this->cartPrices['billTotal'] = 0.0;
		}
		if($data->totalProduct){
			$data->billTotal = $currencyDisplay->priceDisplay( $this->cartPrices['billTotal'] );
		} else {
			$this->cartPrices['billTotal'] = 0.0;
			$data->billTotal = $currencyDisplay->priceDisplay( $this->cartPrices['billTotal'] );
		}
		
		//print_r($data->billTotal);
		//$data->billTotal = $currencyDisplay->priceDisplay($this->_cart->pricesUnformatted['billTotal']);

		$data->cart_empty_text  = JText::_('TM_VIRTUEMART_CART_EMPTY');
		$data->carttotaltext = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span>';
		$data->cart_recent_text  = JText::_('TM_VIRTUEMART_CART_ADD_RECENTLY');
		//$data->dataValidated = $this->_dataValidated ;
		$data->dataValidated=false;
		//var_dump($data->products);
		
		return $data;
	}
}
?>