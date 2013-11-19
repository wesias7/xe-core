/* 스팸머 처리 */
/*
function doSpamuserManage(member_srl, mid, loop, confirm_message) {
	if(loop == undefined)
		loop = 0;
	if(loop == 0)
		if(!confirm(confirm_message))	return false;
	var params = new Array();
	params['member_srl'] = member_srl;
	params['mid'] = mid;
	params['loop'] = loop;
	exec_xml('member', 'procSpamuserManage', params, completeSpamuserManage );
}

function completeSpamuserManage(reg_obj, response_tags) {
	setTimeout( function() {
		doSpamuserManage(member_srl, mid, 1, confirm_message);
	}, 1000 );
}
*/
