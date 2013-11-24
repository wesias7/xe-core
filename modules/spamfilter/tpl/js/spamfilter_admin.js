/**
 * @brief 금지 IP 삭제
 **/
function doDeleteDeniedIP(ipaddress) {
	var fo_obj = get_by_id('spamfilterDelete');
    fo_obj.ipaddress.value = ipaddress;
	fo_obj.act.value = "procSpamfilterAdminDeleteDeniedIP";
	fo_obj.submit();
}

/**
 * @brief 금지 단어 삭제
 **/
function doDeleteDeniedWord(word) {
	var fo_obj = get_by_id('spamfilterDelete');
	fo_obj.word.value = word;
	fo_obj.act.value = "procSpamfilterAdminDeleteDeniedWord";
	fo_obj.submit();
}

function doDeleteCondition(button) {
	jQuery(button).parents('div.x_controls').find('input').val('');
	doSetConditionPreview();
}

function doSetConditionPreview(){
	var div = jQuery('div.block_config'); 
	div.find('input').each(function(i){
		var name = jQuery(this).attr('name');
		var value = jQuery(this).val()?jQuery(this).val():'-';
		div.find('strong.'+ name).text(value);			
	})
}
jQuery(function($) {

	doSetConditionPreview();
	$('.block_config input').change(function(){
		doSetConditionPreview(this);
	})
});