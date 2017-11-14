<?php
class ShaidanAction extends BaseAction {

	public function view()
	{
		$sid = intval($_GET['id']);
		if (empty($sid) || $sid < 0) {
			$this->error('该晒单不存在');
		}
		$s_w['sid'] = $sid;
		$s_w['is_show'] = 1;
		$s_f = 'sid,uid,supid,title,detail,viewcount,pubtime';

		$shaidan = M('shaidan')->field($s_f)->where($s_w)->find();
		if ($shaidan) {
			//浏览数 +1
			M('shaidan')->where(array('sid'=>$sid))->setInc('viewcount');

			$shaidan['user'] = M('user')->field('user_name,true_name,head_img')->where(array('id'=>$shaidan['uid']))->find();
			$shaidan['user']['head_img'] = empty($shaidan['user']['head_img']) ? getUserAvatar($shaidan['uid'],'middle') : $shaidan['user']['head_img'] ;
			$shaidan['user']['user_name'] = getUserName(array($shaidan['user']['user_name'],$shaidan['user']['true_name']));

			//商家信息
			$shaidan['store'] = M('supplier_location')->field('name,mobile,tel')->where(array('id'=>$shaidan['supid'],'is_effect'=>1))->find();
			if ($shaidan['store']) {
				$shaidan['store']['tel'] =  empty($shaidan['store']['tel']) ? $shaidan['store']['mobile'] : $shaidan['store']['tel'] ;
			}
			$shaidan['reply_count'] = M('comment')->where(array('sid'=>$sid))->count(0);
			$this->assign('count',$shaidan['reply_count']);
		}else {
			$this->error('该晒单不存在');
		}

		$this->assign('shaidan',$shaidan);
		$this->assign('title',$shaidan['title']);
		$this->display();
	}

	//ajax 用户晒单评论
	public function ajaxGetShaidanReplyList()
	{
		$sid   = intval($_GET['id']);
		$page  = intval($_GET['p'])-1;
		$lnums = intval($_GET['lnums']); //每次加载的行数
		if (empty($sid) || empty($lnums) || $sid < 0 || $page < 0 || $lnums < 0 ) {
			$this->ajaxReturn(0,"加载失败，请稍后重试",0);
		}
		$onerror="imgError(this,'http://s.17cct.com/v3/images/errorimg.jpg');";
		$s_w['fw_comment.sid']  = $sid;
		$s_f = 'fw_comment.uid,fw_comment.content,fw_comment.addtime,u.user_name,u.true_name,u.head_img';
		$s_o = 'fw_comment.comment_id desc';
		$s_t = ($page*$lnums).','.$lnums;
		
		$reply = M('comment')->join('fw_user as u ON u.id=fw_comment.uid')->field($s_f)->where($s_w)->order($s_o)->limit($s_t)->select();
		if ($reply) {
			foreach ($reply as $k => $v) {
				$reply[$k]['head_img'] = empty($v['head_img']) ? getUserAvatar($v['uid'],'middle') : $v['head_img'] ;
				$reply[$k]['user_name'] = getUserName(array($v['user_name'],$v['true_name']));
				$reply[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			}
			$this->ajaxReturn($reply,'加载成功',1);
		}else{
			$this->ajaxReturn($reply,'加载失败，请稍后重试',0);
		}
	}

	//ajax 用户发表评论
	public function ajaxPostReply()
	{		
		$sid   = intval($_POST['id']);
		$content = trim($_POST['content']);
		if (empty($sid)|| $sid < 0) {
			$this->ajaxReturn(0,"网络延迟，请稍后重试",0);
		}
		if (empty($content)) {
			$this->ajaxReturn(0,"评论内容不能为空",0);
		}
		if (!isLogin(U('Shaidan/view',array('id'=>$sid)),true)) {
			$this->ajaxReturn(0,'请先登录',0);
		}
		$u = session('user_info');

 		$ins['sid'] 	= $sid;
		$ins['uid'] 	= intval($u['id']);
		$ins['content'] = htmlspecialchars(addslashes($content));
		$ins['addtime'] = time();

		$r = M('comment')->add($ins);
		if ($r) {
			$ins['user_name'] = $u['show_name'];
			$ins['head_img']  = $u['show_head'];
			$ins['addtime']   = date('Y-m-d H:i:s',$ins['addtime']);
			$this->ajaxReturn($ins,'发布成功',1);
		}else {
			$this->ajaxReturn(0,'发布失败',0);
		}
	}
}
?>  