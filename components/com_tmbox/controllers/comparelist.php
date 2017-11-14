<?php
defined('_JEXEC') or die;
class TmboxControllerComparelist extends JControllerLegacy
{
    public function __construct()
    {
        parent::__construct();
        TmboxSiteHelper::loadVMLibrary();
    }


    public function add()
    {
        $mainframe = JFactory::getApplication();
        $compareIds = $mainframe->getUserState("com_tmbox.site.compareIds", array());
        //var_dump($compareIds);
        $jinput = JFactory::getApplication()->input;
        JFactory::getLanguage()->load('com_tmbox');
        VmConfig::loadConfig();
        VmConfig::loadJLang('com_tmbox', true);

        $itemId = TmboxSiteHelper::getItemId('comparelist');
        //var_dump($itemId);

        $productModel = VmModel::getModel('product');

        if (isset($compareIds) && (!in_array($jinput->get('product_id', null, 'INT'), $compareIds)) && (count($compareIds) <= 3)) {

            $product = array($jinput->get('product_id', null, 'INT'));
            $prods = $productModel->getProducts($product);
            $productModel->addImages($prods, 1);
            $compareIds[] = $jinput->get('product_id', null, 'INT');
            foreach ($prods as $product) {

                $title = '<div class="title">' . JHTML::link(JRoute::_($product->link), $product->product_name) . '</div>';
                $prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
                $image = $product->images[0];
                $img = $image->displayMediaThumb('class="product-image"',false,$image->file_description);

                $img_prod =  '<div class="image fleft"><a href="'.$prod_url.'">'.$img.'</a></div>';
                $prod_name = '<div class="extra-wrap"><div class="name">'.JHTML::link(JRoute::_($product->link), $product->product_name).'</div><div class="remcompare"><a class="tooltip-1" title="remove"  onclick="TmboxRemoveCompare('.$product->virtuemart_product_id.');">'.JText::_('COM_COMPARE_REMOVE').'</a></div></div>';

                $btngocompare = '<a id="compare_go" class="button" rel="nofollow" href="' . JRoute::_('index.php?option=com_tmbox&view=comparelist&Itemid=' . $itemId . '') . '">' . JText::_('GO_TO_COMPARE') . '</a>';
                if (!empty($compareIds)) {
                    $totalcompare = count($compareIds);
                }
                $success='successfully';
            }
            $this->showJSON('' . JText::_('COM_COMPARE_MASSEDGE_ADDED') . '', $title, $btngocompare, $totalcompare, $success, '' . JText::_('COM_COMPARE_MASSEDGE_ADDED2') . '',$img_prod,  $prod_name);

        } else {
            if (!in_array($jinput->get('product_id', null, 'INT'), $compareIds)) {
                $product = array($jinput->get('product_id', null, 'INT'));
                $prods = $productModel->getProducts($product);
                $productModel->addImages($prods, 1);
                foreach ($prods as $product) {
                    $title = '';
                    $btngocompare = '<a id="compare_go" class="button" rel="nofollow" href="' . JRoute::_('index.php?option=com_tmbox&view=comparelist&Itemid=' . $itemId . '') . '">' . JText::_('GO_TO_COMPARE') . '</a>';
                    if (!empty($compareIds)) {
                        $totalcompare = count($compareIds);
                    }
                    $success='warning';
                }
                $this->showJSON('<span class="warning">' . JText::_('COM_COMPARE_MASSEDGE_MORE') . '</span>', '', $btngocompare, $totalcompare, $success);
            } else {
                $product = array($jinput->get('product_id', null, 'INT'));
                $prods = $productModel->getProducts($product);
                $productModel->addImages($prods, 1);
                foreach ($prods as $product) {
                    $title = '<div class="title">' . JHTML::link(JRoute::_($product->link), $product->product_name) . '</div>';
                     $prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
                    $image = $product->images[0];
                    $img = $image->displayMediaThumb('class="product-image"',false,$image->file_description);

                    $img_prod =  '<div class="image fleft"><a href="'.$prod_url.'">'.$img.'</a></div>';
                    $prod_name = '<div class="extra-wrap"><div class="name">'.JHTML::link(JRoute::_($product->link), $product->product_name).'</div><div class="remcompare"><a class="tooltip-1" title="remove"  onclick="TmboxRemoveCompare('.$product->virtuemart_product_id.');">'.JText::_('COM_COMPARE_REMOVE').'</a></div></div>';
                    $btngocompare = '<a id="compare_go" class="button" rel="nofollow" href="' . JRoute::_('index.php?option=com_tmbox&view=comparelist&Itemid=' . $itemId . '') . '">' . JText::_('GO_TO_COMPARE') . '</a>';
                    if (!empty($compareIds)) {
                        $totalcompare = count($compareIds);
                    }
                    $success='notification';    
                }
                $this->showJSON('' . JText::_('COM_COMPARE_MASSEDGE_ALLREADY') . '', $title, $btngocompare, $totalcompare, $success,'' . JText::_('COM_COMPARE_MASSEDGE_ALLREADY2') . '');
            }
        }
        $mainframe->setUserState("com_tmbox.site.compareIds", $compareIds);
        exit;
    }

    public function showJSON($message = '', $title = '', $btngocompare = '', $totalcompare = '', $success = '', $message2 = '', $img_prod = '',  $prod_name = '')
    {
        echo json_encode(array('message' => $message, 'title' => $title, 'totalcompare' => $totalcompare, 'btngocompare' => $btngocompare, 'success' => $success, 'message2' => $message2, 'img_prod'=>$img_prod, 'prod_name'=>$prod_name));
    }


    public function removed()
    {

        VmConfig::loadConfig();
        VmConfig::loadJLang('com_tmbox', true);
        $mainframe = JFactory::getApplication();
        $compareIds = $mainframe->getUserState("com_tmbox.site.compareIds", array());
        $jinput = JFactory::getApplication()->input;

        $productModel = VmModel::getModel('product');

        if ($jinput->get('remove_id', null, 'INT')) {
            foreach ($compareIds as $k => $v) {
                if ($jinput->get('remove_id', null, 'INT') == $v) {
                    unset($compareIds[$k]);
                }
            }
            $prod = array($jinput->get('remove_id', null, 'INT'));
            $prods = $productModel->getProducts($prod);
            foreach ($prods as $product) {
                $title = '<span>' . JHTML::link($product->link, $product->product_name) . '</span>';
            }
            $totalrem = count($compareIds);
        }
        $mainframe->setUserState("com_tmbox.site.compareIds", $compareIds);
        $this->removeJSON('' . JText::_('COM_COMPARE_MASSEDGE_REM') . ' ' . $title . ' ' . JText::_('COM_COMPARE_MASSEDGE_REM2') . '', $totalrem);
        exit;
    }
     public function removeJSON($message = '', $totalrem = '')
    {
        echo json_encode(array('message' => $message, 'totalrem' => $totalrem));
    }
}