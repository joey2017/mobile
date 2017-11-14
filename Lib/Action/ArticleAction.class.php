<?php

// 本类由系统自动生成，仅供测试用途

class ArticleAction extends BaseAction {



     public function index()

	{
		$id=intval($_GET['id']);
		if($id){
			header('Location:'.U('Article/view',array('id'=>$id)));
			exit;
		}
		 /*if(!$_REQUEST['cid']){
		 	$count=M("news","news_",C('NEWS'))->where('status=99 and posids=1')->count();
		 }else{
		 	$count=M("news","news_",C('NEWS'))->where('status=99 and posids!=1 and catid='.$_REQUEST['cid'])->count();
		 }
		 $count=20;
		if(!$count||$count<10){
			$count=1;
		}else{
			$count=intval($count/10);
		}*/
		$this->assign('cid',$_REQUEST['cid']);
		$this->assign('no_include',1);
		//$this->assign('count',$count);
		$this->display();
	}



	public function view()
	{
        require_once "Jssdk.php";
        $jssdk = new JSSDK("wxbd68bd4fe539eba2", "f2c29cdcbf2543e7531aef5e7651585c");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('no_include',1);
		$this->assign('signPackage',$signPackage);
		$id=intval($_GET['id']);
		$result=M("news","news_",C('NEWS'))->field('news_news.id,title,content,keywords,inputtime,username,likecount,thumb,description')->join('news_news_data as nnd on nnd.id=news_news.id')->where("news_news.id=$id")->find();	
		if(!$id||!$result){
			$this->redirect('Article/index','没找到该文章');	
		}
		
		$result['view']=M("hits","news_",C('NEWS'))->where('hitsid="c-1-'.$id.'"')->getField('views');
		$this->assign('r',$result);
		$this->assign('title',$result['title']);

		$keywords_arr = explode(' ',$result['keywords']);
		$key_array = array();
		$number = 0;
		$i=1;
		foreach ($keywords_arr as $k => $v) {
			$relevant_news=M("news","news_",C('NEWS'))->field("id,title")->order('inputtime desc')->where("keywords like('%".$v."%' ) and status=99 and id !=$id")->select();
			$number+=count($relevant_news);
			foreach ($relevant_news as $id=>$v) {
					if($i<= 3 && !in_array($id, $key_array)) $key_array[$id] = $v;
					$i++;
				}
			if(3<$number) break;		
		}
		//相关资讯
		$this->assign('key_array',$key_array);
		$this->display();

	}

	public function click_like(){
		$r=M("news_data","news_",C('NEWS'))->field('likecount')->where("id=".intval($_REQUEST['id']))->find();
		if(!$r) return false;
		if($r['likecount']===0){
			$$likecount=1;
		}else{
			$likecount = $r['likecount'] + 1;
		}		
		//$sql = array('likecount'=>$likecount);
		$data['likecount']=$likecount;
	    $result=M("news_data","news_",C('NEWS'))->where('id='.intval($_REQUEST['id']))->save($data);
	    if($result){
	    	echo $likecount;
	    }else{
	    	echo 0;
	    }   
	}

	public function ajax_get_a()
	{
			$page=intval($_GET['p']);

			/*if($page>2){
				$page=$page-1;	
			}*/
			$cid=intval($_REQUEST['cid']);
			$where="status=99";
			if(!$cid){
				$where.=" and posids=1";
			}else{
				$where.=" and posids!=1 and catid=".$cid;
			}
			$result=M("news","news_",C('NEWS'))->field("id,title,thumb,description,inputtime")->order('inputtime desc')->limit(($page*10).',10')->where($where)->select();
			foreach ($result as $k => $v) {
				$result[$k]['view']=1000+(M("hits","news_",C('NEWS'))->where('hitsid="c-1-'.$v['id'].'"')->getField('views'))*15;
				$result[$k]['inputtime']=date('Y-m-d',$v['inputtime']);		
			}
			
			$this->assign('list',$result);
    		echo $html=$this->fetch();

	}



	

}

?>	