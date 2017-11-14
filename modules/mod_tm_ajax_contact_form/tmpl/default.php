<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 2.1.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2016 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;
jimport( 'joomla.filter.filteroutput' );

$fields = json_decode($params->get('fields_list', false));

$html = '';

if(!empty($fields->name)){
	if($params->get('admin_email')) {
		$js = '(function($){$(document).ready(function(){var v=$("#contact-form_'.$module->id.'").validate({wrapper:"mark",submitHandler:function(f){';
		if($captcha) {
			$js .= '$(f).ajaxcaptcha();';
		}
		else {
			$js .= '$(f).ajaxsendmail();';
		}
		$js .= 'return false}});';
		if($params->get('reset_publish')){
			$js .= '$("#clear_'.$module->id.'").click(function(){$("#contact-form_'.$module->id.'").trigger("reset");v.resetForm();';
			if($labels_pos){
			    $js .= 'if(!$.support.placeholder){$(".mod_tm_ajax_contact_form *[placeholder]").each(function(n){$(this).parent().find(">.form_placeholder").show()})}';
			}
			$js .= 'return false});';
		}
?>
<?php if($params->get('pretext')){?>
<div class="pretext">
	<?php echo $params->get('pretext');?>
</div>
<?php }?>
<div id="contact_<?php echo $module->id; ?>">
	<form class="mod_tm_ajax_contact_form" id="contact-form_<?php echo $module->id; ?>" novalidate>
		<input type="hidden" id="module_id" name="module_id" value="<?php echo $module->id; ?>">
		<div class="mod_tm_ajax_contact_form_message" id="message_<?php echo $module->id; ?>">
			<span class="s"><?php echo $success; ?></span>
			<span class="e"><?php echo $error; ?></span>
			<span class="c"><?php echo $captcha_error; ?></span>
		</div>
		<fieldset>
			<div class="row">
				<?php foreach($fields->type as $key => $type){
					$label = $fields->label[$key];
					$id = ' id="'.JFilterOutput::stringURLUnicodeSlug($fields->name[$key]).'_'.$key.'_'.$module->id.'"';
					$placeholder = ' placeholder="'.$label.'"';
					$name = ' name="'.JFilterOutput::stringURLUnicodeSlug($fields->name[$key]).'"';
					if($fields->name[$key] =='') $name = ' name="'.JFilterOutput::stringURLUnicodeSlug($fields->label[$key]).'_'.$key.'_'.$module->id.'"';
					$class = ' class="mod_tm_ajax_contact_form_'.$type.'"';
					$req = $fields->req[$key] ? ' required' : '';
					if($type=='tel' && $fields->req[$key]){
						$js .= '$("#'.JFilterOutput::stringURLSafe($fields->name[$key])."_".$key.'_'.$module->id.'").rules("add", {number: true});';
					}
					$title = $fields->title[$key] ? ' title="'.$fields->title[$key].'"' : ' title="'.$label.'"';
					$html .= '<div class="control control-group-input span'.$fields->bootstrap_size[$key].'">';
					if(!$labels_pos){
						$html .= '<label for="'.JFilterOutput::stringURLSafe($fields->name[$key]).'_'.$key.'"'.$title.' class="">'.$label.'</label>';
						$placeholder = '';
					}
					$html .= '<div class="control">';
					switch ($type) {
						case 'textarea':
							$id = ' id="'.JFilterOutput::stringURLUnicodeSlug($fields->name[$key]).'_'.$key.'_'.$module->id.'"';

							$html .= '<textarea'.$name.$placeholder.$id.$class.$req.$title.'></textarea>';

							if($fields->req[$key])

							$js .= '$("#'.JFilterOutput::stringURLSafe($fields->name[$key])."_".$key.'_'.$module->id.'").rules("add", {minlength: '.$params->get('textarea_minlength').'});';
							break;
						case 'select':
							JHtml::_('formbehavior.chosen', 'select');
							$html .= '<select'.$name.$id.$class.$req.$title.'>';
								if($labels_pos){
									$html .= '<option value="test" disabled selected>'.$label.'</option>';
								}
								$options_array = json_decode($fields->options_list[$key]);
								$options = $options_array->option_name;
								foreach ($options as $i => $option){
									$value = $options_array->option_value[$i] !='' ? $options_array->option_value[$i] : $option;
								$html .= '<option value="'.$value.'">'.$option.'</option>';
							}
							$html .= '</select>';
							break;
						default:
							if($type == 'date'){
								$class = ' class="mod_tm_ajax_contact_form_'.$type.' datepicker_'.$key.'_'.$module->id.' hasTooltip"';

								$document->addScriptDeclaration('
									jQuery(document).ready(function($){
										$(window).load(function() {
												$(".datepicker_'.$key.'_'.$module->id.'").datetimepicker({
													format: "MM/DD/YYYY",
													icons: {
											            time: \'fa fa-clock-o\',
											            date: \'fa fa-calendar\',
											            up: \'fa fa-angle-up\',
											            down: \'fa fa-angle-down\',
											            previous: \'fa  fa-angle-left\',
											            next: \'fa fa-angle-right\',
											            today: \'fa fa-crosshairs\',
											            clear: \'fa fa-trash\',
											            close: \'fa fa-close\'
											        }
								                });
										});
									});'
								);
							}

							if($type == 'times'){

								$class = ' class="mod_tm_ajax_contact_form_'.$type.' timepicker_'.$key.'_'.$module->id.' hasTooltip"';
								if($params->get('time_format') == '1'){
									$time_format = 'hh:mm A';
								} else {
									$time_format = 'HH:mm';
								}
								$document->addScriptDeclaration('
									jQuery(document).ready(function($){
										$(window).load(function() {
												$(".timepicker_'.$key.'_'.$module->id.'").datetimepicker({
													format: "'.$time_format.'",
													icons: {
											            time: \'fa fa-clock-o\',
											            date: \'fa fa-calendar\',
											            up: \'fa fa-angle-up\',
											            down: \'fa fa-angle-down\',
											            previous: \'fa  fa-angle-left\',
											            next: \'fa fa-angle-right\',
											            today: \'fa fa-crosshairs\',
											            clear: \'fa fa-trash\',
											            close: \'fa fa-close\'
											        }
								                });
										});
									});'
								);

								
							}
							if ($type == 'date') {
								$html .= '<input type="text" '.$placeholder.$name.$id.$class.$req.$title.'>';
							}else {
								$html .= '<input type="'.$type.'"'.$placeholder.$name.$id.$class.$req.$title.'>';

							}
							
							break;
					}
					$html .= '</div>
					</div>';
				}
				echo $html;
				if($captcha){ ?>
				<!-- Captcha Field -->
				<div class="control control-group-captcha col-sm-12">
					<div class="control">
						<div id="captcha_<?php echo $module->id;?>"></div>
					</div>
				</div>
				<?php } ?>
				<!-- Submit Button -->
				<div class="control control-group-button span12">
					<div class="control">
						<button type="submit" class="btn btn-primary mod_tm_ajax_contact_form_btn"><?php echo $params->get('bs_name');?></button>
					<?php if($params->get('reset_publish')) { ?>
						<button type="reset" id="clear_<?php echo $module->id; ?>" class="btn btn-primary mod_tm_ajax_contact_form_btn"><?php echo $params->get('br_name');?></button>
					<?php } ?>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<?php 
$js .= '})})(jQuery);';
$document->addScriptDeclaration($js);
$document->addScriptDeclaration('
	jQuery(document).ready(function($){
		$(window).load(function() {
			/*if( $("#contact-form_'.$module->id.' .datepicker_'.$module->id.'").length > 0 ){
				$()
				$("#datetimepicker3").datetimepicker({
                    format: "LT"
                });
			}*/
		});

		$(window).load(function() {
			/*if( $("#contact-form_'.$module->id.' .timepicker_'.$module->id.'").length > 0 ){

			}*/
		});
	});'
	);
if($captcha){
	$file  = '//www.google.com/recaptcha/api.js?hl=' . JFactory::getLanguage()->getTag() . '&amp;render=explicit';
	JHtml::_('script', $file, true, true);
	$params2 = new JRegistry(JPluginHelper::getPlugin('captcha', 'recaptcha')->params);
	$theme = $params2->get('theme2', 'light');
	$pubkey = $params2->get('public_key', '');
	$document->addScriptDeclaration('jQuery(document).ready(function($) {$(window).load(function() {'
		. 'grecaptcha.render("captcha_' . $module->id . '", {sitekey: "' . $pubkey . '", theme: "' . $theme . '"});'
		. '});});'
	);
}

} else { ?>
<p><?php echo JText::_('MOD_TM_AJAX_CONTACT_FORM_ENTER_ADMIN_EMAIL'); ?></p>
<?php }
} ?>
<?php
$lang = substr(JFactory::getLanguage()->getTag(), 0, 2);

if(file_exists('modules/mod_tm_ajax_contact_form/js/localization/messages_'.$lang.'.min.js')){
	$document->addScript('modules/mod_tm_ajax_contact_form/js/localization/messages_'.$lang.'.min.js');
}
?>