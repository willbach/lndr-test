<?php
/**
 * Kunena Component
 * @package Kunena.Template.Blue_Eagle
 * @subpackage Topics
 *
 * @copyright (C) 2008 - 2013 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

$this->displayAnnouncement ();
?>
<!-- Module position: kunena_announcement -->
<?php $this->displayModulePosition ( 'kunena_announcement' ) ?>
<div class="klist-actions">
		<div class="klist-actions-info-all">
			<?php echo intval($this->total) ?>
			<?php echo JText::_('COM_KUNENA_TOPICS')?>
		</div>

		<div class="klist-jump-all hidden-phone"><?php $this->displayForumJump () ?></div>
		<?php if($this->getPagination ( 5 )) : ?>
		<div class="klist-pages-all"><?php echo $this->getPagination ( 5 ); ?></div>
		<?php endif; ?>
</div>

<?php $this->displayTemplateFile('topics', 'user', 'embed'); ?>

<?php
$this->displayWhoIsOnline ();
$this->displayStatistics ();
?>
