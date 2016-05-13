<?php
import ( '@.Common.Calendar' );
class UserAction extends Action {
	
	//会员后台
	public function my() {
		//查询当前会员的相关数据
		$id = $_SESSION ['user_id'];
		if ($id == "") {
			$this->success ( "请登录", U ( "User/login" ) );
			exit ();
		}
		$User = M ( 'User' );
		$data = $User->where ()->find ( $id );
		$this->assign ( 'data', $data );
		
		//获取日历
		$year = date ( "Y" );
		$month = date ( "m" );
		$params = array ('year' => $year, 'month' => $month );
		if (isset ( $_GET ['year'] ) && isset ( $_GET ['month'] )) {
			$params = array ('year' => $_GET ['year'], 'month' => $_GET ['month'] );
			$year = $_GET ['year'];
			$month = $_GET ['month'];
		}
		//获取会员签到列表
		$User_sign = M ( "User_sign" );
		$list_sign = $User_sign->where ( "si_year='$year' and si_month='$month' and user_id=$id" )->select ();
		//一共签到多少次
		$sign_num = $User_sign->where ( "user_id=$id" )->count ();
		$this->assign ( 'sign_num', $sign_num );
		//调用日历
		$cal = new Calendar ( $params, $list_sign );
		$this->assign ( 'calendar', $cal->display () );
		
		$this->display ();
	}
	//签到
	public function sign() {
		$id = $_SESSION ['user_id'];
		//查询当前会员的相关数据
		if ($id == "") {
			$this->success ( "请登录", U ( "User/login" ) );
			exit ();
		}
		//增加用户积分，每次增加1积分
		$User = M ( 'User' );
		$data = $User->find ( $id );
		$dateN = date ( "Y-m-d H:i:s" );
		$dateF = $data ['sign_time'];
		$newdate = strtotime ( $dateN ) - strtotime ( $dateF );
		$hour = floor ( $newdate / 3600 ); //时
		if ($hour >= 24) {
			$udata ['user_jifen'] = $data ['user_jifen'] + 1;
			$udata ['user_id'] = $id;
			$udata ['sign_time'] = date ( "Y-m-d H:i:s" );
			$User->save ( $udata );
			
			//将签到信息添加到签到表
			$User_sign = M ( 'User_sign' );
			$sdata ['user_id'] = $id;
			$sdata ['si_year'] = date ( "Y" );
			$sdata ['si_month'] = date ( "m" );
			$sdata ['si_day'] = date ( "d" );
			$sdata ['si_time'] = date ( "H:i:s" );
			if ($User_sign->add ( $sdata )) {
				$this->success ( "签到成功，增加1积分" );
			} else {
				$this->error ( "签到失败" );
			}
		} else {
			$this->error ( "您今天已经签到了" );
		}
	}
	
}