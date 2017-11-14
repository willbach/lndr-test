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
JFactory::getLanguage()->load('mod_login');
// Check for plugin enabled.
  jimport('joomla.plugin.helper');
  if(!JPluginHelper::isEnabled('system','socialloginandsocialshare')) :
    JError::raiseNotice ('sociallogin_plugin', JText::_ ('MOD_LOGINRADIUS_PLUGIN_ERROR')); 
   endif;


if ($type == 'logout') :
$session = JFactory::getSession(); ?>
  <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form__<?php echo $module->id; ?>" class="login-form">
  <div class="social_login_profile">
     <?php $user_picture = $session->get('user_picture');?>
     <?php if (!empty($user_picture)) { ?>
     <div class="item_img img-intro__left">
      <img src="<?php echo $user_picture; ?>" alt="<?php echo $user->get('name');?>">
     </div>
     <?php } ?>
     <div class="profile">
       <div class="login-greeting" >
      <?php $name = $user->get('name');
        if(!empty($name)):
                  echo JHtml::_('link', JRoute::_('index.php?option=com_users&view=profile'), $name);
                else :
                  echo JHtml::_('link', JRoute::_('index.php?option=com_users&view=profile'), $user->get('username'));
                endif; ?>
       </div>
     <div class="logout-button">
    <button type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>"><?php echo JText::_('JLOGOUT'); ?></button>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.logout" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token');?>    
     </div>
  </div>
       <div style="clear:both"></div>
  </div>
   </form>
<?php else :

$doc = JFactory::getDocument();
$app = JFactory::getApplication('site');
$template = $app->getTemplate();
$doc->addScript('templates/'.$template.'/js/jquery.validate.min.js');
$doc->addScript('templates/'.$template.'/js/additional-methods.min.js'); ?>
  <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form-<?php echo $module->id; ?>" class="form-inline">
    <?php if ($params->get('pretext')): ?>
    <div class="mod-login_pretext">
      <p><?php echo $params->get('pretext'); ?></p>
    </div>
    <?php endif; ?>
    <div class="mod-login_userdata">
    <div id="form-login-username-<?php echo $module->id; ?>" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext', TRUE)) : ?>
          <div class="input-prepend">
            <span class="add-on">
              <span class="fa fa-user hasTooltip" title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></span>
              <label for="modlgn-username-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
            </span>
            <input id="modlgn-username-<?php echo $module->id; ?>" type="text" name="username" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
          </div>
        <?php else: ?>
        <input id="mod-login_username-<?php echo $module->id; ?>" class="inputbox mod-login_username" type="text" name="username" tabindex="1" size="18" placeholder="<?php echo JText::_('TPL_MOD_LOGIN_VALUE_USERNAME') ?>" required>
        <?php endif; ?>
      </div>
    </div>
    <div id="form-login-password-<?php echo $module->id; ?>" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext', TRUE)) : ?>
          <div class="input-prepend">
            <span class="add-on">
              <span class="fa fa-lock hasTooltip" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
              </span>
                <label for="modlgn-passwd-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('JGLOBAL_PASSWORD'); ?>
              </label>
            </span>
            <input id="modlgn-passwd-<?php echo $module->id; ?>" type="password" name="password" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
          </div>
        <?php else: ?>
        <input id="mod-login_passwd-<?php echo $module->id; ?>" class="inputbox mod-login_passwd" type="password" name="password" tabindex="2" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"  required>
        <?php endif; ?>
      </div>
    </div>    
    <?php if (count($twofactormethods) > 1): ?>
    <div id="form-login-secretkey-<?php echo $module->id; ?>" class="control-group">
      <div class="controls">
        <?php if (!$params->get('usetext', TRUE)) : ?>
          <div class="input-prepend input-append">
            <span class="add-on">
              <span class="fa fa-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>">
              </span>
                <label for="modlgn-secretkey-<?php echo $module->id; ?>" class="element-invisible"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?>
              </label>
            </span>
            <input id="modlgn-secretkey-<?php echo $module->id; ?>" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
            <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
              <span class="fa fa-question-circle"></span>
            </span>
        </div>
        <?php else: ?>
          <label for="modlgn-secretkey-<?php echo $module->id; ?>"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
          <input id="modlgn-secretkey-<?php echo $module->id; ?>" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
          <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
            <span class="icon-help"></span>
          </span>
        <?php endif; ?>

      </div>
    </div>
    <?php endif; ?>
      <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
      <label for="mod-login_remember-<?php echo $module->id; ?>" class="checkbox">
        <input id="mod-login_remember-<?php echo $module->id; ?>" class="mod-login_remember" type="checkbox" name="remember" value="yes">
        <?php echo JText::_('TPL_MOD_LOGIN_REMEMBER_ME') ?>
      </label> 
      <?php endif; ?>
      <div class="mod-login_submit">
        <button type="submit" tabindex="3" name="Submit" class="btn btn-primary"><?php echo JText::_('JLOGIN') ?></button>
      </div>
      <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>         
      <ul class="unstyled">
        <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" class="" title="<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?>"><?php echo JText::_('TPL_REMIND'); ?></a></li>
        <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="" title="<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?>"><?php echo JText::_('TPL_RESET'); ?></a></li>
        <?php if ($usersConfig->get('allowUserRegistration')) : ?>
        <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a></li>
        <?php endif; ?>
      </ul>
      <input type="hidden" name="option" value="com_users">
      <input type="hidden" name="task" value="user.login">
      <input type="hidden" name="return" value="<?php echo $return; ?>">
      <?php echo JHtml::_('form.token'); ?>
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
endif; ?>