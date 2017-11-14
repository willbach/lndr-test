<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
$app = JFactory::getApplication('site');
$template = $app->getTemplate(true);
$document = JFactory::getDocument();
JHtml::_('bootstrap.framework');
$document->addScript('templates/'.$template->template.'/js/jquery.validate.min.js');
$document->addScript('templates/'.$template->template.'/js/additional-methods.min.js');
?>
<div class="page-registration page-registration__<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page_header">
  		<<?php echo $template->params->get('categoryPageHeading', 'h3'); ?>><?php echo $this->escape($this->params->get('page_heading')); ?></<?php echo $template->params->get('categoryPageHeading', 'h3'); ?>>
	</div>
	<?php endif; ?>
	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-horizontal">
		<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.
		$fields = $this->form->getFieldset($fieldset->name);
		if (count($fields)):?>
		<fieldset>
			<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
			endif;
			foreach($fields as $field):// Iterate through the fields in the set and display them.
			if ($field->hidden):// If the field is hidden, just display the input.
			echo $field->input;
			else:?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label;
					if (!$field->required && $field->type != 'Spacer'): ?>
					<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
				</div>
				<div class="controls">
					<?php echo $field->input;?>
				</div>
			</div>
			<?php endif;
			endforeach;?>
		</fieldset>
		<?php endif;
		endforeach;?>
		<div class="controls">
			<button type="submit" class="btn btn-primary"><?php echo JText::_('JREGISTER');?></button>
			<a class="btn btn-primary cancel" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
		</div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="registration.register" />
		<?php echo JHtml::_('form.token');?>
	</form>
</div>
<script>
	jQuery(document).bind('ready', function(){
		validator = jQuery('#member-registration').validate({
			wrapper: 'mark',
			rules: {
				'jform[password2]' : {
					equalTo: "#jform_password1"
				},
				'jform[email2]' : {
					equalTo: "#jform_email1"
				}
			}
		})
		var input = jQuery('#jform_profile_dob').closest('.controls').addClass('calendar_wrapper');
		input.closest('.control-group').prev().find('.controls').attr('id','jform_profile_dob_spacer-lbl').removeClass('controls').clone().appendTo(input);
		input.closest('.control-group').prev().remove();
	})
</script>