<?php
	// $id1 = $_GET["id1"];
	// $id2 = $_GET["id2"];

	function query_id($id)
	{
		$ch = curl_init();
		$timeout = 3000;
		$url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=".$id."&count=10000&attributes=Id,J.JId,RId,F.FId,C.CId,AA.AuId,AA.AfId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		$arr = json_decode($file_contents,TRUE);
		$entities = $arr['entities'][0];
		if( empty($entities)) return;  //判断是不是空
		$son = array('Id'=>array(),'AuId'=>array(),'AfId'=>array(),'FId'=>array(),'CId'=>array(),'JId'=>array(),'RId'=>array());
		if(array_key_exists("AA",$entities)){
			foreach ($entities['AA'] as $keys => $values) {
				foreach ($values as $key => $value) {
					if(!in_array($value,$son[$key]))array_push($son[$key],$value);
				}
			}
		}
		if(array_key_exists("F",$entities)){
			if(count($entities['F'])==1) array_push($son['FId'],$entities['F']["FId"]);
			else{
				for($i=0;$i<count($entities['F']);$i++)	
					if(!in_array($entities['F'][$i]["FId"],$son['FId'])) array_push($son['FId'],$entities['F'][$i]["FId"]);
			}
		}
		if(array_key_exists("C",$entities)){
			if(count($entities['C'])==1) array_push($son['CId'],$entities['C']["CId"]);
			else{
				for($i=0;$i<count($entities['C']);$i++)
					if(!in_array($entities['C'][$i]["CId"],$son['CId'])) array_push($son['CId'],$entities['C'][$i]["CId"]);
			}
		}if(array_key_exists("J",$entities)){
			if(count($entities['J'])==1) array_push($son['JId'],$entities['J']["JId"]);
			else{
				for($i=0;$i<count($entities['J']);$i++) 
					if(!in_array($entities['J'][$i]["JId"],$son['JId'])) array_push($son['JId'],$entities['J'][$i]["JId"]);
			}
		}
		if(array_key_exists("RId",$entities)){
			$son['RId'] = $entities['RId'];
		}
		//print_r($son);
		return $son;
	}

	

/*	$id = "2140251882";
	$t1 = microtime(true);
	query_id($id);
	$t2 = microtime(true);
	echo '<br />use time:'.round($t2-$t1,4).' s<br />';
*/


	/**测试不同get方式的速度
	*$t1 = microtime(true);
	*$url =  "http://oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=".$id."&count=10000&attributes=Id,AA.AuId,AA.AfId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
	*$html = file_get_contents($url);
	*var_dump($html);
	*$t2 = microtime(true);
	*echo '<br />use time:'.round($t2-$t1,4).' s<br />';
	*/
?>