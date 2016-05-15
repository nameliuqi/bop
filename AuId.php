<?php 
function query_AuId($AuId)
{
	$ch = curl_init();
		$timeout = 3000;
		$url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Composite(AA.AuId=".$AuId.")&count=10000&attributes=AA.AfId,Id&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
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
			if(!in_array($values['Id'],$son['Id']))	array_push($son['Id'], $values['Id']);
			//echo $values['Id']."<br>";
			foreach ($values['AA'] as $key => $AA) {
				# code...
				if(!in_array($AA,$son['AfId']))	array_push($son['AfId'], $AA);
			}
		}
		//print_r($son);
		return $son;
}

//$AuId = "2145115012";
//query_AuId($AuId);


 ?>