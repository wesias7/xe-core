<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class  spamuserController
 * @author NAVER (developers@xpressengine.com)
 * @brief The controller class for the spamuser module
 */
class spamuserController extends spamuser
{
	/**
	 * @brief Initialization
	 */
	function init()
	{
	}

	function triggerGetDocumentMenu(&$menu_list)
	{
		$is_logged = Context::get('is_logged');
		$logged_info = Context::get('logged_info');

		$mid = Context::get('mid');

		$document_srl = Context::get('target_srl');

		$oDocumentModel = &getModel('document');
		$columnList = array('document_srl', 'module_srl', 'member_srl', 'ipaddress');
		$oDocument = $oDocumentModel->getDocument($document_srl, false, false, $columnList);
		$member_srl = $oDocument->get('member_srl');

		if(!$member_srl) return new Object();
		if(!$is_logged) return new Object();
		if($oDocumentModel->grant->manager != 1 || $member_srl==$logged_info->member_srl) return new Object();

		$oDocumentController = &getController('document');
		$url = getUrl('','module','spamuser','act','dispSpamuserManage','member_srl',$member_srl,'mid',$mid);
		$oDocumentController->addDocumentPopupMenu($url,'cmd_spamuser_manage','','popup');

		return new Object();
	}

	function procSpamuserManage()
	{
		if(!Context::get('is_logged')) return new Object(-1,'msg_not_permitted');
		// check grant is manage
		$grant = Context::get('grant');
		if(!$grant->manager) return new Object(-1,'msg_not_permitted');

		$member_srl = Context::get('member_srl');
		$loop = Context::get('loop');

		if($loop == 0) {
				
		}
		
	}
}
/* End of file spamuser.controller.php */
/* Location: ./modules/spamuser/spamuser.controller.php */
