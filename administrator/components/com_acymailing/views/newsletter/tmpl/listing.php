<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.7.0
 * @author	acyba.com
 * @copyright	(C) 2009-2017 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><div id="acy_content" class="acynewsletterlisting">
	<div id="iframedoc"></div>
	<form action="<?php echo JRoute::_('index.php?option=com_acymailing&ctrl='.JRequest::getCmd('ctrl')); ?>" method="post" name="adminForm" id="adminForm">
		<table class="acymailing_table_options">
			<?php if($this->app->isAdmin()){ ?>
			<tr>
				<td nowrap="nowrap" width="100%">
					<?php acymailing_listingsearch($this->pageInfo->search); ?>
				</td>
				<td nowrap="nowrap">
					<?php echo $this->filters->list;
					echo $this->filters->creator;
					echo $this->filters->date;
					echo $this->filters->type;
					echo $this->filters->tags; ?>
				</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td nowrap="nowrap" width="100%">
					<?php acymailing_listingsearch($this->pageInfo->search); ?>
				</td>
				<td>
					<?php echo $this->filters->list; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $this->filters->tags; ?>
				</td>
				<td valign="top">
					<?php echo $this->filters->date; ?>
				</td>
			</tr>
			<?php } ?>
		</table>

		<table class="acymailing_table">
			<thead>
			<tr>
				<th class="title titlenum">
					<?php echo acymailing_translation('ACY_NUM'); ?>
				</th>
				<th class="title titlebox">
					<input type="checkbox" name="toggle" value="" onclick="acymailing_js.checkAll(this);"/>
				</th>
				<th class="title" colspan="3">
					<?php echo JHTML::_('grid.sort', acymailing_translation('JOOMEXT_SUBJECT'), 'a.subject', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
				</th>
				<?php if($this->app->isAdmin()){ ?>
					<th class="title titlelist" style="text-align: left;">
						<?php echo acymailing_translation('LISTS'); ?>
					</th>
				<?php } ?>
				<th class="title titledate">
					<?php echo JHTML::_('grid.sort', acymailing_translation('SEND_DATE'), 'a.senddate', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
				</th>
				<th class="title titlesender">
					<?php echo JHTML::_('grid.sort', acymailing_translation('SENDER_INFORMATIONS'), 'a.fromname', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
				</th>
				<th class="title titlesender">
					<?php echo JHTML::_('grid.sort', acymailing_translation('CREATOR'), 'b.name', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
				</th>
				<?php if($this->app->isAdmin()){ ?>
					<th class="title titletoggle">
						<?php echo JHTML::_('grid.sort', acymailing_translation('JOOMEXT_VISIBLE'), 'a.visible', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
					</th>
					<th class="title titletoggle">
						<?php echo JHTML::_('grid.sort', acymailing_translation('ACY_PUBLISHED'), 'a.published', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
					</th>
				<?php } ?>
				<th class="title titleid">
					<?php echo JHTML::_('grid.sort', acymailing_translation('ACY_ID'), 'a.mailid', $this->pageInfo->filter->order->dir, $this->pageInfo->filter->order->value); ?>
				</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="11">
					<?php echo $this->pagination->getListFooter();
					echo $this->pagination->getResultsCounter();
					if(ACYMAILING_J30) echo '<br />'.$this->pagination->getLimitBox(); ?>
				</td>
			</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			$i = 0;
			foreach($this->rows as &$row){
				$publishedid = 'published_'.$row->mailid;
				$visibleid = 'visible_'.$row->mailid;
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center" style="text-align:center">
						<?php echo $this->pagination->getRowOffset($i); ?>
					</td>
					<td align="center" style="text-align:center">
						<?php echo JHTML::_('grid.id', $i, $row->mailid); ?>
					</td>
					<td align="center" style="text-align:center; width: 25px;">
						<?php
						if(acymailing_level(2)){
							if(acymailing_isAllowed($this->config->get('acl_statistics_manage', 'all')) && !empty($row->senddate)){
								if($this->app->isAdmin()){
									$urlStat = acymailing_completeLink('diagram&task=mailing&mailid='.$row->mailid, true);
								}else{
									$urlStat = acymailing_completeLink('frontdiagram&task=mailing&mailid='.$row->mailid, true);
								} ?>
								<span class="acystatsbutton"><a class="modal hasTooltip" data-original-title="<?php echo acymailing_translation('STATISTICS') ?>" rel="{handler: 'iframe', size: {x: 800, y: 590}}"
																href="<?php echo $urlStat; ?>"><?php echo ($this->app->isAdmin()) ? '<i class="acyicon-statistic"></i>' : '<img src="'.ACYMAILING_IMAGES.'icons/icon-16-stats.png" alt="'.acymailing_translation('STATISTICS', true).'"/>'; ?></a></span>
							<?php }
						} ?>
					</td>
					<td align="center" style="text-align:center; width: 18px;">
						<?php
						if($this->app->isAdmin()){
							if(acymailing_level(3) && acymailing_isAllowed($this->config->get('acl_'.$this->aclCat.'_abtesting', 'all')) && !empty($row->abtesting)){
								$abDetail = unserialize($row->abtesting);
								$urlAbTest = acymailing_completeLink('newsletter&task=abtesting&mailid='.$abDetail['mailids'], true);
								?>
								<span class="acyabtestbutton"><a class="modal hasTooltip" data-original-title="<?php echo acymailing_translation('ABTESTING') ?>" rel="{handler: 'iframe', size: {x: 800, y: 590}}"
																 href="<?php echo $urlAbTest; ?>"><?php echo ($this->app->isAdmin()) ? '<i class="acyicon-ABtesting"></i>' : '<img src="'.ACYMAILING_IMAGES.'icons/icon-16-acyabtesting.png" alt="'.acymailing_translation('ABTESTING', true).'"/>'; ?></a></span>
							<?php }
						}
						?>
					</td>
					<td>
						<?php
						$row->subject = Emoji::Decode($row->subject);
						$subjectLine = acymailing_dispSearch($row->subject, $this->pageInfo->search);
						echo acymailing_tooltip('<b>'.acymailing_translation('JOOMEXT_ALIAS').' : </b>'.acymailing_dispSearch($row->alias, $this->pageInfo->search), ' ', '', $subjectLine, acymailing_completeLink(($this->app->isAdmin() ? '' : 'front').'newsletter&task=edit&mailid='.$row->mailid));
						?>
					</td>
					<?php if($this->app->isAdmin()){ ?>
						<td>
							<?php
							if(!empty($this->mailToLists[$row->mailid])){
								foreach($this->mailToLists[$row->mailid] as $oneList){
									echo '<div class="roundsubscrib roundsub" style="background-color:'.htmlspecialchars($this->listColor[$oneList]->color, ENT_COMPAT, 'UTF-8').';">'.acymailing_tooltip('', $this->listColor[$oneList]->name, '', '&nbsp;&nbsp;&nbsp;&nbsp;').'</div>';
								}
							}
							?>
						</td>
					<?php } ?>
					<td align="center" style="text-align:center">
						<?php echo acymailing_getDate($row->senddate);
						if(!empty($row->countqueued) && acymailing_isAllowed($this->config->get('acl_queue_delete', 'all'))){ ?>
							<br/>
							<button class="acymailing_button"
									onclick="if(confirm('<?php echo str_replace("'", "\'", acymailing_translation_sprintf('ACY_VALID_DELETE_FROM_QUEUE', $row->countqueued)); ?>')){ window.location.href = '<?php echo JURI::base(); ?>index.php?option=com_acymailing&ctrl=<?php if(!JFactory::getApplication()->isAdmin()) echo 'front'; ?>newsletter&task=cancelNewsletter&<?php echo acymailing_getFormToken(); ?>=1&mailid=<?php echo $row->mailid; ?>'; } return false;"><?php echo acymailing_translation('ACY_CANCEL'); ?></button>
						<?php } ?>
					</td>
					<td align="center" style="text-align:center">
						<?php
						if(empty($row->fromname)) $row->fromname = $this->config->get('from_name');
						if(empty($row->fromemail)) $row->fromemail = $this->config->get('from_email');
						if(empty($row->replyname)) $row->replyname = $this->config->get('reply_name');
						if(empty($row->replyemail)) $row->replyemail = $this->config->get('reply_email');
						if(!empty($row->fromname)){
							$text = '<b>'.acymailing_translation('FROM_NAME').' : </b>'.$row->fromname;
							$text .= '<br /><b>'.acymailing_translation('FROM_ADDRESS').' : </b>'.$row->fromemail;
							$text .= '<br /><br /><b>'.acymailing_translation('REPLYTO_NAME').' : </b>'.$row->replyname;
							$text .= '<br /><b>'.acymailing_translation('REPLYTO_ADDRESS').' : </b>'.$row->replyemail;
							echo acymailing_tooltip($text, ' ', '', $row->fromname);
						}
						?>
					</td>
					<td align="center" style="text-align:center">
						<?php
						if(!empty($row->name)){
							$text = '<b>'.acymailing_translation('JOOMEXT_NAME').' : </b>'.$row->name;
							$text .= '<br /><b>'.acymailing_translation('ACY_USERNAME').' : </b>'.$row->username;
							$text .= '<br /><b>'.acymailing_translation('JOOMEXT_EMAIL').' : </b>'.$row->email;
							$text .= '<br /><b>'.acymailing_translation('ACY_ID').' : </b>'.$row->userid;
							echo acymailing_tooltip($text, $row->name, '', $row->name, 'index.php?option=com_users&task=edit&cid[]='.$row->userid);
						}
						?>
					</td>
					<?php if($this->app->isAdmin()){ ?>
						<td align="center" style="text-align:center">
							<span id="<?php echo $visibleid ?>" class="loading"><?php echo $this->toggleClass->toggle($visibleid, (int)$row->visible, 'mail') ?></span>
						</td>
						<td align="center" style="text-align:center">
							<span id="<?php echo $publishedid ?>" class="loading"><?php echo $this->toggleClass->toggle($publishedid, (int)$row->published, 'mail') ?></span>
						</td>
					<?php } ?>
					<td width="1%" align="center">
						<?php echo $row->mailid; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
				$i++;
			}
			?>
			</tbody>
		</table>

		<input type="hidden" name="option" value="<?php echo ACYMAILING_COMPONENT; ?>"/>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="ctrl" value="<?php echo JRequest::getCmd('ctrl'); ?>"/>
		<input type="hidden" name="boxchecked" value="0"/>
		<input type="hidden" name="filter_order" value="<?php echo $this->pageInfo->filter->order->value; ?>"/>
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->pageInfo->filter->order->dir; ?>"/>
		<?php echo JHTML::_('form.token'); ?>
	</form>
</div>
