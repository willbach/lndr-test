<?php 
/*------------------------------------------------------------------------
# mod_SocialLoginandSocialShare
# ------------------------------------------------------------------------
# author    LoginRadius inc.
# copyright Copyright (C) 2013 loginradius.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.loginradius.com
# Technical Support:  Forum - http://community.loginradius.com/
-------------------------------------------------------------------------*/

//no direct access
defined( '_JEXEC' ) or die('Restricted access');
JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.framework');
$moduleParams = json_decode($module->params);
$moduleclass_sfx = $moduleParams->moduleclass_sfx;
JFactory::getLanguage()->load('mod_login');
$headerTag      = htmlspecialchars($moduleParams->header_tag);
$headerClass    = $moduleParams->header_class;
$doc = JFactory::getDocument();

?>

<i class="fa fa-user"></i>
<div class="mod_login_wrapper">
<?php 
// Check for plugin enabled.
jimport('joomla.plugin.helper');
if(!JPluginHelper::isEnabled('system','socialloginandsocialshare')) :
  JError::raiseNotice ('sociallogin_plugin', JText::_ ('MOD_LOGINRADIUS_PLUGIN_ERROR')); 
endif;

if ($type == 'logout') :
$style = 'a[href*="id='. $module->id .'"].btn.jmodedit {
    display: none !important;
}'; 
$doc->addStyleDeclaration($style); ?>
<?php $session = JFactory::getSession();?>
  <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" class="login-form" id="login-form__<?php echo $module->id; ?>">
    <div class="social_login_profile">
      <?php $user_picture = $session->get('user_picture');?>
      <?php if (!empty($user_picture)) { ?>
      <div class="item_img img-intro__left">
        <img src="<?php echo $user_picture; ?>" alt="<?php echo $user->get('name');?>">
      </div>
      <?php } ?>
      <div class="profile">
        <div class="login-greeting" >
          <?php 
          $name = $user->get('name');
          if(!empty($name)):
          echo JHtml::_('link', JRoute::_('index.php?option=com_users&view=profile'), $name);
          else :
          echo JHtml::_('link', JRoute::_('index.php?option=com_users&view=profile'), $user->get('username'));
          endif;
          ?>
        </div>
  	    <div class="logout-button">
      		<button type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>"><?php echo JText::_('JLOGOUT'); ?></button>
      		<input type="hidden" name="option" value="com_users" />
      		<input type="hidden" name="task" value="user.logout" />
      		<input type="hidden" name="return" value="<?php echo $return; ?>" />
      		<?php echo JHtml::_('form.token');?>		
        </div>
    	</div>
      <div class="clearfix"></div>
    </div>
  </form>
<?php else :

$app = JFactory::getApplication('site');
$template = $app->getTemplate();
$doc->addScript('templates/'.$template.'/js/jquery.validate.min.js');
$doc->addScript('templates/'.$template.'/js/additional-methods.min.js');

 ?>
  <<?php echo $headerTag; ?> class="moduleTitle <?php echo $headerClass; ?>"><?php echo $module->title; ?></<?php echo $headerTag; ?>>
  <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" class="login-form" id="login-form__<?php echo $module->id; ?>">
    <?php if ($params->get('pretext')): ?>
    <div class="mod-login_pretext">
      <p><?php echo $params->get('pretext'); ?></p>
    </div>
    <?php endif; ?>
    <div class="mod-login_userdata">
    <div id="form-login-username" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext')) : ?>
          <div class="input-prepend">
            <span class="add-on">
              <i class="fa fa-user hasTooltip" title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></i>
            </span>
            <input id="modlgn-username" type="text" name="username" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" required />
          </div>
        <?php else: ?>
        <input id="mod-login_username<?php echo $module->id; ?>" class="inputbox mod-login_username" type="text" name="username" tabindex="1" size="18" placeholder="<?php echo JText::_('TPL_MOD_LOGIN_VALUE_USERNAME') ?>" required>
        <?php endif; ?>
      </div>
    </div>
    <div id="form-login-password" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext')) : ?>
          <div class="input-prepend">
            <span class="add-on">
              <i class="fa fa-lock hasTooltip" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"></i>
            </span>
            <input id="modlgn-passwd" type="password" name="password" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" required />
          </div>
        <?php else: ?>
        <input id="mod-login_passwd<?php echo $module->id; ?>" class="inputbox mod-login_passwd" type="password" name="password" tabindex="2" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"  required>
        <?php endif; ?>
      </div>
    </div>    
    <?php if (count($twofactormethods) > 1): ?>
    <div id="form-login-secretkey" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext')) : ?>
          <div class="input-prepend input-append">
            <span class="add-on">
              <i class="fa fa-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>"></i>
              <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
            </span>
            <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
            <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
              <span class="fa fa-question-circle"></span>
            </span>
        </div>
        <?php else: ?>
          <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
          <input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
          <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
            <span class="fa fa-question-circle"></span>
          </span>
        <?php endif; ?>

      </div>
    </div>
    <?php endif; ?>
      <div class="mod-login_submit">
        <button type="submit" tabindex="3" name="Submit" class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
        <?php $usersConfig = JComponentHelper::getParams('com_users');
        if ($usersConfig->get('allowUserRegistration')) : ?>
        <a class="btn btn-primary register" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
        <?php endif; ?>
      </div>
      <input type="hidden" name="option" value="com_users">
      <input type="hidden" name="task" value="user.login">
      <input type="hidden" name="return" value="<?php echo $return; ?>">
      <?php echo JHtml::_('form.token'); ?>
      <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
      <label for="mod-login_remember<?php echo $module->id; ?>" class="checkbox">
        <input id="mod-login_remember<?php echo $module->id; ?>" class="mod-login_remember" type="checkbox" name="remember" value="yes">
        <?php echo JText::_('TPL_MOD_LOGIN_REMEMBER_ME') ?>
      </label> 
      <?php endif; ?>
      <div class="reset_remind">
      <?php echo JText::_('TPL_FORGOT'); ?>
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" class="hasTooltip"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>/
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="hasTooltip"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>?
      </div>
    </div>
    <?php if ($params->get('posttext')): ?>
    <div class="mod-login_posttext">
      <p><?php echo $params->get('posttext'); ?></p>
    </div>
    <?php endif; ?>
  </form>

<script>
  jQuery(document).bind('ready', function(){
    validator = jQuery('#login-form__<?php echo $module->id; ?>').validate({
      wrapper: 'mark'
    })
  })
</script>
<?php echo $sociallogin;
endif;?>
</div>
<script>
  jQuery(document).bind('ready', function(){
    jQuery('.moduletable#module_<?php echo $module->id; ?>>i.fa-user').click(function(){
      jQuery('.moduletable#module_<?php echo $module->id; ?>').toggleClass('shown')
    });
  })
</script>