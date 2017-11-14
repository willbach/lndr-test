<?php
class plgSystemTmbox extends JPlugin
{
    /**
     * Class Constructor
     * @param object $subject
     * @param array $config
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }
    function onBeforeRender() {
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $user = JFactory::getUser();
        $mainframe = JFactory::getApplication();
        $wishlistIds = $mainframe->getUserState("com_tmbox.site.wishlistIds", array());
       
        if (!($app->isAdmin())){
            if (!$user->guest) {
               if (isset($wishlistIds)) {
                    $dbIds = $wishlistIds;
                    $db =& JFactory::getDBO();
                    $q ="SELECT virtuemart_product_id FROM #__tmbox WHERE userid =".$user->id;
                    $db->setQuery($q);
                    $allproducts = $db->loadAssocList();
                    foreach($allproducts as $productbd){
                        $allprod['ids'][] = $productbd['virtuemart_product_id'];
                    }
                    $tmbox = isset($allprod['ids']) ? $allprod['ids'] : array();
                    //print_r($productbd['virtuemart_product_id']);
                    for($r=0; $r<count($dbIds); $r++) {
                        if(!in_array($dbIds[$r],$tmbox)) {
                       $q = "";
                        $q = "INSERT INTO `#__tmbox` (virtuemart_product_id,userid ) VALUES ('".$dbIds[$r]."','".$user->id."') ";
                        $db->setQuery($q);
                        $db->query();
                       }
                   }
                   unset($wishlistIds);
                    //var_dump($wishlistIds);
               }
           }
        }

    }
}

?>