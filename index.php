<?php
	include 'Id.php';
	include 'CId.php';
	include 'FId.php';
	include 'liuqi.php';
	include 'JId.php';
	include 'AuId.php';
	include 'AfId.php';
	// $id1 = $_GET["id1"];
	// $id2 = $_GET["id2"];
	error_reporting(0);
	function liuqiQueryId($id)
	{
		// echo $id;
		// echo "<br />";
		$ch = curl_init();
		$timeout = 3000;
		$url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=".$id."&count=10000&attributes=Id,AA.AuId,F.FId,J.JId,C.CId,RId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
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
		// var_dump($arr);
	}
	function blank()
	{
		echo "<br />=========================================================================<br />";
	}

	function judge2($id)
	{
		$type = 1;
		$res = liuqiQueryId($id);
		if (count($res["entities"][0])==3)
		{
			$type = 0;
		}
		return $type;
	}
	function getRId($arr)
	{
		return $arr["entities"][0]["RId"];
	}

	function getJID($arr)
	{
		return $arr["entities"][0]["J"]["JId"];
	}

	function getCId($arr)
	{
		return $arr["entities"][0]["C"]["CId"];
	}

	function getAuId($arr)
	{
		return $arr["entities"][0]["AA"];
	}

	function getFId($arr)
	{
		return $arr["entities"][0]["F"];
	}

	function id_to_id($id1,$di2)
	{
		$res1 = liuqiQueryId($id1);
		$res1 = $res1["entities"][0]["RId"];
		$ans = 0;
		foreach ($res1 as $key1 => $value1) {
			if ($value1 == $id2)
			{
				$ans = 1;
				break;
			}
		}
		return $ans;
	}

	function id_to_some_to_id($id1,$id2)
	{
		$res1 = liuqiQueryId($id1);
		$RId1 = @getRId($res1);
		$path = array();
		foreach ($RId1 as $key1 => $value1) {
			$temp = liuqiQueryId($value1);
			$tempRId = @getRId($temp);
			foreach ($tempRId as $key2 => $value2) {
				if ($value2 == $id2)
				{
					array_push($path, $value2);
				}
			}
		}
		$res2 = liuqiQueryId($id2);
		$j1 = @getJID($res1);
		$j2 = @getJID($res2);
		if ($j1 == $j2)
			if (!is_null($j1))
			array_push($path, $j1);
		$c1 = @getCId($res1);
		$c2 = @getCId($res2);
		if ($c1==$c2)
			if (!is_null($c1))
				array_push($path, $c1);
		$f1 = @getFId($res1);
		$f2 = @getFId($res2);
		if ($f1==$f2)
		{
			foreach ($f1 as $key => $value) {
				# code...
				if (!is_null($value))
					array_push($path, $value);
			}
		}
		$au1 = @getAuId($res1);
		$au2 = @getAuId($res2);
		if ($au1==$au2)
		{
			foreach ($au1 as $key => $value) {
				# code...
				if (!is_null($value))
					array_push($path, $value);
			}	
		}
		// $au1 = @getA
		$ans = array();
		foreach ($path as $key => $value) {
			if (!is_null($value))
			{
				$temp = array($id1,$value,$id2);
				array_push($ans, $temp);
			}
		}
		return $ans;
	}
	// var_dump(judge(2251253715));
	// judge()

	// query(123740306);
	// blank();
	$id1 = $_GET["id1"];
	$id2 = $_GET["id2"];
	$ans = array();
	if (judge2($id1))
		if (judge2($id2))
		{
			if (id_to_id($id1,$id2))
			{
				array_push($ans, array($id1,$id2));
			}
			$hop2 = id_to_some_to_id($id1,$id2);
			if (count($hop2)>0)
				$ans = array_merge($ans,$hop2);
		}

	if (judge2($id1)==1)
		if(judge2($id2)==0){
			$a3 = one_hop_auid($id1,$id2);
		}
	if (count($a3)>0)
	{
		$ans = array_merge($ans,$a3);
	}
	// if(judge($id2)=="liuqiQueryId"){
	// 	$a4 = one_hop_id($id1,$id2);
	// }
	$jans = json_encode($ans);
	echo $jans;

	// $testArr = array(2180737804,2251253715,189831743,2147152072,2310280492,2332023333,57898110,2332023333,2014261844,57898110,2180737804,2251253715,189831743,2147152072,2310280492,2332023333,57898110,2332023333,2014261844,57898110,2180737804,2251253715,189831743,2147152072,2310280492,2332023333,57898110,2332023333,2014261844,57898110);
	// var_dump($testArr);
	// blank();
	// foreach ($testArr as $value) {
	// 	var_dump($value);
	// 	blank();
	// 	$temp = liuqiQueryId($value);
	// 	var_dump($temp);
	// 	blank();
	// 	# code...
	// }
	// echo '<br />use time:'.round($t2-$t1,4).' s<br />';
	/**测试不同get方式的速度
	*$t1 = microtime(true);
	*$url =  "http://oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=".$id."&count=10000&attributes=Id,AA.AuId,AA.AfId&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
	*$html = file_get_contents($url);
	*var_dump($html);
	*$t2 = microtime(true);
	*echo '<br />use time:'.round($t2-$t1,4).' s<br />';
	*/
?>