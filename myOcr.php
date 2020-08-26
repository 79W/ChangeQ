<?php
//倒入api
require_once 'AipOcr.php';

//判断是否有文件传输
if(empty($_FILES["imageFile"])){
    //为空直接返回错误
    echo "请上传图片";
    //结束
    die();
}else{
    //有东西
    $image = $_FILES['imageFile'];
    //判断后缀名
	$image_extension = array("png","jpeg","jpeg");
	//以数组返回
	$data = (pathinfo($image["name"]));
	//判断是否有这个后缀
	if(!in_array($data['extension'], $image_extension)){
		echo "请上传正确的图片类型";
		die();
	}
}
//设置文件路径
$imageSavePath = "./upload/".$_FILES["imageFile"]["name"];
$imagePath = "upload/".$_FILES["imageFile"]["name"];
//将文件移动过去
move_uploaded_file($_FILES["imageFile"]["tmp_name"],$imageSavePath);
// 你的 APPID AK SK
const APP_ID = '22190578';
const API_KEY = 'TbMTRwMVIzyVsA7ZxNxtQcaT';
const SECRET_KEY = 'bYs0fnAfO8qRNNWoenY3OQjEVWU81kAe';
//创建服务
$client = new AipOcr(APP_ID, API_KEY, SECRET_KEY);
//获取图片
$ocrImage = file_get_contents($imageSavePath);
// 如果有可选参数
$options = array();
//添加个参数 是否检测图像朝向
$options["detect_direction"] = "true";
// 带参数调用通用文字识别（高精度版）
$res = $client->basicAccurate($ocrImage,$options);
//把图片路径也返回去
$res['imageUrl'] = $imagePath;
//返回
echo json_encode($res);	

?>