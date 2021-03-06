<?php
/**
 * Social Login
 *
 * @version   1.7
 * @author    SmokerMan, Arkadiy, Joomline
 * @copyright © 2012. All rights reserved.
 * @license   GNU/GPL v.3 or later.
 */

// No direct access.
defined('_JEXEC') or die('(@)|(@)');
$headerTag      = htmlspecialchars($moduleParams->header_tag);
$headerClass    = $moduleParams->header_class;
JFactory::getLanguage()->load('mod_login');
$doc = JFactory::getDocument(); 
?>
<div class="mod_login_wrapper">
<noindex>
<div class="jlslogin">
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">

    <?php if (!empty($avatar)) : ?>
        <div class="slogin-avatar">
      <a href="<?php echo $profileLink; ?>" target="_blank">
        <img src="<?php echo $avatar; ?>" alt=""/>
      </a>
        </div>
    <?php endif; ?>

    <div class="login-greeting">
  <?php echo JText::sprintf('MOD_SLOGIN_HINAME', htmlspecialchars($user->get('name')));  ?>
  </div>
    <ul class="ul-jlslogin">
      <?php if ($params->get('slogin_link_auch_edit', 1) == 1) {?>
        <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'); ?>"><?php echo JText::_('MOD_SLOGIN_EDIT_YOUR_PROFILE'); ?></a></li>
      <?php } ?>
      <?php if ($params->get('slogin_link_profile', 1) == 1) {?>
      <li><a href="<?php echo JRoute::_('index.php?option=com_slogin&view=fusion'); ?>"><?php echo JText::_('MOD_SLOGIN_EDIT_YOUR_SOCIAL_AUCH'); ?></a></li>
      <?php } ?>
    </ul>
  <div class="logout-button">
    <input type="submit" name="Submit" class="button btn" value="<?php echo JText::_('JLOGOUT'); ?>" />
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="task" value="user.logout" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>
<?php else : ?>
<?php if ($params->get('inittext')): ?>
  <div class="pretext">
  <p><?php echo $params->get('inittext'); ?></p>
  </div>
<?php endif; ?>
<h3 class="<?php echo $headerClass;?> moduleTitle"><?php echo $module->title; ?></h3>
<div id="slogin-buttons" class="slogin-buttons slogin-default">

    <?php if (count($plugins)): ?>
    <?php
        foreach($plugins as $link):
            $linkParams = '';
            if(isset($link['params'])){
                foreach($link['params'] as $k => $v){
                    $linkParams .= ' ' . $k . '="' . $v . '"';
                }
            }
      $title = (!empty($link['plugin_title'])) ? ' title="'.$link['plugin_title'].'"' : '';
            ?>
            <a  rel="nofollow" class="link<?php echo $link['class'];?>" <?php echo $linkParams.$title;?> href="<?php echo JRoute::_($link['link']);?>"><span class="<?php echo $link['class'];?> slogin-ico">&nbsp;</span><span class="text-socbtn"><?php echo $link['plugin_title'];?></span></a>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<div class="slogin-clear"></div></br>

<?php if ($params->get('show_login_form')): ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
  <?php if ($params->get('pretext')): ?>
  <div class="pretext">
  <p><?php echo $params->get('pretext'); ?></p>
  </div>
  <?php endif; ?>
  <div class="mod-login_userdata">
    <div id="form-login-username" class="control">
      <div class="control">
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
    <div id="form-login-password" class="control">
      <div class="control">
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
    <div id="form-login-secretkey" class="control">
      <div class="control">
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
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" class="hasTooltip"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a> /
      <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="hasTooltip"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
      </div>
    </div>
  <?php if ($params->get('posttext')): ?>
    <div class="posttext">
    <p><?php echo $params->get('posttext'); ?></p>
    </div>
  <?php endif; ?>
</form>
<?php endif; ?>
<?php endif; ?>
</div>
</noindex>
</div>
<?php $doc->addScriptdeclaration('(function($){$(document).ready(function(){$(".moduletable#module_'.$module->id.'>i.fa-user").click(function(){$(".moduletable#module_'.$module->id.'").toggleClass("shown")})})})(jQuery);');