<?php
	$spam_result = $_POST['result'];
//$spam_result = '{"2919615264":"not_sure","1663232781\r":"norm","2789854302\r":"not_sure","2804798114\r":"norm","2159524303\r":"not_sure","1583216597\r":"not_exist","2790061604\r":"not_sure","2919655100\r":"not_exist","2920340052\r":"not_sure"}';

	$result = array();
	$filename = 'result.txt';
	$str = "";	

	#合并成字符串
	$json_result = json_decode($spam_result,true);
	foreach ($json_result as $key => $value) {
		$str .= $key."    ".$value."\r\n";
	}
// var_dump($json_result);
// var_dump($str);

	if ($fh = fopen($filename, "w")) {
		fwrite($fh, $str);
		$result['isSaved']=TRUE;
	}
	else
	{
		$result['isSaved']=FALSE;
	}
	fclose($fh);	
	
//	$result['spam_result']=$spam_result;

	echo json_encode($result);
?>