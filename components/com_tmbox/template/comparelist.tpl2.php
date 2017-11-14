<?php 
 JFactory::getLanguage()->load('com_tmbox');
VmConfig::loadConfig();
VmConfig::loadJLang('com_virtuemart', true);
vmJsApi::addJScript("/components/com_tmbox/assets/scripts/tmbox.js",false,false);
$mainframe = JFactory::getApplication();
$compareIds = $mainframe->getUserState("com_tmbox.site.compareIds", array());
//var_dump($compareIds);
?>        
<a class="btn add_compare hasTooltips <?php echo in_array($this->product->virtuemart_product_id, $compareIds) ? 'act' : ''; ?>"
   title="<?php echo JText::_('ADD_TO_COMPARE'); ?>"
   onclick="TmboxAddToCompare('<?php echo $this->product->virtuemart_product_id; ?>');">
    <i class="material-icons-content_copy"></i>
    <span><?php echo JText::_("ADD_TO_COMPARE"); ?></span>
    
</a>
