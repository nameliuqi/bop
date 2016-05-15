<?php 
//刘奇的直接返回的版本
	function queryId($id)
	{
		// echo $id;
		// echo "<br />";
		$ch = curl_init();
		$timeout = 3000;
		$url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=".$id."&count=10000&attributes=Id,AA.AuId,AA.AfId,F.FId,J.JId,C.CId,RId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
		// $url = "baidu.com";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		// var_dump($file_contents);
		//json解析为php数组
		$arr = json_decode($file_contents,TRUE);
		return $arr;
		var_dump($arr);
	}
	function judge($id)
	{
		$type = "queryId";
		$res = queryId($id);
		if (count($res["entities"][0])==3)
		{
			$type = "queryAuId";
		}
		return $type;
	}
	function one_hop_id($id1,$id2){
		$id1_son = query_id($id1);	
		$id1_RId = $id1_son['RId'];
		$res = array();
		foreach ($id1_RId as $key => $value) {
			if($value = $id2) 
			{
				$res = array($id1,$id2);
				return $res;
			}
		}
		return $res;
	}

	function two_hop_id($id1,$id2){
		$id1_son = query_id($id1);	
		$id1_RId = $id1_son['RId'];
		$res = array();
		
		$id2_son = query_id($id2); 
		$id1_AuId = $id1_son['AuId'];
		$id2_AuId = $id2_son['AuId'];
		
		foreach ($id1_AuId as $key => $value) {
			if(in_array($value,$id2_AuId)) 
			{
				array_push($res, array($id1,$value,$id2));
			}
		}

		$id1_CId = $id1_son['CId'];
		$id2_CId = $id2_son['CId'];
		foreach ($id1_CId as $key => $value) {
			if(in_array($value,$id2_CId)) array_push($res, array($id1,$value,$id2));
		}
	

		$id1_JId = $id1_son['JId'];
		$id2_JId = $id2_son['JId'];
		foreach ($id1_JId as $key => $value) {
			if(in_array($value,$id2_JId)) array_push($res, array($id1,$value,$id2));
		}
	

		$id1_FId = $id1_son['FId'];
		$id2_FId = $id2_son['FId'];
		foreach ($id1_FId as $key => $value) {
			if(in_array($value,$id2_FId)) array_push($res, array($id1,$value,$id2));
		}
		return $res;
	}

	function one_hop_auid($id1,$id2)
	{
		$id1_son = query_id($id1);
		$id2_son = query_Auid($id2);
		
		$id1_AuId = $id1_son['AuId'];
		
		if(in_array($id2,$id1_AuId)) return array($id1,$id2);
		/*
		$id1_RId = $id1_son['RId'];
		$id2_Id = $id2_son['Id'];

		foreach ($id1_RId as $key => $value) {
			if(in_array($value,$id2_Id)) 
			{
				return 1;			
			}
		}
		*/
		return array();
	}

	function two_hop_auid($id1,$id2)
	{
		$id1_son = query_id($id1);
		$id2_son = query_Auid($id2);
		
		$id1_AuId = $id1_son['AuId'];
		
		if(in_array($id2,$id1_AuId)) return 1;
		/*
		$id1_RId = $id1_son['RId'];
		$id2_Id = $id2_son['Id'];

		foreach ($id1_RId as $key => $value) {
			if(in_array($value,$id2_Id)) 
			{
				return 1;			
			}
		}
		*/
		return 0;
	}

 ?>