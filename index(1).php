<?php 
	include 'Id.php';
	include 'CId.php';
	include 'FId.php';
	include 'liuqi.php';
	include 'JId.php';
	include 'AuId.php';
	include 'AfId.php';

	$id1 = "2140251882";
	$id2 = "2140251882";//此处id2是作者id
	if(judge($id2)=="queryAuId"){
		print_r( one_hop_auid($id1,$id2) );
	}

	if(judge($id2)=="queryId"){
		print_r( one_hop_id($id1,$id2));
		print_r(two_hop_id($id1,$id2));
/*
		$id1_RId = $id1_son['RId'];
		$id2_Id = $id2_son['Id'];

		foreach ($id1_RId as $key => $value) {
			if(in_array($value,$id2_Id)) 
			{
				echo "id1的一个rid: ".$value."和作者所做的一个id相同，id1可达id2<br>";			
			}
		}
*/	}


//$CId = "1135342153";
//query_FId($CId);
	

 ?>