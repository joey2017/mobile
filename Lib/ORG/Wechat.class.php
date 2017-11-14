<?php
class Wechat {
		/**
	 * 分析XML内容 
	 * 
	 * @access protected
	 * 
	 * @param string $xml, xml内容
	 * 
	 * @return array
	 */
	public static function parseXml($xml){
		$xml = simplexml_load_string($xml);
		
		if($xml === false)
			return array();
		
		$data = array();
		
		foreach($xml as $k => $v)
			$data[$k] = (string)$v;
		
		return $data;
	}



	/**
	 * 给用户发送文本客服消息 
	 * 
	 * @access public
	 * 
	 * @param string	$text,			文本消息
	 * @param string	$openid,		微信用户openid
	 * @param string	$access_token,	全局access_token
	 * 
	 * @return mixed
	 */
	public function sendTextMessage($text, $openid, $access_token){
		$data = array(
			'touser'	=> $openid,
			'msgtype'	=> 'text',
			'text'		=> array('content' => $text)
		);
	
		return self::_sendCustomMessage($data, $access_token);
	}

		/**
	 * 给用户发送图片客服消息 
	 * 
	 * @access public
	 * 
	 * @param string	$image,			图片消息
	 * @param string	$openid,		微信用户openid
	 * @param string	$access_token,	全局access_token
	 * 
	 * @return mixed
	 */
	public function sendImageMessage($mediaid, $openid, $access_token){
		$url='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;		
		$img = '{"touser":"'.$openid.'","msgtype":"image","image": {"media_id":"'.$mediaid.'" }}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$img);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if(curl_errno($ch)){
			echo 'Errno:'.curl_error($ch);
			exit;
		}
		curl_close($ch);
	}

	protected static function _sendCustomMessage($data, $access_token){
		$data	= self::urlEncodeDeep($data);
		$post	= urldecode(json_encode($data));
		$url	='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
		$result	= self::getRemoteData($url, $post);
		
		if(empty($result))
			return array('error' => '远程服务器未响应');
		
		$result = @json_decode($result, true);
		
		if(isset($result['errcode']) && $result['errcode'] == -1)
			self::_sendCustomMessage($access_token, $data);
			
		return $result;
	}

	/**
	 * 通过cURL或socket获取/发送远程数据
	 * 
	 * @access public
	 * 
	 * @param string	$url,	远程URL
	 * @param mixed		$post,	POST数据，如果为空则使用GET方式
	 * @param string	$file,	本地文件路径，如果设置了该参数则使用POST方式上传数据，请使用绝对路径传递文件信息
	 * 
	 * @return string
	 */
	public static function getRemoteData($url, $post=false, $file=null){
		$content = '';
		
		if(!function_exists('curl_init'))
			return '';
			
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		
		// 文件上传
		if(!empty($file)){
			if(class_exists('CURLFile'))
				$post = array('media' => new CURLFile(realpath($file)));
			else
    			$post = array('media' => '@'.realpath($file));
		}
		
		// POST方式
		if($post){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		
		$content .= curl_exec($ch);
		curl_close($ch);
		
		return $content;
	}


		/**
	 * url编码
	 * 
	 * @access public
	 *  
	 * @param array $value, 需要处理的数据，支持多维数组
	 * 
	 * @return array
	 */
	public static function urlEncodeDeep($value){
		if(is_array($value))
			$value = array_map('self::urlEncodeDeep',$value);
		elseif(is_object($value)){
			$vars = get_object_vars($value);
	
			foreach($vars as $key => $data)
				$value->{$key} = self::urlEncodeDeep($data);
		}
		elseif(is_string($value))
			$value = urlencode($value);
		
		return $value;
	}


	// //获取token
	// public  function get_acc_token()
	// {
	// 	$mem = new Memcache; 
	// 	$mem->connect('localhost', 11211) or die ("Could not connect"); 		
	// 	$access_token = $mem->get('access_token');
	// 	if(!$access_token){
	// 		//获取access_token
	// 		$ch = curl_init();
	// 		$timeout = 5;
	// 		curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxbd68bd4fe539eba2&secret=f2c29cdcbf2543e7531aef5e7651585c");
	// 		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// 		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// 		$access_token = curl_exec($ch);
	// 		$access_token=json_decode($access_token, true); 
	// 		$mem->set('access_token',$access_token['access_token'],0,7000);
	// 		return $access_token['access_token'];
	// 	}else{
	// 		return $access_token;
	// 	}	
		
	// }

	//获取用户个人信息
	public function get_wx_info($openid,$access_token)
	{
		//$opendid=$openid;
		//$access_token=get_acc_token();		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$return = curl_exec($ch);
		curl_close($ch);
		return json_decode($return, true);
	}

	/**
	 * 设置自定义菜单
	 * 
	 * @access public
	 * 
	 * @param array $menu,	多维数组格式，参数如下：
	 *  array(
	 *  	// 只有一级菜单
	 *  	array(
	 *  		'name'			=> '一级菜单',
	 *  		'type'			=> '菜单类型，可选值请查阅微信开发文档',
	 *  		'key'			=> '自定义键值，当菜单为非view类型时有效',
	 *  		'url'			=> '菜单链接，仅菜单类型为view有效'
	 *  	),
	 *  	// 包含二级菜单
	 *  	array(
	 *  		'name'			=> '一级菜单',
	 *  		'sub_button'	=> array(
	 *  			array(
	 *  				'name'		=> '二级菜单',
	 *  				'type'		=> '菜单类型，可选值请查阅微信开发文档',
	 *  				'key'		=> '自定义键值，当菜单为非view类型时有效',
	 *  				'url'		=> '菜单链接，仅菜单类型为view有效'
	 *  			)
	 *  		)
	 *  	)
	 *  )
	 *  
	 * @param string	$access_token,	全局access_token	
	 * 
	 * @return array
	 */
	public function sendCustomMenu($menu, $access_token){
		// if(!is_array($menu) || count($menu) > 3)
		// 	return array('error' => 'menu参数不正确');
		
		// //;
		// $menu	= self::urlEncodeDeep($menu);
		// $menu	= urldecode(json_encode($menu));

		// $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
		// $result	= self::getRemoteData($url,$menu);
		
		// if(empty($result))
		// 	return array('error' => '远程服务器未响应');
		
		// return @json_decode($result, true);
		$menu	= array('button' => $menu);
		$timeout = 5;
		$jsonData	= urldecode(json_encode($menu));		
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;		

		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		var_dump($result);exit;
		$result=json_decode($result,true); 
	}


}
?>