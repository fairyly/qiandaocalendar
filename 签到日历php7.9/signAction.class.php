<?php
/* 
*签到
*/
class signAction extends frontendAction
{
	public function _initialize() { 
        parent::_initialize();	 
        $this->_init_users();
        $this->_mod = D('sign');
    }

    public function index(){
		$this->display();
    }

    // public function sign(){
    //     $time = $_SERVER['REQUEST_TIME'];
    //     // $weixin = $_SESSION['user']['nickname'];
    //     $weixin = 'qingkunpangpang';
    //     $signDayData[date('j', $time)] = $time;             //当天签到时间
    //     $signMonData[date('n', $time)] = $signDayData;      //当天签到添加到月中
    //     $signYearData[date('Y', $time)] = $signMonData;     //当月签到添加到年中
    //     $where = 'weixin = "'.$weixin.'"';
    //     $exist = $this->_mod->where($where)->find();
    //     $signData = $this->objToArr(json_decode($exist['data']));
    //     $lastSignTime = $exist['last_sign_time'];

    //     if (!empty($signData[date('Y', $time)][date('n', $time)][date('j', $time)])) {
    //         // $this->ajaxReturn(0,  L('illegal_parameters'));
    //         $info['status'] = 0;
    //         $info['info'] = '您已经签到过了';
    //         return json_encode($info);
    //     }
    //     if ($exist) {
    //         if (date('Y', $time) != date('Y', $lastSignTime)) {
    //             //跨年
    //             $signData1 = $signData + $signYearData;
    //             $data['data'] = json_encode($signData1);
    //             $data['con_days'] = 1;
    //             $data['num_days'] = 1;
    //             $data['last_sign_time'] = $time;
    //             $res = $this->_mod->where($where)->save($data);
    //             // $this->ajaxReturn(1);
    //         }elseif (date('n', $time) != date('n', $lastSignTime)) {
    //             //跨月
    //             $signData1 = $signData[date('Y', $time)] + $signMonData;
    //             $signData[date('Y', $time)] = $signData1;
    //             $data['data'] = json_encode($signData);
    //             $data['con_days'] = 1;
    //             $data['num_days'] = 1;
    //             $data['last_sign_time'] = $time;
    //             $res = $this->_mod->where($where)->save($data);
    //             // $this->ajaxReturn(1);
    //         }else{
    //             $signData1 = $signData[date('Y', $time)][date('n', $time)] + $signDayData;
    //             $signData[date('Y', $time)][date('n', $time)] = $signData1;
    //             $data['data'] = json_encode($signData);
    //             $data['last_sign_time'] = $time;
    //             if ($time-$lastSignTime>86400*2) {
    //                 $data['con_days'] = 1;
    //             }else{
    //                 $data['con_days'] = $exist['con_days']+1;
    //             }
    //             $data['num_days'] = $exist['num_days']+1;
    //             $res = $this->_mod->where($where)->save($data);
    //             // $this->ajaxReturn(1);
    //         }
    //     }else{
    //         $data['weixin'] = $weixin;
    //         $data['data'] = json_encode($signYearData);
    //         $data['con_days'] = 1;
    //         $data['num_days'] = 1;

    //         $res = $this->_mod->add($data);
    //     }
    //     if ($res) {
    //         $info['status'] = 1;
    //         $info['info'] = '签到成功';
    //         return json_encode($info);
    //     }else{
    //         $info['status'] = 0;
    //         $info['info'] = '签到失败';
    //         return json_encode($info);
    //     }
    // }

    //     public function sign(){
    //     $time = $_SERVER['REQUEST_TIME'];
    //     // $weixin = $_SESSION['user']['nickname'];
    //     $weixin = 'qingkunpangpang';
    //     $signDayData[date('j', $time)] = $time;             //当天签到时间
    //     $signMonData[date('n', $time)] = $signDayData;      //当天签到添加到月中
    //     $signYearData[date('Y', $time)] = $signMonData;     //当月签到添加到年中
    //     $where = 'weixin = "'.$weixin.'"';
    //     $exist = $this->_mod->where($where)->find();
    //     $signData = $this->objToArr(json_decode($exist['data']));
    //     $lastSignTime = $exist['last_sign_time'];

    //     if (!empty($signData[date('Y', $time)][date('n', $time)][date('j', $time)])) {
    //         $this->ajaxReturn(0,  L('operation_failure'));
    //     }
    //     if ($exist) {
    //         if (date('Y', $time) != date('Y', $lastSignTime)) {
    //             //跨年
    //             $signData1 = $signData + $signYearData;
    //             $data['data'] = json_encode($signData1);
    //             $data['con_days'] = 1;
    //             $data['num_days'] = 1;
    //             $data['last_sign_time'] = $time;
    //             $res = $this->_mod->where($where)->save($data);
    //         }elseif (date('n', $time) != date('n', $lastSignTime)) {
    //             //跨月
    //             $signData1 = $signData[date('Y', $time)] + $signMonData;
    //             $signData[date('Y', $time)] = $signData1;
    //             $data['data'] = json_encode($signData);
    //             $data['con_days'] = 1;
    //             $data['num_days'] = 1;
    //             $data['last_sign_time'] = $time;
    //             $res = $this->_mod->where($where)->save($data);
    //         }else{
    //             $signData1 = $signData[date('Y', $time)][date('n', $time)] + $signDayData;
    //             $signData[date('Y', $time)][date('n', $time)] = $signData1;
    //             $data['data'] = json_encode($signData);
    //             $data['last_sign_time'] = $time;
    //             if ($time-$lastSignTime>86400*2) {
    //                 $data['con_days'] = 1;
    //             }else{
    //                 $data['con_days'] = $exist['con_days']+1;
    //             }
    //             $data['num_days'] = $exist['num_days']+1;
    //             $res = $this->_mod->where($where)->save($data);
    //         }
    //         if ($res) {
    //             $this->ajaxReturn(1,  L('operation_success'));
    //         }
    //     }else{
    //         $data['weixin'] = $weixin;
    //         $data['data'] = json_encode($signYearData);
    //         $data['con_days'] = 1;
    //         $data['num_days'] = 1;

    //         $res = $this->_mod->add($data);
    //         if ($res) {
    //             $this->ajaxReturn(1,  L('operation_success'));
    //         }
    //     }
    // }

  public function sign(){
        $time = $_SERVER['REQUEST_TIME'];
        // $weixin = $_SESSION['user']['nickname'];
        $weixin = 'qingkunpangpang';
        $signDayData[date('j', $time)] = $time;             //当天签到时间
        $signMonData[date('n', $time)] = $signDayData;      //当天签到添加到月中
        $signYearData[date('Y', $time)] = $signMonData;     //当月签到添加到年中
        $where = 'weixin = "'.$weixin.'"';
        $exist = $this->_mod->where($where)->find();
        $signData = $this->objToArr(json_decode($exist['data']));
        $lastSignTime = $exist['last_sign_time'];

        
        if ($exist) {
            if (!empty($signData[date('Y', $time)][date('n', $time)][date('j', $time)])) {
                // $this->ajaxReturn(0,  L('operation_failure'));
                $info['status'] = 0;
                $info['msg'] = L('operation_failure');
                echo json_encode($info);
            }else{
                if (date('Y', $time) != date('Y', $lastSignTime)) {
                    //跨年
                    $signData1 = $signData + $signYearData;
                    $data['data'] = json_encode($signData1);
                    $data['con_days'] = 1;
                    $data['num_days'] = 1;
                    $data['last_sign_time'] = $time;
                    $res = $this->_mod->where($where)->save($data);
                }elseif (date('n', $time) != date('n', $lastSignTime)) {
                    //跨月
                    $signData1 = $signData[date('Y', $time)] + $signMonData;
                    $signData[date('Y', $time)] = $signData1;
                    $data['data'] = json_encode($signData);
                    $data['con_days'] = 1;
                    $data['num_days'] = 1;
                    $data['last_sign_time'] = $time;
                    $res = $this->_mod->where($where)->save($data);
                }else{
                    $signData1 = $signData[date('Y', $time)][date('n', $time)] + $signDayData;
                    $signData[date('Y', $time)][date('n', $time)] = $signData1;
                    $data['data'] = json_encode($signData);
                    $data['last_sign_time'] = $time;
                    if ($time-$lastSignTime>86400*2) {
                        $data['con_days'] = 1;
                    }else{
                        $data['con_days'] = $exist['con_days']+1;
                    }
                    $data['num_days'] = $exist['num_days']+1;
                    $res = $this->_mod->where($where)->save($data);
                }
                if ($res) {
                    // $this->ajaxReturn(1,  L('operation_success'));
                    $info['status'] = 1;
                    $info['msg'] = L('operation_success');
                    echo json_encode($info);
                }
            }
        }else{
            $data['weixin'] = $weixin;
            $data['data'] = json_encode($signYearData);
            $data['con_days'] = 1;
            $data['num_days'] = 1;

            $res = $this->_mod->add($data);
            if ($res) {
                $info['status'] = 1;
                $info['msg'] = L('operation_success');
                echo json_encode($info);
            }
        }
    }




    //   public function getSignData(){

    //     $year = I('post.y');
    //     $month = I('post.m');
    //     // $weixin = $_SESSION['user']['nickname'];
    //     $weixin = 'qingkunpangpang';
    //     $where = 'weixin = "'.$weixin.'"';
    //     $exist = $this->_mod->where($where)->find();
    //     $signData = $this->objToArr(json_decode($exist['data']));
    //     $data = $signData[$year][$month];
    //     $data = array_keys($data);
    //     // $data = array_flip($data);
    //     echo json_encode($data);
    // }
    public function getSignData(){

        $year = I('post.y');
        $month = I('post.m');
        // $weixin = $_SESSION['user']['nickname'];
        $weixin = 'qingkunpangpang';
        $where = 'weixin = "'.$weixin.'"';
        $exist = $this->_mod->where($where)->find();
        $signData = $this->objToArr(json_decode($exist['data']));
        $data = $signData[$year][$month];
        $data = array_keys($data);
        $i = 0;
        foreach ($data as $val) {
            $signDay[$i]['signDay'] = $val;
            $i++;
        }
        echo json_encode($signDay);
    } 


    //obj转array
    protected function objToArr($obj){
        $ret = array();
        foreach($obj as $key =>$value){
            if(gettype($value) == 'array' || gettype($value) == 'object'){
                $ret[$key] = $this->objToArr($value);
            }
            else{
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
}