<?php

define("TOKEN", "1220aa97dea8f");
class WeixinAction extends BaseAction
{
	protected $wxAPI = null;
	public function index(){
		$this->weixinInit();

    	//验证微信访问有效性
        $this->checkSignature();

    	$xml = file_get_contents('php://input');
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];

		// 接收微信消息
		if(!empty($xml)){

			$xml = $this->wxAPI->parseXml($xml);

			// 判断消息类型
			if(!empty($xml['MsgType'])){

				switch($xml['MsgType']){
					// 事件推送
					case 'event':
						switch($xml['Event']){
							// 进入会话
							case 'ENTER':
							break;

							// 上报地理位置
							case 'LOCATION':
							break;

							// 点击菜单
							case 'CLICK':

							break;

							// 跳转菜单
							case 'VIEW':
							break;

							// 扫描二维码
							case 'SCAN':
								$this->attention_store($xml);
							break;

							// 首次关注
							case 'subscribe':
								if($xml['EventKey']=='last_trade_no_4006252001201607148977025442')
									$this->replyMessage($xml);
								else{
									// $file  = 'log.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
									// file_put_contents($file,'获取内容:'.$xml['EventKey'],FILE_APPEND);
									$key=explode('_',$xml['EventKey']);
									$xml['EventKey']=$key[1];
									$this->attention_store($xml);
									// if($key[1]==0){
									// 	$this->replyMessage($xml);
									// }else{

									// }

								}
							break;

							// 取消关注
							case 'unsubscribe':
							break;
						}
					break;

					// 文本消息
					case 'text':

						$this->replyMessage($xml);
					break;

					// 图文消息
					case 'image':

					break;

					// 语音消息
					case 'voice':

					break;

					// 视频消息
					case 'video':

					break;

					// 小视频消息
					case 'shortvideo':

					break;

					// 地理位置消息
					case 'location':

					break;

					// 链接消息
					case 'link':

					break;
				}
			}
		}
    	exit;
	}


    /**
	 * 初始化微信API实例
	 */
	private function weixinInit(){
		import('@.ORG.Wechat');
		if(!$this->wxAPI)
		$this->wxAPI = new Wechat();
	}




	/**
	 * 关键字匹配自动回复
	 */
	private function replyMessage($data){
		$this->weixinInit();
		$token=getshopAccToken();

		$result =$this->wxAPI->sendTextMessage('车堂盛世汽车服务大平台欢迎您！车堂盛世(集团)控股车宝堂汽车服务连锁、印象汽车服务学校、诚车堂汽车网！我们致力于为广大车主提供最优质、最便捷的人.车.生活服务生态圈！ \n我们的愿景：成为中国汽车后市场最有影响力的推动者、领导者 我们的宗旨:全心全意为车主服务！\n我们的目标：\n一期：南宁市实现300家优质汽车服务门店（计划2016年底前）\n二期：广西实现1000家优质汽车服务门店（计划2017年底前） \n三期：全国实现10000家优质汽车服务门店（计划2020年底前）\n汽车服务，我们认真且用心的，感谢您的信任和关注！服务热线：400  0771  527', $data['FromUserName'],$token);

	}

	//扫描二维码
	public function attention_store($data){
		$this->weixinInit();

		//二维码id
		$qrcode_id=intval($data['EventKey']);

		//微信token
		$token = getshopAccToken();


		//二维码信息
	  	$qrcode_info=M('agent_qrcode')->where('id='.$qrcode_id)->find();

	  	//type=1为供应商,2为门店
	  	if($qrcode_info['type']==1){
	  		$sup_name=M('pms_supplier')->where('id='.$qrcode_info['shop_id'])->getField('name');
	  	}else{
	  		$sup_name=M('supplier_location')->where('id='.$qrcode_info['shop_id'])->getField('name');
	  	}

	  	//获取用户微信基本信息
	    $user_data=$this->wxAPI->get_wx_info($data['FromUserName'],$token);

  		/*$send_info=$sup_name==''?'车堂盛世':$sup_name;
  		$send_info.="邀您成为车堂盛世合伙人。";*/
  		$send_info = "亲，你终于来了！我们为你的门店量身定制【订货管理小助手】+【门店微商城微营销小助手】为你的门店推广、发展助力，记得分享和互动哦！";

  		$fans=M('agent_fans')->where("open_id='".$data['FromUserName']."'")->find();

  		if($fans==null)//首次访问
  		{
  			$d['open_id']=$data['FromUserName'];
	  		$d['qrcode_id']=intval($qrcode_id);
			$d['shop_id']=intval($qrcode_info['shop_id']);
			$d['shop_type']=intval($qrcode_info['type']);
			$d['location_id']=0;
			$d['is_vip']=0;
			$d['add_time']=time();
  			$d['nickname']=$user_data['nickname'];

  			M('agent_fans')->add($d);
  		}else{
  			if($fans['is_submit']==0){
  				//更新扫描信息
	  			$d['qrcode_id']=intval($qrcode_id);
	  			if(($qrcode_info['shop_id']==$fans['shop_id']&&$qrcode_info['type']!=$fans['shop_type'])||($qrcode_info['shop_id']!=$fans['shop_id']&&$qrcode_info['type']==$fans['shop_type'])||($qrcode_info['shop_id']!=$fans['shop_id']&&$qrcode_info['type']!=$fans['shop_type'])){
	  				$d['shop_id']=intval($qrcode_info['shop_id']);
					$d['shop_type']=intval($qrcode_info['type']);
					$d['shop_user_id']=0;
	  			}
				$d['add_time']=time();
	  			$d['nickname']=$user_data['nickname'];
	  			M('agent_fans')->where('id='.$fans['id'])->save($d);
  			}

  		}

		$result = $this->wxAPI->sendTextMessage($send_info,$data['FromUserName'],$token);
		// $this->sendTestMessage($data['FromUserName'],$token);


	}

	//发多图文消息
	public function sendTestMessage($openid,$token){
		// $this->weixinInit();
		// //微信token
		// $token = getshopAccToken();

		$send_info=array(array('title'=>urlencode('合伙人福利'),'description'=>'','url'=>urlencode('http://m.17cct.com/index.php/Agent/welfare.html'),'picurl'=>urlencode('http://image.17cct.com/images/fxspecial/1.jpg')),array('title'=>urlencode('如何成为合伙人'),'description'=>'','url'=>urlencode('http://m.17cct.com/index.php/Agent/join.html'),'picurl'=>urlencode('http://image.17cct.com/images/fxspecial/11.jpg')),array('title'=>urlencode('快速推广'),'description'=>'','url'=>urlencode('http://m.17cct.com/index.php/Agent/spread.html'),'picurl'=>urlencode('http://image.17cct.com/images/fxspecial/12.jpg')));

		$data = array(
			'touser'	=> $openid,
			'msgtype'	=> 'news',
			'news'		=> array('articles' => $send_info)
		);

		$data=urldecode(json_encode($data));

		$url	='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if(curl_errno($ch)){
			echo 'Errno:'.curl_error($ch);
			exit;
		}
		curl_close($ch);
		//var_dump($result);
	}

	//验证微信信息来源
	private function checkSignature()
	{
       	$file  = 'log.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
		file_put_contents($file,'获取内容:'.$xml,FILE_APPEND);

        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr	= isset($_GET['echostr'])	? $_GET['echostr']		: '';

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if($tmpStr!= $signature ){
			echo 'The signature is not match.';
			die;
		}

		// 微信接口验证
		if($echostr !== ''){
			echo $echostr;
			die();
		}

	}

	//生成商家二维码
	public function qrcode(){
		$id=intval($_REQUEST['id']);
		$account_token=getshopAccToken();
		$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$account_token;

		$json=array();
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		//for ($i=945; $i<947; $i++) {

		$json['action_name']="QR_LIMIT_SCENE";
		$json['action_info']=array('scene'=>array('scene_id'=>$id));
		$jsonData=json_encode($json);

		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);

		$result = curl_exec($ch);
		$result=json_decode($result);
		//var_dump($result->ticket);exit;

		echo '<img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result->ticket.'">';


	}


   public function create_menu(){

	   	 /* $menu=array(
		   	array(
		   		'name'=> '做合伙人',
		   		'sub_button'	=> array(
		   			array(
		   				'name'=> '如何加入',
		   				'type'=> 'view',
		   				'key'=> '如何加入',
		   				'url'=> 'http://m.17cct.com/index.php/Agent/join.html'
		   			),array(
		   				'name'=> '快速推广',
		   				'type'=> 'view',
		   				'key'=> '快速推广',
		   				'url'=> 'http://m.17cct.com/index.php/Agent/spread.html'
		   			),array(
		   				'name'=> '成为合伙人',
		   				'type'=> 'view',
		   				'key'=> '成为合伙人',
		   				'url'=> 'http://m.17cct.com/index.php/Agent/index.html'
		   			)
		   		)
		   	 ),array(
		   		'name'=> '商户登录',
		   		'sub_button'	=> array(
		   			array(
		   				'name'=> '供应商登录',
		   				'type'=> 'view',
		   				'key'=> '供应商登录',
		   				'url'=> 'http://m.17cct.com/index.php/Supplier/login.html'
		   			),array(
		   				'name'=> '门店登录',
		   				'type'=> 'view',
		   				'key'=> '门店登录',
		   				'url'=> 'http://m.17cct.com/index.php/Biz/login.html'
		   			)
		   		)
		   	 )
		   	 );
	   	array(
		   		'name'=> urlencode('我的门店'),
		   		'type'=> 'view',
		   		'url'=> 'http://m.17cct.com/index.php/Biz/login.html'
		   	),
		   	array(
		   		'name'=> urlencode('抽奖活动'),
		   		'type'=> 'view',
		   		'url'=> 'http://m.17cct.com/index.php/Lottery/index.html'
		   	),
		   	array(
		   		'name'=> urlencode('我的'),
		   		'type'=> 'view',
		   		'url'=> 'http://m.17cct.com/index.php/User/index.html'
		   	)*/
		   	//20170620修改
		   /*$json[0]['name']=urlencode('做合伙人');
		   $json[0]['sub_button']=array(array('name'=>urlencode('合伙人福利'),'type'=>'view','url'=>urlencode('http://m.17cct.com/index.php/Agent/welfare.html')),array('name'=>urlencode('如何加入'),'type'=>'view','url'=>urlencode('http://m.17cct.com/index.php/Agent/join.html')),array('name'=>urlencode('快速推广'),'type'=>'view','url'=>'http://m.17cct.com/index.php/Agent/spread.html'),array('name'=>urlencode('成为合伙人'),'type'=>'view','url'=>'http://m.17cct.com/index.php/Agent/index.html'));

		   $json[1]['name']=urlencode('商户登录');
		   $json[1]['sub_button']=array(array('name'=>urlencode('供应商登录'),'type'=>'view','url'=>'http://m.17cct.com/index.php/Supplier/login.html'),array('name'=>urlencode('门店登录'),'type'=>'view','url'=>'http://m.17cct.com/index.php/Biz/login.html'));*/

		   $json[0]['name']=urlencode('供应商登录');
		   $json[0]['type']='view';
		   $json[0]['url']='http://m.17cct.com/index.php/SupLogin/login.html';

		   $json[1]['name']=urlencode('门店登录');
		   $json[1]['type']='view';
		   $json[1]['url']='http://m.17cct.com/index.php/Biz/login.html';

   		$this->weixinInit();
		$account_token=getshopAccToken();

		$r=$this->wxAPI->sendCustomMenu($json,$account_token);
		var_dump($r);exit;


		 // {
		 //     "button":[
		 //     {	
		 //          "type":"click",
		 //          "name":"今日歌曲",
		 //          "key":"V1001_TODAY_MUSIC"
		 //      },
		 //      {
		 //           "name":"菜单",
		 //           "sub_button":[
		 //          ]
		 //       }]
		 // }
   }

}
?>