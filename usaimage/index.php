<?php
include 'library/usaimage.class.php';
//实例化类
$image = new UsaImage(array('filepath'=>'image1.jpg'));

$image->Save('../image1.jpg');exit;

//裁剪
$image->Crop(500,500,50,50)->Write(IMAGETYPE_JPEG);exit;

//图片图片覆盖一张图片,第二和第三参数为,要放置的x,y位置
$image->Overlap("image99.gif", 10, 10)
	  //以相对位置来覆盖图片，最后一个参数为缩放比例，默认为1
	  ->Overlap2('image00.gif',array('right'=>23,'bottom'=>50),0.5)
	  //缩放图片，设置最大宽和最大高，图片会等比例缩放
	  ->Scale3(300,300)
	  //输出到屏幕，自动会加上图片头部，类型为jpg，IMAGETYPE_JPEG 为php的gb库的常量
	  ->Write(IMAGETYPE_JPEG);
