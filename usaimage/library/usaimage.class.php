<?php
/**
 * usa图片库
 * 这个类表示一个图片和这个图片对象的方法集
 * @author	ouxz
 */
class UsaImage{
	protected static $allowtype = null;
	private static function GetAllowType(){
		return array(
			IMAGETYPE_GIF =>(image_type_to_mime_type(IMAGETYPE_GIF)),
			IMAGETYPE_JPEG=>(image_type_to_mime_type(IMAGETYPE_JPEG)),
			IMAGETYPE_PNG=>(image_type_to_mime_type(IMAGETYPE_PNG))
		);
	}
	//图片资源符
	var $image = null;
	//图片的路径
	var $filepath = null;
	//图片类型
	var $type = null;
	//图片宽度
	var $w = 10;
	//图片高度
	var $h = 10;
	//背景颜色
	var $bgcolor = array(255,255,255,0);
	//是否透明
	var $alpha = 0;
	
	/**
	 * 构造函数
	 * @param array $options
	 * array(
	 * 		'filepath'	-->图片的路径，如果指定文件路径，其他的配置将不起作用
	 * 		'w'			-->新建图片的宽
	 * 		'h'			-->新建图片的高
	 * 		'bgcolor'	-->新建图片的背景颜色
	 * 		'type'		-->新建图片的类型，IMAGETYPE 系列常量值
	 * )
	 */
	public function __construct($options=array()){
		self::$allowtype = self::GetAllowType();
		$this->SetOption($options);
		$this->init();
	}
	/**
	 * 设置图片的宽度
	 * @param number $w
	 * @return void
	 */
	public function SetWidth($w){
		$this->w = $w;
	}
	/**
	 * 设置图片的高度
	 * @param number $h
	 * @return void
	 */
	public function SetHeight($h){
		$this->h = $h;
	}
	/**
	 * 取得图片的宽度
	 * @return number
	 */
	public function GetWidth(){
		return $this->w;
	}
	/**
	 * 取得图片的高度
	 * @return number
	 */
	public function GetHeight(){
		return $this->h;
	}
	/**
	 * 取得图片输出头部
	 * @return String
	 */
	public function GetHead($type=null){
		if(!isset(self::$allowtype[$type])){
			$nowtype = $this->type;
		}else{
			$nowtype = self::$allowtype[$type];
		}
		return 'Content-type: ' . $nowtype;
	}
	/**
	 * 输出图片
	 * @return void
	 */
	public function Write($type=null){
		if(!isset(self::$allowtype[$type])){
			$nowtype = $this->type;
		}else{
			$nowtype = self::$allowtype[$type];
		}
		header($this->GetHead($nowtype));
		switch($nowtype){
			case self::$allowtype[IMAGETYPE_GIF]:
				imagegif($this->image);
				break;
			case self::$allowtype[IMAGETYPE_JPEG]:
				imagejpeg($this->image);
				break;
			case self::$allowtype[IMAGETYPE_PNG]:
				imagepng($this->image);
				break;
		}
		//return $this;
	}
	/**
	 * 裁剪图片
	 * @param number $w
	 * 宽
	 * @param number $h
	 * 高
	 * @param number $x
	 * x位置
	 * @param number $y
	 * y位置
	 * @return $this
	 *	
	 */
	public function Crop($w,$h,$x=0,$y=0){
		$w = (int)$w; $h = (int)$h; $x = (int)$x; $y = (int)$y;
		if(empty($w) or empty($h)) return $this;
		$tmp = $this->createImage($w,$h); 
		imagecopy($tmp,$this->image,0,0,$x,$y,$w,$h);
		imagedestroy($this->image);
		$this->w = $w;
		$this->h = $h;
		$this->image = $tmp;
		return $this;
	}
	/**
	 * 缩放图片，按比例缩放
	 * @param $ratio
	 * 缩放比例，值范围: 0 < $ratio 
	 * @return $this
	 */
	public function Scale($ratio=1){
		$ratio = (int)$ratio;
		empty($ratio) or $ratio = 1;
		$w = round($this->w * $ratio);
		$h = round($this->h * $ratio);
		$tmp = imagecreatetruecolor($w,$h);
		imagecopyresized($tmp,$this->image,0,0,0,0,$w,$h,$this->w,$this->h);
		imagedestroy($this->image);
		$this->image = $tmp;
		$this->w = $w;
		$this->h = $h;
		return $this;
	}
	/**
	 * 缩放图片，按最大尺寸缩放
	 * @param $maxW
	 * 最大宽
	 * @param $maxH
	 * 最大高
	 * @return $this
	 * 
	 */
	public function Scale3($maxW=0,$maxH=0){
		$maxW = (int)$maxW; $maxH = (int)$maxH;
		if(empty($maxW) and empty($maxH)) return $this;
		if(!empty($maxW) and !empty($maxH)){
			if($maxW/$maxH >= $this->w/$this->h){
				$ratio = $maxH / $this->h;
			}else{
				$ratio = $maxW / $this->w;
			}
		}
		if(empty($maxW) and !empty($maxH)){
			$ratio = $maxH / $this->h;
		}
		if(!empty($maxW) and empty($maxH)){
			$ratio = $maxW / $this->w;
		}
		$w = $ratio * $this->w;
		$h = $ratio * $this->h;
		$tmp = $this->createImage($w, $h);
		imagecopyresized($tmp,$this->image,0,0,0,0,$w,$h,$this->w,$this->h);
		imagedestroy($this->image);
		$this->image = $tmp;
		$this->w = $w;
		$this->h = $h;
		return $this;
	}
	/**
	 * 缩放裁剪图片,图片会等比例放入设置的大小内，如果$isCrop为真，则拉伸裁剪
	 * @param $w 
	 * 宽
	 * @param $h
	 * 高
	 * @param $isCrop
	 * 是否拉伸裁剪
	 * @return $this
	 */
	public function Scale2($w,$h,$isCrop=false){
		if(empty($w) or empty($h)) return $this;
		$tmp = $this->createImage($w, $h);
		if($isCrop){
			$isWidth = round($this->w/$this->h) >= round($w / $h);
			//var_dump($isWidth);
			if($isWidth){
				$ratio = $h / $this->h;
				$dw = $ratio * $this->w;
				$dh = $ratio * $this->h;
				$dx = ($w/2) - ($dw/2);
				$dy = 0;
				imagecopyresized($tmp,$this->image,$dx,$dy,0,0,$dw,$dh,$this->w,$this->h);
			}else{
				$ratio = $w / $this->w;
				$dw = $ratio * $this->w;
				$dh = $ratio * $this->h;
				$dx = 0;
				$dy = (($h/2) - ($dh/2));
				//echo $ratio . '  ' . $dw .'  ' . $dh . '  ' . $dx . '  '. $dy;
				imagecopyresized($tmp,$this->image,$dx,$dy,0,0,$dw,$dh,$this->w,$this->h);
			}
		}else{
			$isWidth = round($this->w/$this->h) >= round($w / $h);
			if($isWidth){
				$ratio = $w /$this->w;
				$dw = $ratio * $this->w;
				$dh = $ratio * $this->h;
				$dx = 0;
				$dy = ($h/2)-($dh/2);
				imagecopyresized($tmp,$this->image,$dx,$dy,0,0,$dw,$dh,$this->w,$this->h);
			}else{
				$ratio = $h /$this->h ;
				$dw = $ratio * $this->w;
				$dh = $ratio * $this->h;
				$dx = ($w/2)-($dw/2);
				$dy = 0;
				imagecopyresized($tmp,$this->image,$dx,$dy,0,0,$dw,$dh,$this->w,$this->h);
			}
		}
		imagedestroy($this->image);
		$this->image = $tmp;
		$this->w = $w;
		$this->h = $h;
		return $this;
	}
	/**
	 * 叠加一张图片到当前
	 * @param String $filepath
	 * 图片路径
	 * @param number $x
	 * 要放置的x位置
	 * @param number $y
	 * 要放置的y位置
	 * @param number $ratio 
	 * 缩放倍数，可以为小数
	 * @return $this
	 */
	public function Overlap($filepath,$x,$y,$ratio=1){
		is_numeric($ratio) or ($ratio = 1);
		$ratio = abs($ratio);
		if(file_exists($filepath)){
			$info = getimagesize($filepath);
			if(!in_array($info['mime'],self::$allowtype)){
				return $this;
			}
			$x = (int)$x; $y = (int)$y;
			$newlevel = $this->getimage($filepath);
			imagecopyresized($this->image,$newlevel,$x,$y,0,0,$info[0]*$ratio,$info[1]*$ratio,$info[0],$info[1]);
		}
		return $this;
	}
	
	/**
	 * 叠加一张图片到当前
	 * @param String $filepath
	 * 图片路径
	 * @param number $loc
	 * 位置，为数组类型,包含 可能包含 left , top , right ,bottom 键值
	 * @param number $ratio 
	 * 缩放倍数，可以为小数
	 * @return $this
	 */
	public function Overlap2($filepath,$loc=array(),$ratio=1){
		is_numeric($ratio) or ($ratio = 1);
		$ratio = abs($ratio);
		if(file_exists($filepath)){
			$info = getimagesize($filepath);
			if(!in_array($info['mime'],self::$allowtype)){
				return $this;
			}
			$newlevel = $this->getimage($filepath);
			if(empty($loc)){
				$x = 0;
				$y = 0;
			}
			if(isset($loc['right'])){
				$x = $this->w - $info[0]*$ratio - $loc['right'];
			}
			if(isset($loc['left'])){
				$x = (int)$loc['left'];
			}
			if(isset($loc['bottom'])){
				$y = $this->h - $info[1]*$ratio - (int)$loc['bottom'] ;
			}
			if(isset($loc['top'])){
				$y = (int)$loc['top'];
			}
			imagecopyresized($this->image,$newlevel,$x,$y,0,0,$info[0]*$ratio,$info[1]*$ratio,$info[0],$info[1]);
		}
		return $this;
	}
	/**
	 * 保存为文件
	 * @param $filepath
	 * 存在图片的路径，
	 * @return $this
	 * 
	 */
	public function Save($filepath){
		$filename = basename($filepath);

		$dirpath = preg_match('/[\\/]/im',$filepath) ? (dirname($filepath) . '/') : '';

		$fix = end(explode('.',$filename));
		if(!empty($dirpath) and !file_exists($dirpath)){
			throw new Exception("保存路径不存在!");
		}
		switch($fix){
			case 'gif':
				imagegif($this->image,$dirpath . $filename);
				break;
			case 'jpg':
				imagejpeg($this->image,$dirpath  . $filename);
				break;
			case 'png':
				iamgepng($this->image,dirpath  . $filename);
				break;
			default:
		}
		return $this;
	}
	//设置配置参数
	private function SetOption($options){
		if(empty($options))return false;
		isset($options['filepath']) and ($this->filepath = $options['filepath']);
		isset($options['w']) and ($this->w = $options['w']);
		isset($options['h']) and ($this->h = $options['h']);
		isset($options['bgcolor']) and ($this->bgcolor = $options['bgcolor']);
		isset($options['type']) ? ($this->type = $options['type']) : ($this->type = image_type_to_mime_type(IMAGETYPE_JPEG));
	}
	//初始化
	private function init(){
		if(empty($this->filepath)){
			$this->image = imagecreatetruecolor($this->w,$this->h);
			imagefill($this->image,0,0,imagecolorresolvealpha($this->image,$this->bgcolor[0],$this->bgcolor[1],$this->bgcolor[2],127));
		}else{
			if(file_exists($this->filepath)){
				$info = getimagesize($this->filepath);
				$this->w = $info[0];
				$this->h = $info[1];
				$this->type = $info['mime'];
				if(!in_array($this->type,self::$allowtype)){
					throw new Exception("图片类型不允许!");
				}
				if(!$this->image = $this->getimage($this->filepath)){
					throw new Exception("图片类型不允许!");
				}
			}
		}
	}
	//获得图片的资源符
	private function getimage($filepath){
		$info = getimagesize($filepath);
		$tmp2 = null;
		switch($info['mime']){
			case self::$allowtype[IMAGETYPE_GIF]:
				$tmp2 =  imagecreatefromgif($filepath);
				break;
			case self::$allowtype[IMAGETYPE_JPEG]:
				$tmp2 = imagecreatefromjpeg($filepath);
				break;
			case self::$allowtype[IMAGETYPE_PNG]:
				$tmp2 = imagecreatefrompng($filepath);
				break;
		}
		imageantialias($tmp2,true);
		imagealphablending($tmp2,false);
		imagesavealpha($tmp2,true);
		return $tmp2;
	}
	//创建空白图片资源
	private function createImage($w,$h,$bgcolor=array()){
		$bgcolor = array_merge($this->bgcolor,$bgcolor);
		$tmp = imagecreatetruecolor($w,$h);
		imagefill($tmp,0,0,imagecolorallocatealpha($tmp,$bgcolor[0],$bgcolor[1],$bgcolor[2],127));
		imagealphablending($tmp,false);
		imagesavealpha($tmp,true);
		imageantialias($tmp,true);
		return $tmp;
	}
}