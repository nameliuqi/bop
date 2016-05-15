<?php 
function query_FId($FId)
{
    $ch = curl_init();
        $timeout = 3000;
        $url =  "oxfordhk.azure-api.net/academic/v1.0/evaluate?expr=Id=123740306&count=10000&attributes=Id&subscription-key=f7cc29509a8443c5b3a5e56b0e38b5a6";
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        var_dump($file_contents);
        curl_close($ch);
        $arr = json_decode($file_contents,TRUE);
        echo ($file_contents);
        $entities = $arr['entities'];
        $son = array('AuId'=>array(),'AfId'=>array(),'FId'=>array(),'CId'=>array(),'JId'=>array(),'RId'=>array());
        print_r($file_contents);
        print_r($son);
}

$FId = "123740306";
query_FId($FId);

echo 1;
 ?>
