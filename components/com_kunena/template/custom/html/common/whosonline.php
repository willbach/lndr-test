<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Common
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

?>
<div class="kblock kwhoisonline">
	<div class="kheader">
		<span><span class="ktitle km"><?php echo JText::_('COM_KUNENA_VIEW_COMMON_WHO_TITLE') ?></span></span>
	</div>
	<div class="kcontainer" id="kwhoisonline">
		<div class="kbody">
	<table class = "kblocktable">
		<tr class = "krow2">
			<td class = "kcol-first">
				<div class="kwhoicon"></div>
			</td>
			<td class = "kcol-mid km">
				<div class="kwhoonline kwho-total ks"><?php  echo JText::sprintf('COM_KUNENA_VIEW_COMMON_WHO_TOTAL', $this->membersOnline) ?>
				<?php 
					$onlinelist = array();
					foreach ($this->onlineList as $user) {
						$onlinelist[] = $user->getLink();
					}
					if(count($onlinelist) || !empty($this->hiddenList)) :
				?>
				<div>
					 <?php 

					echo implode(', ', $onlinelist); ?>
					<?php if (!empty($this->hiddenList)) : ?>
						<br />
						<span class="khidden-ktitle ks"><?php echo JText::_('COM_KUNENA_HIDDEN_USERS'); ?>: </span>
						<br />
						 <?php $hiddenlist = array();
						foreach ($this->hiddenList as $user) {
							$hiddenlist[] = $user->getLink();
						}

						echo implode(', ', $hiddenlist); ?>
					<?php endif; ?>
				</div>
				</div>
			<?php endif; ?>
			</td>
		</tr>
</table>
</div>
</div>
</div>
