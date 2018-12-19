<?php
header("Access-Control-Allow-Origin: *");
// var_dump($_FILES);exit();
$data = [];
$data['status'] = 'error';
$filename = time().$_FILES['file']['name'];
if(move_uploaded_file($_FILES['file']['tmp_name'],'F:/0mytest/ngframe2/build/images/img/'.$filename)){  
	$data['status'] = 'success';
	$data['name'] = $filename;
	$data['path'] = 'images/img/'.$filename;  
} 
echo json_encode($data); 
