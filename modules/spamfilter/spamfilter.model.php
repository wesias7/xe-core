<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @class  spamfilterModel
 * @author NAVER (developers@xpressengine.com)
 * @brief The Model class of the spamfilter module
 */
class spamfilterModel extends spamfilter
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
		return $oModuleModel->getModuleConfig('spamfilter');
	}

	/**
	 * @brief Return the list of registered IP addresses which were banned
	 */
	function getDeniedIPList()
	{
		$args = new stdClass();
		$args->sort_index = "regdate";
		$args->page = Context::get('page')?Context::get('page'):1;
		$output = executeQuery('spamfilter.getDeniedIPList', $args);
		if(!$output->data) return;
		if(!is_array($output->data)) return array($output->data);
		return $output->data;
	}

	/**
	 * @brief Check if the ipaddress is in the list of banned IP addresses
	 */
	function isDeniedIP()
	{
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		$ip_list = $this->getDeniedIPList();
		if(!count($ip_list)) return new Object();

		$count = count($ip_list);
		for($i=0;$i<$count;$i++)
		{
			$ip = str_replace('.', '\.', str_replace('*','(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)',$ip_list[$i]->ipaddress));
			if(preg_match('/^'.$ip.'$/', $ipaddress, $matches)) return new Object(-1,'msg_alert_registered_denied_ip');
		}

		return new Object();
	}

	/**
	 * @brief Return the list of registered Words which were banned
	 */
	function getDeniedWordList()
	{
		$args = new stdClass();
		$args->sort_index = "hit";
		$output = executeQuery('spamfilter.getDeniedWordList', $args);
		if(!$output->data) return;
		if(!is_array($output->data)) return array($output->data);
		return $output->data;
	}

	/**
	 * @brief Check if the text, received as a parameter, is banned or not
	 */
	function isDeniedWord($text)
	{
		$word_list = $this->getDeniedWordList();
		if(!count($word_list)) return new Object();

		$count = count($word_list);
		for($i=0;$i<$count;$i++)
		{
			$word = $word_list[$i]->word;
			if(preg_match('/'.preg_quote($word,'/').'/is', $text))
			{
				$args->word = $word;
				$output = executeQuery('spamfilter.updateDeniedWordHit', $args);
				return new Object(-1,sprintf(Context::getLang('msg_alert_denied_word'), $word));
			}
		}

		return new Object();
	}

	/**
	 * @brief Check the specified time
	 */
	function checkLimited()
	{

		// TODO: 글 갯수가 1개일 경우 처리로직 구현, 허용횟수를 초과했을 경우, 계산방식 수정
		$config = $this->getConfig();

		if(!$config->interval1 && !$config->interval2) return new Object();

		$conditions = array();
		
		$conditions[0]->interval = $config->interval1;
		$conditions[0]->limit_count = $config->limit_count1;
		$conditions[0]->limit_time = $config->limit_time1;
		
		$conditions[1]->interval = $config->interval2;
		$conditions[1]->limit_count = $config->limit_count2;
		$conditions[1]->limit_time = $config->limit_time2;
		
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		foreach($conditions as $cond)
		{
			//최근 로그를 limit_count만큼 가져온다.
			$logs = $this->getLog($cond->limit_count+1); // regdate로 내림차순으로 리턴 +1: 현재접속도 이미 로그이 기록되어 있으므로

			//최근 로그가 limit_count만큼 안되면 continue;
			$count = count($logs);
			if($count < $cond->limit_count) continue;
			debugPrint($logs);			

			//최근 로그 1번과 limit_count번의 시간차이(used_interval) 계산
			$current_time = ztime(array_shift($logs)->regdate); 
			$last_time = ztime(array_shift($logs)->regdate);
			$first_time = ztime(array_pop($logs)->regdate);
			$used_interval =  $last_time - $first_time;

			// used_interval이 interval보다 크면 continue;
			if($used_interval > $cond->interval) continue;
			
			// used_interval이 interval보다 작으면 최근 등록글 1번과 지금 시간차이(standby_time)를 계산
			$standby_time = $current_time - $last_time;
			
			// standby_time가 limit_time보다 짧으면 return Obejct(-1,..);
			if($standby_time < $cond->limit_time) return new Object(-1, '지정된 시간에 너무 많은 등록시도를 하였습니다. '.$cond->limit_time.'초후에 등록할 수 있습니다!');
		}

		return new Object();
	}

	/**
	 * @brief Check if the trackbacks have already been registered to a particular article
	 */
	function isInsertedTrackback($document_srl)
	{
		$oTrackbackModel = &getModel('trackback');
		$count = $oTrackbackModel->getTrackbackCountByIPAddress($document_srl, $_SERVER['REMOTE_ADDR']);
		if($count>0) return new Object(-1, 'msg_alert_trackback_denied');

		return new Object();
	}

	/**
	 * @brief Return the number of logs recorded within the interval for the specified IPaddress
	 */
	function getLog($limit_count)
	{
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		
		$args->ipaddress = $ipaddress;
		$args->list_count = $limit_count;
		$output = executeQueryArray('spamfilter.getLog', $args);
		return $output->data;
	}

	/**
	 * @brief Return the number of logs recorded within the interval for the specified IPaddress
	 */
	function getLogCount($time = 60, $ipaddress='')
	{
		if(!$ipaddress) $ipaddress = $_SERVER['REMOTE_ADDR'];

		$args->ipaddress = $ipaddress;
		$args->regdate = date("YmdHis", time()-$time);
		$output = executeQuery('spamfilter.getLogCount', $args);
		$count = $output->data->count;
		return $count;
	}
}
/* End of file spamfilter.model.php */
/* Location: ./modules/spamfilter/spamfilter.model.php */
