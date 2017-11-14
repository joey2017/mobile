<?php
// 本类由系统自动生成，仅供测试用途
import("@.ORG.GetPin");
class TestAction extends BaseAction {

	public function index()
	{

			var_dump(ctype_alpha('ABC'));exit;
				//$jsonData='{"touser":"o7of3jmvbrorDVyQlwzqoAnfhUso","template_id":"GWWYDd-GO3MUqbm2_lqbQdNRrAIJwByGpVfJEeK6D4Q","url":"http://weixin.qq.com/download","topcolor":"#FF0000","data":{"User": {"value":"陆先生","color":"#173177"},"Date":{"value":"06月07日 19时24分","color":"#173177"},"CardNumber":{"value":"0426","color":"#173177"},"Type":{"value":"消费","color":"#173177"},"Money":{"value":"人民币260.00元","color":"#173177"},"DeadTime":{"value":"06月07日19时24分","color":"#173177"},"Left":{"value":"6504.09","color":"#173177"}}				}';
				/*$json=array("touser"=>"o7of3jir5REYXhvc8y8Ahv0Dg8hI",
							"template_id"=>"D8I1mgLS3PJNVzCT-ZgX7eDiIY-lXo9Eluj3AnWqDhA",
							"url"=>"http://weixin.17cct.com",
							"topcolor"=>"#FF0000",
							"data"=>array('first'=>array('value'=>'尊敬的用户，您的订单20150506037100001已成功接单','color'=>'#173177'),
										'keyword1'=>array('value'=>'洗车,打腊','color'=>'#173177'),
										'keyword2'=>array('value'=>'小明','color'=>'#173177'),
										'keyword3'=>array('value'=>'2016-04-24','color'=>'#173177'),								
										'remark'=>array('value'=>'如有问题请致电400-828-1878或直接在微信留言，我们将第一时间为您服务！','color'=>'#173177')
								)
					);

			    $access_token  = getWxAccToken();
				
				$get_token_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;			
				$ch  = curl_init() ;
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS,urldecode(json_encode(($json))));
				curl_setopt($ch, CURLOPT_URL,$get_token_url);			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
				$result = curl_exec($ch) ;
				curl_close($ch);
				var_dump($result);

				exit;

		sendRegistWxMsg('o7of3jmvbrorDVyQlwzqoAnfhUso');*/

		/*$jsonData='{"touser":"o7of3jmvbrorDVyQlwzqoAnfhUso","msgtype":"news","news":{"articles": [{"title":"有车一族享福利了","description":"汽车服务新时尚 ——O2O电商平台诚车堂汽车服务年卡","url":"http://e.eqxiu.com/s/wlhpsLF7?eqrcode=1","picurl":"http://res.eqxiu.com/group4/M00/85/91/yq0KYFb5-9CAM5gMAACWa9q-5sQ878.jpg"}]}}';
			    $access_token  = getWxAccToken();

				$get_token_url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;			
				$ch  = curl_init($get_token_url) ;
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
				$result = curl_exec($ch) ;
				curl_close($ch);
				//var_dump($result);
	 
		$array=array('num'=>1);

		$test = M("test"); // 实例化Info对象

		// 在User模型中启动事务
		$result=$test->startTrans();
		 // 进行相关的业务逻辑操作
		//$r=$test->add($array); // 保存用户信息

		$r=$test->where('id=21')->delete();
		$r1=$test->where('id=22')->delete();
		var_dump($r);
		exit;
		 if ($r&&$r1){
		    // 提交事务
		    $test->commit();
		 }else{
		   // 事务回滚
		   $test->rollback(); 
		 }
		 
		exit;
		//$result=M('deal_order')->where('id>50')->group('user_id')->sum('total_price')->select();

		/*var_dump('2');
		$py = new GetPin();
		echo $py->Pinyin("输出汉字所有拼音"); //不能正常显示深圳
		

		// $arr['deal_tpye'] = 1;
		// $arr['deal_id'] = 5094;
		// $arr['deal_name'] = '洗车三大发顺丰阿凡俗的阿桑发萨法艾丝凡';
		// $arr['coupon'] = '1234567891465123132132';
		// $arr['store_name'] = '诚车堂一号店';
		// $arr['store_tel'] = '0771-45646546546546';
		// $arr['store_address'] = '高新211654三大发顺丰sad规范阿萨德广泛撒地方撒旦法';
		// $arr['user_wxid'] = 'o7of3ju1wAFrxyfdIG3SOgope9Z4';
		// $arr['user_true_name'] = '青楼书生';
		// $arr['user_mobile'] = '15994467675';


		// if ($arr['deal_tpye'] == 1) {
		// 	$arr['deal_tpye'] = '商品';
		// 	$arr['deal_url']  = DOMAIN_URL.U('Goods/view',array('id'=>$arr['deal_id']));
		// }else{
		// 	$arr['deal_tpye'] = '服务';
		// 	$arr['deal_url']  = DOMAIN_URL.U('Service/view',array('id'=>$arr['deal_id']));
		// }
		// //发送微信
	 //    $url = DOMAIN_URL.U('User/order').'?t=4';
		// $content  = '提交时间：'.date('Y-m-d',time()).'\n\n预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n订单类型：在线支付\n\n服务码：'.$arr['coupon'].'\n\n';
		// $content .= "商家名称：".$arr['store_name'].'\n\n联系电话：'.$arr['store_tel'].'\n\n'.'商家地址：'.$arr['store_address'].'\n\n请提前1天预约,如有疑问,请拨打诚车堂客服热线:0771-2756623';
		// sendOrderWxMsg($arr['user_wxid'],'新订单通知',$content,$url);

		// $url = $arr['deal_url'];
		// $content  = '提交时间：'.date('Y-m-d',time()).'\n\n客户名称：'.$arr['user_true_name'].'\n\n客户电话：'.$arr['user_mobile'].'\n\n';
		// $content .= '预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n订单类型：在线支付\n\n服务码：'.$arr['coupon'].'\n\n';
		// $content .= "商家名称：".$arr['store_name'].'\n\n商家电话：'.$arr['store_tel'].'\n\n'.'商家地址：'.$arr['store_address'].'\n\n用户已付款成功，请及时跟进订单';
		// sendOrderWxMsg(C('cct_customer_service_wxid'),'跟进订单通知',$content,$url);

		/*$str='0123456789abcdefg';
		var_dump(ctype_xdigit($str));*/
		$this->display();

	}

	public function rand_72(){
		set_time_limit(0);
		//$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ','7'=>'22 23 24 ','8'=>'25 26 27 ','9'=>'28 29 30 ','10'=>'31 32 33 ','11'=>'34 35 36 ','12'=>'37 38 39 ','13'=>'40 41 42 ','14'=>'43 44 45 ');
		$arr=array('0'=>'01 02 ','1'=>'03 04  ','2'=>'05 06  ','3'=>'07 08 ','4'=>'09 10 ');
		//$arr=array('0'=>'01 ','1'=>'02  ','2'=>'03 ','3'=>'04 ','4'=>'05 ','5'=>'06  ','6'=>'07  ','7'=>'08  ','8'=>'09 ','9'=>'10 ');
		$new_arr=array();
		$j=0;
		$k=0;
		for ($i1=0; $i1 <=9; $i1++) { 
			for ($i2=0; $i2 <=9; $i2++) { 
				for ($i3=0; $i3<=9; $i3++) { 
					for ($i4=0; $i4<=9; $i4++) { 
						for ($i5=0; $i5 <=9; $i5++) { 
							for ($i6=0; $i6 <=9; $i5++) {
								for ($i7=0; $i7 <=9; $i5++) {
									for ($i8=0; $i8 <=9; $i5++) {
										if($i1!=$i2&&$i1!=$i3&&$i1!=$i4&&$i1!=$i5&&$i1!=$i6&&$i1!=$i7&&$i1!=$i8&&$i2!=$i3&&$i2!=$i4&&$i2!=$i5&&$i2!=$i6&&$i2!=$i7&&$i2!=$i8&&$i3!=$i4&&$i3!=$i5&&$i3!=$i6&&$i3!=$i7&&$i3!=$i8&&$i4!=$i5&&$i4!=$i6&&$i4!=$i7&&$i4!=$i8&&$i5!=$i6&&$i5!=$i7&&$i5!=$i8&&$i6!=$i7&&$i6!=$i8&&$i7!=$i8) {
											$sub=array('0'=>$i1,'1'=>$i2,'2'=>$i3,'3'=>$i4,'4'=>$i5,'5'=>$i6,'6'=>$i7,'7'=>$i8);
											sort($sub);
											if(!in_array($sub, $new_arr)){
												$new_arr[]=$sub;
												echo($arr[$i1].$arr[$i2].$arr[$i3].$arr[$i4].$arr[$i5].$arr[$i6].$arr[$i7].$arr[$i8]);
												echo('<br>');
												$j++;
											}							
										}		
									}
								}
							}					
						}
					}
				}
			}
		}
		//var_dump($j);	
		
	}

public function rand_7(){
		set_time_limit(0);
		//$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ','7'=>'22 23 24 ','8'=>'25 26 27 ','9'=>'28 29 30 ','10'=>'31 32 33 ','11'=>'34 35 36 ','12'=>'37 38 39 ','13'=>'40 41 42 ','14'=>'43 44 45 ');
		//$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ');
		$arr=array('0'=>'01 ','1'=>'02  ','2'=>'03 ','3'=>'04 ','4'=>'05 ','5'=>'06  ','6'=>'07  ','7'=>'08  ','8'=>'09 ','9'=>'10 ');
		$new_arr=array();
		$j=0;
		$k=0;
		for ($i1=0; $i1 <=9; $i1++) { 
			for ($i2=0; $i2 <=9; $i2++) { 
				for ($i3=0; $i3<=9; $i3++) { 
					for ($i4=0; $i4<=9; $i4++) { 
						for ($i5=0; $i5 <=7; $i5++) { 
							for ($i6=0; $i6 <=8; $i6++) {
								for ($i7=0; $i7 <=9; $i7++) {
									for ($i8=0; $i8 <=9; $i8++) {
										if($i1!=$i2&&$i1!=$i3&&$i1!=$i4&&$i1!=$i5&&$i1!=$i6&&$i1!=$i7&&$i1!=$i8&&$i2!=$i3&&$i2!=$i4&&$i2!=$i5&&$i2!=$i6&&$i2!=$i7&&$i2!=$i8&&$i3!=$i4&&$i3!=$i5&&$i3!=$i6&&$i3!=$i7&&$i3!=$i8&&$i4!=$i5&&$i4!=$i6&&$i4!=$i7&&$i4!=$i8&&$i5!=$i6&&$i5!=$i7&&$i5!=$i8&&$i6!=$i7&&$i6!=$i8&&$i7!=$i8) {
											$sub=array('0'=>$i1,'1'=>$i2,'2'=>$i3,'3'=>$i4,'4'=>$i5,'5'=>$i6,'6'=>$i7,'7'=>$i8);
											sort($sub);
											if(!in_array($sub, $new_arr)){
												$new_arr[]=$sub;
												echo($arr[$i1].$arr[$i2].$arr[$i3].$arr[$i4].$arr[$i5].$arr[$i6].$arr[$i7].$arr[$i8]);
												echo('<br>');
												$j++;

											}
											break;							
										}	

									}
								}
							}					
						}
					}
				}
			}
		}
		var_dump($j);	
		
	}
	public function php_test(){
		echo ('sdfsadfsadf');
		('<p>sdfsadfsadf</p>');
		printf('<p>sdfsadfsadf</p>');
		$arr = array('Hello','World!','I','love','Shanghai!');
		echo implode(" ",$arr);
	}

	

	public function rand_21(){
		set_time_limit(0);
		//$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ','7'=>'22 23 24 ','8'=>'25 26 27 ','9'=>'28 29 30 ','10'=>'31 32 33 ','11'=>'34 35 36 ','12'=>'37 38 39 ','13'=>'40 41 42 ','14'=>'43 44 45 ');
		$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ');
		$new_arr=array();
		$j=0;
		$k=0;
		for ($i1=0; $i1 <=6; $i1++) { 
			for ($i2=0; $i2 <=6; $i2++) { 
				for ($i3=0; $i3<=6; $i3++) { 
					for ($i4=0; $i4<=6; $i4++) { 
						for ($i5=0; $i5 <=6; $i5++) { 
							if($i1!=$i2&&$i2!=$i3&&$i3!=$i4&&$i4!=$i5&&$i1!=$i3&&$i1!=$i4&&$i1!=$i5&&$i2!=$i4&&$i2!=$i5&&$i3!=$i5){
								$sub=array('0'=>$i1,'1'=>$i2,'2'=>$i3,'3'=>$i4,'4'=>$i5);
								sort($sub);
								if(!in_array($sub, $new_arr)){
									$new_arr[]=$sub;
									echo($arr[$i1].$arr[$i2].$arr[$i3].$arr[$i4].$arr[$i5]);
									echo('<br>');
									$j++;
								}							
							}							
						}
					}
				}
			}
		}
		//var_dump($j);	
		
	}

	public function rand(){
		set_time_limit(0);
		$arr=array('0'=>'01 02 03 ','1'=>'04 05 06 ','2'=>'07 08 09 ','3'=>'10 11 12 ','4'=>'13 14 15 ','5'=>'16 17 18 ','6'=>'19 20 21 ','7'=>'22 23 24 ','8'=>'25 26 27 ','9'=>'28 29 30 ','10'=>'31 32 33 ','11'=>'34 35 36 ','12'=>'37 38 39 ','13'=>'40 41 42 ','14'=>'43 44 45 ');
		$new_arr=array();
		$j=0;
		$k=0;
		for ($i1=0; $i1 <=14; $i1++) { 
			for ($i2=0; $i2 <=14; $i2++) { 
				for ($i3=0; $i3<=14; $i3++) { 
					for ($i4=0; $i4<=14; $i4++) { 
						for ($i5=0; $i5 <=14; $i5++) { 
							if($i1!=$i2&&$i2!=$i3&&$i3!=$i4&&$i4!=$i5&&$i1!=$i3&&$i1!=$i4&&$i1!=$i5&&$i2!=$i4&&$i2!=$i5&&$i3!=$i5){
								$sub=array('0'=>$i1,'1'=>$i2,'2'=>$i3,'3'=>$i4,'4'=>$i5);
								sort($sub);
								if(!in_array($sub, $new_arr)){
									$new_arr[]=$sub;
									echo($arr[$i1].$arr[$i2].$arr[$i3].$arr[$i4].$arr[$i5]);
									echo('<br>');
									$j++;
								}							
							}							
						}
					}
				}
			}
		}
		var_dump($j);	
		
	}
	public function memcache_test(){

		

		//统计用户注册数据
		/*$Model = new Model(); 
		$sql="select FROM_UNIXTIME(create_time,'%m') as user_time,mobile from fw_user as fsl  where FROM_UNIXTIME(create_time,'%Y')=2015 and FROM_UNIXTIME(create_time,'%m')=01 and is_merchant!=2 order by create_time asc";
		$user=$Model->query($sql);
		
		 $ch = curl_init();
		 $header = array(
	        'apikey: 5ca77c0ce553b7443eb5da942e7cc45e',
	    );
		 $u=array();
		 foreach ($user as $k => $v) {
		 	$url = 'http://apis.baidu.com/apistore/mobilephoneservice/mobilephone?tel='.$v['mobile'];	    
		    // 添加apikey到header
		    curl_setopt($ch, CURLOPT_HTTPHEADER ,$header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    // 执行HTTP请求
		    curl_setopt($ch , CURLOPT_URL , $url);
		    $res = curl_exec($ch);
		   	$res=json_decode($res);
		   	$u[$v['user_time']][$res->retData->province][]=1;
		   	//$user[$k]['province']=$res->retData->province;
		   	//var_dump($res->retData->province);
		 }
	    	var_dump($u);
		/*$user=M('user')->field('mobile')->where("is_merchant!=2 and FROM_UNIXTIME(create_time,'%Y')=2015")->select();

		$ch = curl_init() ;
		foreach ($user as $k => $v) {
			$url="http://virtual.paipai.com/extinfo/GetMobileProductInfo?mobile=".$v['mobile']."&amount=10000&callname=getPhoneNumInfoExtCallback";
			curl_setopt($ch, CURLOPT_URL,$url);	
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$result = curl_exec($ch);	
			json_encode($result,true);
			var_dump($result);
			$user[$k]['province']=substr($result,56,4);
		}
		curl_close($ch);				
		var_dump($user);*/

	}

	public function is_what(){
		header("Content-Type:text/html;charset=utf-8");
		//获取USER AGENT
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		var_dump($agent);
		//分析数据
		$is_pc = (strpos($agent, 'windows nt')) ? true : false;   
		$is_iphone = (strpos($agent, 'iphone')) ? true : false;   
		$is_ipad = (strpos($agent, 'ipad')) ? true : false;   
		$is_android = (strpos($agent, 'android')) ? true : false; 
		//输出数据 
	    if($is_pc){   
	        echo "<p style='font-size: 130px;text-align: center;margin-top: 350px;'>这是PC<p>";   
	    }   
	    if($is_iphone){   
	        echo "<p style='font-size: 130px;text-align: center;margin-top: 350px;'>这是iPhone<p>";   
	    }   
	    if($is_ipad){   
	        echo "<p style='font-size: 130px;text-align: center;margin-top: 350px;'>这是iPad<p>";   
	    }   
	    if($is_android){   
	        echo "<p style='font-size: 130px;text-align: center;margin-top: 350px;'>这是Android<p>";   
	    }   
	}

	public function add_card_data(){
		$arr=array('900'=>5858);
		$card=M('shop_card_cate_link')->where('deal_cate_type_id=1 and card_id>2 and card_id<=38')->select();
		foreach ($card as $k => $v) {
			$data['link_id']=$v['id'];
			$data['deal_id']=5858;
			$data['location_id']=900;
            //$r=M('shop_card_cate_deal_link')->add($data);
//var_dump($r);
		}	
		//var_dump($card);
	}

	//必优卡店铺E卡数据
	public function card_data(){
		$array=array('891'=>5657,'892'=>5700,'899'=>5820,'895'=>5752,'898'=>5803,'897'=>5786,'893'=>5718,'896'=>5769,'894'=>5735);
		
		$card_cate=M('shop_card_cate_link')->join('fw_shop_card as fsc on fsc.id=fw_shop_card_cate_link.card_id')->field('fsc.name,fw_shop_card_cate_link.id')->where('deal_cate_type_id=1 and is_effect=1')->select();

		foreach ($card_cate as $k => $v) {
			$link_ids[]=$v['id'];
		}
		//var_dump($link_ids);
		$ids=implode(',', $link_ids);	
		$card_deal=M('shop_card_cate_deal_link')->where('link_id in('.$ids.')')->select();
		//var_dump($card_deal);
		foreach ($card_deal as $k => $v) {
			foreach ($array as $k1 => $v1) {
				if($v['location_id']!=$k1){
					$data['link_id']=$v['id'];
					$data['deal_id']=$v1;
					$data['location_id']=$k1;
					//var_dump($data);
					/*$r=M('shop_card_cate_deal_link')->add($data);
					var_dump($r);*/
				}
			}
		}
		//var_dump($card_deal);
		//var_dump($card_cate);
	}


	public function user_data(){
		$data=M('shop_card_user_record')->join('fw_deal as fd on fd.id=fw_shop_card_user_record.deal_id')->where('fw_shop_card_user_record.location_id=0')->field('fw_shop_card_user_record.id,fd.location_id')->select();

		foreach ($data as $k => $v) {
			$data['location_id']=$v['location_id'];
			//$r=M('shop_card_user_record')->where('id='.$v['id'])->save($data);
			//var_dump($r);
		}	
	}

	public function card_add_service(){
		$arr=array('891'=>3,'892'=>12,'895'=>15,'898'=>16,'899'=>17,'897'=>18,'896'=>19,'894'=>20,'893'=>21);
		$deal=array('891'=>5839,'892'=>5841,'895'=>5844,'898'=>5846,'899'=>5847,'897'=>5845,'896'=>5849,'894'=>5843,'893'=>5842);
		foreach ($arr as $k => $v) {
			$data['card_id']=$v;
			$data['deal_cate_type_id']=2;
			$data['is_shop']=2;
			$data['number_of_uesr']=2;
			//$r=M('shop_card_cate_link')->add($data);
			var_dump($r.'--');
			if($r){
				$data1['link_id']=$r;
				$data1['deal_id']=$deal[$k];
				$data1['location_id']=$k;
				//$r1=M('shop_card_cate_deal_link')->add($data1);
			}
			var_dump($r1);
		}
	}


	//必优卡店铺复制数据
	public function store_data(){
		//  supplier_id location_id
		//  904    891
		//  905    892
		//  907	   893
		//  908    894
		//  906    895
		//  909    896
		//  910    897
		//  911    898
		//  912	   899
		$arr=array('0'=>903,'1'=>905,'2'=>907,'3'=>910,'4'=>904,'5'=>906,'6'=>908,'7'=>909);
		$data=M('deal')->where('location_id=902 and is_effect=1')->select();
		//var_dump($data);
		//foreach ($arr as $k1 => $v1) {
				foreach ($data as $k => $v) {		
					$data1['name']=$v['name'];
					$data1['sub_name']=$v['sub_name'];
					$data1['cate_id']=$v['cate_id'];
					$data1['deal_cate_id']=$v['deal_cate_id'];
					$data1['supplier_id']=915;
					$data1['location_id']=913;
					$data1['img']=$v['img'];
					$data1['description']=$v['description'];
					$data1['begin_time']=$v['begin_time'];
					$data1['end_time']=$v['end_time'];
					$data1['origin_price']=$v['origin_price'];
					$data1['current_price']=$v['current_price'];
					$data1['city_id']=$v['city_id'];
					$data1['is_coupon']=$v['is_coupon'];
					$data1['is_effect']=0;
					$data1['is_delete']=0;
					$data1['user_count']=0;
					$data1['buy_count']=0;
					$data1['time_status']=1;
					$data1['buy_status']=1;
					$data1['brief']=$v['brief'];
					$data1['sort']=$v['sort'];
					$data1['is_shop']=$v['is_shop'];
					$data1['success_time']=$v['success_time'];
					$data1['icon']=$v['icon'];
					$data1['create_time']=time();
					$data1['update_time']=time();
					$data1['deal_premiums']=$v['deal_premiums'];

					$data1['name_match']=$v['name_match'];
					$data1['name_match_row']=$v['name_match_row'];
					$data1['deal_cate_match']=$v['deal_cate_match'];
					$data1['deal_cate_match_row']=$v['deal_cate_match_row'];
					$data1['locate_match']=$v['locate_match'];

					$data1['locate_match_row']=$v['locate_match_row'];
					$data1['brand_promote']=$v['brand_promote'];
					$data1['publish_wait']=0;
					$data1['is_recommend']=$v['is_recommend'];
					$data1['click_count']=$v['click_count'];

					$data1['adv_word']=$v['adv_word'];
					//var_dump($data1);
				   //$r=M('deal')->add($data1);
				  //var_dump($r);
			}
		//}
		
		
	}

	public function attr(){
		$deal_id=5096;
		
		//全部属性列表
			$d_f = 'dta.name,fw_deal_attr_record.attr_value,fw_deal_attr_record.id,fw_deal_attr_record.goods_type_attr_id,fw_deal_attr_record.deal_submeter_id';
		    $d_w = array('fw_deal_attr_record.deal_id'=>$deal_id);
		    $d_o = 'dta.sort desc';
		    $deal_attrs_res = M('deal_attr_record')->join('fw_goods_type_attr as dta ON dta.id = fw_deal_attr_record.goods_type_attr_id')->field($d_f)->where($d_w)->order($d_o)->select();

			$record_attr_arr=array();
		    foreach ($deal_attrs_res as $k => $v) {				 
			   	$record_attr_arr[$v['name']][]=$v;
		   	}
		   	foreach ($record_attr_arr as $key => $val) {
		   		foreach ($val as $k => $v) {
		   			
		   			if($attr_list[$v['attr_value'].$v['goods_type_attr_id']]){
		   				if($attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['name']==$v['name']){
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['id'].='_'.$v['id'];		
			   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_id'].='_'.$v['deal_submeter_id'];
		   				}else{
		   					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   				}		   						   				
		   			}else{
		   				$attr_list[$v['attr_value'].$v['goods_type_attr_id']][]=$v;
		   			}
		   			$all_attr_list[$v['deal_submeter_id']][]=$v;
		   			$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['ids'][]=$v['id'];
					$attr_list[$v['attr_value'].$v['goods_type_attr_id']][0]['deal_submeter_ids'][]=$v['deal_submeter_id'];		   			
		   		}			   			
			 } 
		
			 $attr_list=array_values($attr_list);
			 foreach ($attr_list as $key => $val) {			 
			 	foreach ($val as $k => $v) {
			 		$sort_ids=$v['ids'];							
					sort($sort_ids);
					$sort_id=implode('_', $sort_ids);
					$v['id']=$sort_id;
					$deal_submeter_ids=$v['deal_submeter_ids'];
					sort($deal_submeter_ids);
					$deal_submeter_id=implode('_', $deal_submeter_ids);
					$v['deal_submeter_id']=$deal_submeter_id;
			 		$attr_id_list[]=$v['id'];
			 		$attr_attr_list[]=$v;
			 	}			 	
			 }
			
		$all_attr_list=array_values($all_attr_list);
		foreach($attr_attr_list as $key => $val) {				
			foreach($all_attr_list as $k => $v) {
					foreach($v as $k1 => $v1) {						
						if(in_array($v1['deal_submeter_id'],$val['deal_submeter_ids'])){
							$all_attr_list[$k][$k1]['deal_submeter_ids']=$val['deal_submeter_id'];
						}
						if(in_array($v1['id'],$val['ids'])){
							$all_attr_list[$k][$k1]['ids']=$val['id'];
						}
					}
					
			}	
		
		}
		foreach($all_attr_list as $k => $v) {					
				foreach($v as $k1 => $v1) {						
					$all_finish_arr[$k][]=$v1['ids'];
				}					
			}

		var_dump($all_attr_list);

	}

	public function img(){
		$store_user_wx=M('user')->where(array('user_name'=>15177122148))->getField('wxid');
		if($store_user_wx){
			$url = $arr['deal_url'];
			$content  = '提交时间：'.date('Y-m-d H:i',time()).'\n\n客户名称：'.$arr['user_true_name'].'\n\n客户电话：'.$arr['user_mobile'].'\n\n';
			$content .= '预订'.$arr['deal_tpye'].'：'.$arr['deal_name'].'\n\n'.$deal_attr.$arr['deal_tpye'];			
			sendOrderWxMsg($store_user_wx,'跟进订单通知',$content,'');
		}
		var_dump($store_user_wx);
		/*$result=M('article')->where('cate_id=27 and is_effect=1')->select();
		foreach ($result as $k => $v) {
			$data['catid']=38;
			$data['title']=$v['title'];
			$data['thumb']=$v['thumb'];
			$data['inputtime']=$v['create_time'];
			$data['updatetime']=$v['update_time'];
			$data['description']=$v['brief'];
			$data['status']=99;
			$data['sysadd']=1;
			$data['username']='admin';
			$r=M("news","news_",C('NEWS'))->add($data);
			var_dump($r.'----------------');
			$data3['hitsid']='c-1-'.$r;
			$data3['catid']=38;
			$data3['views']=mt_rand(5,10);
			$data3['updatetime']=$v['update_time'];
			$r3=M("hits","news_",C('NEWS'))->add($data3);
			$data2['url']='http://www.17cct.com/news/content-15-'.$r.'-1.html';
			$r2=M("news","news_",C('NEWS'))->where('id='.$r)->save($data2);
			$data1['id']=$r;
			$data1['content']=$v['content'];
			$data1['maxcharperpage']=10000;
			$data1['allow_comment']=1;
			$data1['copyfrom']='|0';
			$r1=M("news_data","news_",C('NEWS'))->add($data1);
			var_dump($r1);
		}*/
		$Ticket=getWxTicket();
		//var_dump($Ticket);
		header("Content-type: text/html; charset=utf-8"); 
		 $ip=$_SERVER['REMOTE_ADDR'];
		 echo($ip."<br>");
		 $json=file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
		 $arr=json_decode($json);
		 echo $arr->data->country."<br>";    //国家
		 echo $arr->data->area."<br>";    //区域
		 echo $arr->data->region."<br>";    //省份
		 echo $arr->data->city."<br>";    //城市
		 echo $arr->data->isp."<br>";    //运营商 
		
	}

	function getOrderId()
	{
		//哪年,哪天,哪一秒
			 $base = date('y') . date('z') . str_pad((date('H') * 60 * 60 + date('i') * 60 + date('s')), 5, 0, STR_PAD_LEFT);
			 $next_sec = time() + 1;

			 $pre_max_id = 999;
			 while(time() < $next_sec) {
			 $order_id = mt_rand(1, $pre_max_id);
			 var_dump($base.str_pad($order_id, 3, 0, STR_PAD_LEFT));exit;
			 $store_key = parent::getCacheKey('orderIdCache', $base, $order_id);
			 $setRet = $this->store->setnx($store_key, 1);

			 if ($setRet) {
			 $this->store->expire($store_key, 5);
			 return $base.str_pad($order_id, 3, 0, STR_PAD_LEFT);
			 } else {
				continue;
			}
		}
	}


	function download_remote_file_with_fopen($file_url, $save_to)
	{
		$in=    fopen($file_url, "rb");
		$out=   fopen($save_to, "wb");
 
		while ($chunk = fread($in,8192))
		{
			fwrite($out, $chunk, 8192);
		}
 
		fclose($in);
		fclose($out);
	}


	public function imgshow(){	
		// 获取链接的HTML代码
			$html = file_get_contents('http://www.17cct.com');

			$dom = new DOMDocument();
			@$dom->loadHTML($html);

			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate('/html/body//a');

			for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$url = $href->getAttribute('href');

			// 保留以http开头的链接
			if(substr($url, 0, 4) == 'http')
				echo $url.'<br />';
			}
	}

	//添加白名单
	public function carttest(){
		$jsonData='{"openid":["o7of3jmvbrorDVyQlwzqoAnfhUso"],"username":["liad209"]}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/testwhitelist/set?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		var_dump($result);
	}

	//查看卡券code
	public function getCode(){
		/*$encrypt_code=trim($_REQUEST['encrypt_code']);
		$jsonData='{"encrypt_code":"'.$encrypt_code.'"}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/code/decrypt?access_token=".$access_token;*/
		$jsonData='{"mobile":"15177122148"}';	
		$url="http://www.biyao.com/account/GeneratorCodeRe";
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		//curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		var_dump($result);exit;
		$this->ajaxReturn($result,"加载成功",1);
	}

	//查看卡券详情
	public function getcard(){
		$card_id=trim($_REQUEST['card_id']);
		$jsonData='{"card_id":"'.$card_id.'"}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/get?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		$this->ajaxReturn($result,"加载成功",1);
	}

	//查看用户卡券列表
	public function getlist(){
		var_dump(C('wx_id'));
		var_dump(C('wx_secret'));
		var_dump(getWxAccToken());
		//card_id非必填
		$jsonData='{"openid":"o7of3juF7AoKOJ4IfWl7WSrA87lU","card_id":""}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/user/getcardlist?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		var_dump($result);
		return $result['card_list'];
	}
	//卡券ticket
	public function get_apiticket(){		
		    $mem = new Memcache; 
		    $mem->connect('localhost', 11211) or die ("Could not connect"); 
		    $card_ticket = $mem->get('card_ticket');
			if($card_ticket){
				return $card_ticket;
			}else{
				$ch = curl_init();
				$timeout = 5;
				$token=getWxAccToken();//获取access_token
				curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=wx_card");
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$card_ticket = curl_exec($ch);
				$card_ticket = json_decode($card_ticket, true);
				$mem->set('card_ticket',$card_ticket['ticket'],0,7200);
				return $card_ticket['ticket'];	
			}	
	}

	//jsapi的ticket
	function get_ticket()
	{
		 
		//var_dump($this->get_apiticket());
		/* $mem = new Memcache; 
		 $mem->connect('localhost', 11211) or die ("Could not connect"); 
		 $ticket = $mem->get('ticket');

		if($ticket){
			return $ticket;
		}else{*/
			$ch = curl_init();
			$timeout = 5;
			$token=getWxAccToken();//获取access_token
			curl_setopt ($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$token&type=jsapi");
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$ticket = curl_exec($ch);
			$ticket=json_decode($ticket, true);
			//$mem->set('ticket',$ticket['ticket'],0,7200);
			return $ticket['ticket'];	
		//}
		
	}

	public function choosecard(){
		$nonceStr=$this->createNonceStr();
		$this->assign('nonceStr',$nonceStr);//随机串
		$time=time();	
	    $ticket=$this->get_ticket();	   
	    $config_sign=sha1("jsapi_ticket=".$ticket."&noncestr=".$nonceStr."&timestamp=".$time."&url=http://m.17cct.com/index.php/Test/choosecard.html");
	    $this->assign('time',$time);
	    $this->assign('sign',$config_sign);
	    $apitick=$this->get_apiticket();//卡券ticket
	    $card_type='';//团购券：GROUPON; 折扣券：DISCOUNT; 礼品券：GIFT; 代金券：CASH; 通用券：GENERAL_COUPON; 会员卡：MEMBER_CARD; 景点门票：SCENIC_TICKET； 电影票：MOVIE_TICKET； 飞机票：BOARDING_PASS； 会议门票：MEETING_TICKET； 汽车票：BUS_TICKET;
	    $app_id=C('wx_id');
	    $arrays = array($apitick,$time,$nonceStr,$card_type,$app_id);
	    $arrays = array_values($arrays);
        sort($arrays,SORT_STRING);//进行字符串的字典序排序。
	    $signature=sha1(implode($arrays));
	    $this->assign('signature',$signature);
		$this->display();
	}

	private function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	  }

	public function consume(){
		$code=trim($_REQUEST['code']);
		$jsonData='{"code":"'.$code.'"}';		
		$access_token=getWxAccToken();
		$url="https://api.weixin.qq.com/card/code/consume?access_token=".$access_token;
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch) ;
		curl_close($ch) ;
		$result=json_decode($result,true);
		$this->ajaxReturn($result,"加载成功",1);
	}

	//退款申请测试接口
	public function refund()
	{
		header('Content-type: text/html; charset=utf-8');
		
		import("@.ORG.WxPay_TEST_PHP.WxPayPubHelper");	

		//使用统一支付接口
		$Refund = new Refund_pub();
		
		$Refund->setParameter("out_trade_no","wx7ea1cd13c9f42d971434543535");//商户订单号
		$Refund->setParameter("out_refund_no","1009200587201506170263504495");//商户系统内部的退款单号
		$Refund->setParameter("total_fee", 1);//总金额 单位为分
		$Refund->setParameter("refund_fee",1);//返回金额 单位为分
		$Refund->setParameter("op_user_id",'10027595');//操作员帐号, 默认为商户号		
		$result = $Refund->getResult();
		var_dump($result);
		$this->display();	
	}


	//分布式缓存
	public function memcache(){
		
	    var_dump(getWxTicket());
	}



	//批量添加马甲会员
	public function insert_member(){
		/*$t1 = microtime(true);//代码执行开始时间

		$Model = new Model(); 
		$phoneArr = array();     //保存手机号数组
		$num = 30000;                 //生成手机号的个数
		$twoArr = array(3,5,8);  //手机号的第二位
		$tArr = array(0,1,2,3,4,5,6,7,8,9);    //手机号第二位为3时，手机号的第3位数据集，以及手机号的第4位到第11位
		$ntArr = array(0,1,2,3,5,6,7,8,9);      //手机号第二位不为3时，手机号的第3位数据集
		for($i=0;$i<$num;$i++){
			$phone[0] = 1;                      //手机号第一位必须为1
			for($j=1;$j<11;$j++){
				if($j == 1){
				   $t = rand(0,2);          //随机生成手机号的第二位数字
				   $phone[$j] = $twoArr[$t];		   
				}elseif($j==2 && $phone[1] != 3){     //当第二位不为3时，随机生成其余手机号
				   $th = rand(0,8);
				   $phone[$j] = $ntArr[$th];
				}else{                                         //当第二位为3时，随机生成其余手机号
					$th = rand(0,9);
					$phone[$j] = $tArr[$th];
				}				
			}
			$number=implode("",$phone);
			//if(!M('user')->where("user_name='".$number."'")->find()){
				$phoneArr[] = $number; //将手机号数组合并成字符串	
			//}			
		}
		var_dump($phoneArr);
		$t2 = microtime(true);//代码执行结束时间
		echo '耗时'.round($t2-$t1,3).'秒';
		$ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
		 $sql= "insert into fw_test (user_name,mobile,create_time,update_time,login_time,user_pwd,group_id,is_effect,login_ip,is_merchant,sex) VALUES";
		 $sex_arr=array(-1,2);		
		 for($i=0;$i<=20;$i++){
		 	$create_time=strtotime($this->randomDate('2013-9-1','2015-5-10'));
		 	$login_time=strtotime($this->randomDate('2015-5-11','2015-8-10'));
		 	$pwd=md5($this->getSixPwd());
		 	$rand_key = mt_rand(0, 9);
		 	$sex=$sex_arr[rand(0,1)];
			$ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
			 $sql.="('".$phoneArr[$i]."','".$phoneArr[$i]."',".$create_time.",".$create_time.",".$login_time.",'".$pwd."','1','1','".$ip."','2',".$sex."),";
			 if($i%10==0){
				 $sql = substr($sql,0,strlen($sql)-1);				
				 $r=$Model->query($sql);
				 var_dump($r);
				 $sql= "insert into fw_user (user_name,mobile,create_time,update_time,login_time,user_pwd,group_id,is_effect,login_ip,is_merchant,sex) VALUES";
			 }
		 }	 */
		 
		
	}
	//获取六位数随机密码
	function getSixPwd()
	{
		$ychar="0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
		$list=explode(",",$ychar);
		for($i=0;$i<6;$i++){
			$randnum=rand(0,35); 
			$authnum.=$list[$randnum];
		}
		return $authnum;
	}
	//获取两个时间段内的随机时间
	function randomDate($begintime, $endtime="") {  
	    $begin = strtotime($begintime);  
	    $end = $endtime == "" ? mktime() : strtotime($endtime);  
	    $timestamp = rand($begin, $end);  
	    return date("Y-m-d H:i:s", $timestamp);  
	}  

	public function password(){
		require_once 'jiami.php';
		$key ="weixin_com_coupon_encode_key";
		$pwd='354787454';
		echo('原文:'.$pwd)."<br><br>";
		$coupon = passport_encrypt($pwd,$key);//加密	
		echo(passport_decrypt(passport_encrypt($pwd,$key),$key))."<br>";
		echo('passport_encrypt：'.$coupon)."<br><br>";
		/*echo('md5：'.md5($pwd))."<br><br>";
		echo('base64：'.base64_encode($pwd))."<br><br>";
		echo('crypt：'.crypt($pwd,'123'))."<br><br>";//加盐值
		echo('sha1：'.sha1($pwd))."<br><br>";*/
	}



	public function coupon(){
		require_once 'jiami.php';
		$key ="weixin_com_coupon_encode_key";
		$coupon = passport_encrypt('354787454',$key);//加密		
		/*$uid = passport_decrypt($coupon,$key);//解密代码,俱乐部ID
		var_dump($uid);*/
		var_dump($coupon);
		$this->assign('coupon',$coupon);
		$this->display();
	}

	public function check_coupon(){
		//判断是否已登录

		//判断是否获取得了验证码

		//判断扫码用户是否为机构管理

		//查询验证码信息

		//验证码是否有效，是否已删除，是否已验证，扫码者是否有本验证码的验证权限

		//查询订单信息，与验证码信息对比


		require_once 'jiami.php';
		$key ="weixin_com_coupon_encode_key";
		$coupon=trim($_REQUEST['number']);

		$coupon = passport_decrypt($coupon,$key);
		var_dump($coupon);exit;
	}

	public function qrcode(){
		$ch = curl_init();
		$timeout = 5;

		 $access_token  = getWxAccToken();
		$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;

		$json=array();
		//永久二维码
		// $json['action_name']="QR_LIMIT_SCENE";
		// $json['action_info']=array('scene'=>array('scene_id'=>10001));

		//临时二维码
		$json['action_name']="QR_SCENE";
		$json['expire_seconds']=1;
		$json['action_info']=array('scene'=>array('scene_id'=>23));
		$jsonData=json_encode($json);

		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$result = curl_exec($ch);			
		$result=json_decode($result);	
		$this->assign('result',$result);
		$this->display();
	}


}

?>  