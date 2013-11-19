<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class  spamuserModel
 * @author NAVER (developers@xpressengine.com)
 * @brief The Model class of the spamuser module
 */
class spamuserModel extends spamuser
{
	/**
	 * @brief Initialization
	 */
	function init()
	{
	}

	/**
	 * @brief Return the user setting values of the Spam filter module
	 */
	function getConfig()
	{
		// Get configurations (using the module model object)
		$oModuleModel = &getModel('module');
		return $oModuleModel->getModuleConfig('spamuser');
	}
}
/* End of file spamuser.model.php */
/* Location: ./modules/spamuser/spamuser.model.php */
