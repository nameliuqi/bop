<?php 
function query_AfId($AfId)
{
	$ch = curl_init();
		$timeout = 3000;
		$url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Composite(AA.AfId=".$AfId.")&count=10000&attributes=AA.AuId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		$arr = json_decode($file_contents,TRUE);
		//echo ($file_contents);
		//print_r($arr);
		$entities = $arr['entities'];
		if( empty($entities)) return;
		$son = array('Id'=>array(),'AuId'=>array(),'AfId'=>array(),'FId'=>array(),'CId'=>array(),'JId'=>array(),'RId'=>array());
		//print_r($entities);
		foreach ($entities as $keys => $values) {
			# code...
			
			//echo $values['Id']."<br>";
			foreach ($values['AA'] as $key => $AA) {
				# code...
				//print_r($AA);
				//echo $AA['AuId']."<br>";
				if(!in_array($AA['AuId'],$son['AuId']))	array_push($son['AuId'], $AA['AuId']);
			}
		}
		//print_r($son);
		return $son;
}

//$AfId = "1290206253";
//query_AuId($AfId);


 ?>