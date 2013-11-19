<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class spamuser 
 * @author NAVER (developers@xpressengine.com)
 * @brief The parent class of the spamuser module
 */
class spamuser extends ModuleObject
{
	/**
	 * @brief Additional tasks required to accomplish during the installation
	 */
	function moduleInstall()
	{
		$oModuleController = &getController('module');
		$oModuleController->insertTrigger('document.getDocumentMenu', 'spamuser', 'controller', 'triggerGetDocumentMenu', 'before');
/*
		// Register action forward (to use in administrator mode)
		$oModuleController = &getController('module');
		// 2007.12.7 The triggers which try to perform spam filtering when new posts/comments/trackbacks are registered
		$oModuleController->insertTrigger('document.insertDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before');
		$oModuleController->insertTrigger('comment.insertComment', 'spamuser', 'controller', 'triggerInsertComment', 'before');
		$oModuleController->insertTrigger('trackback.insertTrackback', 'spamuser', 'controller', 'triggerInsertTrackback', 'before');
		// 2008-12-17 Add a spamuser for post modification actions
		$oModuleController->insertTrigger('comment.updateComment', 'spamuser', 'controller', 'triggerInsertComment', 'before');
		$oModuleController->insertTrigger('document.updateDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before');
*/
		return new Object();
	}

	/**
	 * @brief A method to check if the installation has been successful
	 */
	function checkUpdate()
	{
		$oDB = &DB::getInstance();
		$oModuleController = &getController('module');
		$oModuleController->insertTrigger('document.getDocumentMenu', 'spamuser', 'controller', 'triggerGetDocumentMenu', 'before');
/*
		$oModuleModel = &getModel('module');
		// 2007.12.7 The triggers which try to perform spam filtering when new posts/comments/trackbacks are registered
		if(!$oModuleModel->getTrigger('document.insertDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before')) return true;
		if(!$oModuleModel->getTrigger('comment.insertComment', 'spamuser', 'controller', 'triggerInsertComment', 'before')) return true;
		if(!$oModuleModel->getTrigger('trackback.insertTrackback', 'spamuser', 'controller', 'triggerInsertTrackback', 'before')) return true;
		// 2008-12-17 Add a spamuser for post modification actions
		if(!$oModuleModel->getTrigger('comment.updateComment', 'spamuser', 'controller', 'triggerInsertComment', 'before')) return true;
		if(!$oModuleModel->getTrigger('document.updateDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before')) return true;
*/
		return false;
	}

	/**
	 * @brief Execute update
	 */
	function moduleUpdate()
	{
		$oDB = &DB::getInstance();
		$oModuleController = &getController('module');
		$oModuleController->insertTrigger('document.getDocumentMenu', 'spamuser', 'controller', 'triggerGetDocumentMenu', 'before');
/*
		$oModuleModel = &getModel('module');
		$oModuleController = &getController('module');
		// 2007.12.7 The triggers which try to perform spam filtering when new posts/comments/trackbacks are registered
		if(!$oModuleModel->getTrigger('document.insertDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before'))
			$oModuleController->insertTrigger('document.insertDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before');
		if(!$oModuleModel->getTrigger('comment.insertComment', 'spamuser', 'controller', 'triggerInsertComment', 'before'))
			$oModuleController->insertTrigger('comment.insertComment', 'spamuser', 'controller', 'triggerInsertComment', 'before');
		if(!$oModuleModel->getTrigger('trackback.insertTrackback', 'spamuser', 'controller', 'triggerInsertTrackback', 'before'))
			$oModuleController->insertTrigger('trackback.insertTrackback', 'spamuser', 'controller', 'triggerInsertTrackback', 'before');
		// 2008-12-17 Add a spamuser for post modification actions
		if(!$oModuleModel->getTrigger('comment.updateComment', 'spamuser', 'controller', 'triggerInsertComment', 'before'))
		{
			$oModuleController->insertTrigger('comment.updateComment', 'spamuser', 'controller', 'triggerInsertComment', 'before');
		}
		// 2008-12-17 Add a spamuser for post modification actions
		if(!$oModuleModel->getTrigger('document.updateDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before'))
		{
			$oModuleController->insertTrigger('document.updateDocument', 'spamuser', 'controller', 'triggerInsertDocument', 'before');
		}
*/
		return new Object(0,'success_updated');
	}

	/**
	 * @brief Re-generate the cache file
	 */
	function recompileCache()
	{
	}
}
/* End of file spamuser.class.php */
/* Location: ./modules/spamuser/spamuser.class.php */
