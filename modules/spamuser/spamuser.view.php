<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class  spamuserView
 * @author NAVER (developers@xpressengine.com)
 * @brief View class of spamuser module
 */
class spamuserView extends spamuser
{
	function init()
	{
	}

	function dispSpamuserManage()
	{
		if(!Context::get('is_logged')) return new Object(-1,'msg_not_permitted');
		// check grant is manage
		$grant = Context::get('grant');
		if(!$grant->manager) return new Object(-1,'msg_not_permitted');

		$memberr_srl = Context::get('member_srl');
		$oMemberModel = &getModel('member');
		$member_info = $oMemberModel->getMemberInfoByMemberSrl($member_srl);

		Context::set('member_info',$member_info);

		// Add "html string" to $content by trigger call
		$content = '';
		// Call a trigger (before)
		ModuleHandler::triggerCall('spamuser.dispSpamuserMnage', 'before', $content);

		Context::set('content', $content);

		// Select Pop-up layout
		$this->setLayoutPath('./common/tpl');
		$this->setLayoutFile('popup_layout');

		$this->setTemplatePath($this->module_path.'tpl');
		$this->setTemplateFile('manage');
	}

}
/* End of file spamuser.view.php */
/* Location: ./modules/spamuser/spamuser.view.php */
