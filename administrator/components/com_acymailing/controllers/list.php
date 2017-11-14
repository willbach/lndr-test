<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.7.0
 * @author	acyba.com
 * @copyright	(C) 2009-2017 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php

class ListController extends acymailingController{

	var $pkey = 'listid';
	var $table = 'list';
	var $groupMap = 'type';
	var $groupVal = 'list';
	var $aclCat = 'lists';

	function store(){
		if(!$this->isAllowed($this->aclCat, 'manage')) return;
		JRequest::checkToken() or die('Invalid Token');

		$listClass = acymailing_get('class.list');
		$status = $listClass->saveForm();
		if($status){
			acymailing_enqueueMessage(acymailing_translation('JOOMEXT_SUCC_SAVED'), 'message');
			if($listClass->newlist){
				$listid = JRequest::getInt('listid');
				acymailing_enqueueMessage('<a href="index.php?option=com_acymailing&ctrl=filter&listid='.$listid.'">'.acymailing_translation_sprintf('SUBSCRIBE_LIST').'</a>', 'message');
			}
		}else{
			acymailing_enqueueMessage(acymailing_translation('ERROR_SAVING'), 'error');
			if(!empty($listClass->errors)){
				foreach($listClass->errors as $oneError){
					acymailing_enqueueMessage($oneError, 'error');
				}
			}
		}
	}

	function remove(){
		if(!$this->isAllowed($this->aclCat, 'delete')) return;

		JRequest::checkToken() or die('Invalid Token');

		$listIds = JRequest::getVar('cid', array(), '', 'array');

		$listClass = acymailing_get('class.list');
		$num = $listClass->delete($listIds);

		acymailing_enqueueMessage(acymailing_translation_sprintf('SUCC_DELETE_ELEMENTS', $num), 'message');

		JRequest::setVar('layout', 'listing');
		return parent::display();
	}
}
