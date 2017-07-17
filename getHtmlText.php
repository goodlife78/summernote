<?php
//setlocale(LC_ALL,'ko_KR.UTF-8');//한글파일명 깨짐 방지

$getHtml = file_get_contents("php://input");
$newHtml="";

if(strpos($getHtml, "<img") > 0){
	$arrImg = explode("<img", $getHtml);
	//foreach($arrImg as $value){
	for ($i=1;$i<count($arrImg);$i++){
		$value = $arrImg[$i];
		//echo $value;
		
		$filename = strstr(substr(strstr($value, 'data-filename="'),15), '"', true);
		$data = strstr(strstr($value, "data:image"), '" data-filename', true);
		$putData = substr($data, strpos($data, ',')+1);
		
		
		//file_put_contents("./upload/$filename", base64_decode($putData));
		//한글파일명으로 저장
		file_put_contents("./upload/".iconv('UTF-8','CP949',$filename), base64_decode($putData));
		
		/*
		$fp = fopen("./upload/$filename", "w");
		if(fwrite($fp,base64_decode($putData))==false) echo "fwrite fail!!<br>";
		else echo "fwrite success<br>";
		fclose($fp);
		*/
		echo "<img src='./upload/$filename' >";
		
		$newHtml = str_replace($data, "./upload/$filename", $getHtml);
		
	}


	echo "<br>-----------------------------------------<br>";
	echo "<img src=data:image/jpeg;base64,$putData> <br>";
	echo "<img src=$data> <br>";
}

echo $getHtml . "<br>";

echo $newHtml;



?>