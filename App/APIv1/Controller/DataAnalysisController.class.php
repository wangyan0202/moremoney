<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2016-8-8
 * Time: 下午 6:41
 */

namespace APIv1\Controller;

use \Think\Controller;
use Think\Session\Driver\Memcache;


class DataAnalysisController extends Controller
{
    public function index()
    {

        $this->show("Hello DataAnalysis");
    }
    /*
    Coder:Jimersy Lee
    CreateTime:2016-8-9 上午 10:12
    Desc:sql找出某标中重复购买的id,2根据id查找user_money_log的memo='在线充值'的sum(money) 3查找payment_notice表中的user_id=$id的sum(money),取出所有notice_sn 4 在连连充值表中查找notice_sn,看是否有充值记录
    */
    /**找出异常用户
     * @param $deal_id
     */
    public function findHackUser($deal_id)
    {
        //打开连连充值表

        $lianlianColBill = file_get_contents(__DIR__ . "/lianlian.csv");

        $deal = M('deal');
        $name = $deal->where("id=$deal_id")->getfield('name');
        file_put_contents(__DIR__ . "/record.txt", "deal_name=" . $name . "\r\n", FILE_APPEND);
        $deal_load = M('deal_load');
        $result = $deal_load->where("deal_id=$deal_id")->group('user_id')->order('user_id asc')->select();
        if ($result) {
            //循环,根据user_id去查资金记录
            foreach ($result as $k => $v) {
                $user_id = $result[$k]['user_id'];
                $money_log = M('user_money_log');
                $sum_money = $money_log->where("user_id=$user_id and memo='在线充值'")->getField('sum(money)');
                //然后去查payment_notice
                $payment_notice = M('payment_notice');
                $payment_notice_sum_money = $payment_notice->where("user_id=$user_id and is_paid=1")->getField('sum(money)');
                if ($sum_money == $payment_notice_sum_money) {
                    //money_log中的充值记录=payment_notice表中的支付记录
                    //继续去连连充值表中找
                    $array_notice_sn = $payment_notice->where("user_id=$user_id and is_paid=1")->getField("notice_sn", true);
                    //
                    foreach ($array_notice_sn as $v) {
                        $bool_is_find = strpos($lianlianColBill, $v);
                        if ($bool_is_find <> false) {
                            //找到


                        } else {
                            //没找到,不正常
                            file_put_contents(__DIR__ . "/record.txt", "user_id=" . $user_id . "," . $v . "单号未找到\r\n", FILE_APPEND);
                        }
                    }
                } else {
                    //money_log中的充值记录<>payment_notice表中的支付记录,
                    file_put_contents(__DIR__ . "/record.txt", "user_id=" . $user_id . ",money_log_money=" . $sum_money . ",payment_notice_money=" . $payment_notice_sum_money . "\r\n", FILE_APPEND);

                }

            }
        } else {

        }

        echo "$name complete";

    }
    /*
    Coder:Jimersy Lee
    CreateTime:2016-8-9 上午 10:15
    Desc:1 sql找出某标中购买过的distinct id,
    2根据id查找user_money_log的memo='在线充值' or memo='提现申请' or memo='提现手续费' or memo='偿还本息'的sum(money)
    3查找投资表deal_load中此用户的在投资产总额和user_money_log的资金总额(充值+提现(提现为负数)),如果差值大于10元,则筛选出来
    4 在连连充值表中查找notice_sn,看是否有充值记录
    */
    /**查找异常用户升级方法
     * @param $deal_id
     */
    public function findHackUser2($deal_id)
    {
        //打开连连充值表

        $lianlianColBill = file_get_contents(__DIR__ . "/lianlian.csv");

        $deal = M('deal');
        $name = $deal->where("id=$deal_id")->getfield('name');
        file_put_contents(__DIR__ . "/record2.txt", "deal_id=" . $deal_id . ",deal_name=" . $name . "\r\n", FILE_APPEND);
        $deal_load = M('deal_load');
        $result = $deal_load->where("deal_id=$deal_id")->distinct(true)->field('user_id')->select();
        if ($result) {
            //循环,根据user_id去查资金记录
            foreach ($result as $k => $v) {
                $user_id = $result[$k]['user_id'];
                $money_log = M('user_money_log');
                $sum_money = $money_log->where("user_id=$user_id and memo='在线充值'")->getField('sum(money)');
                //然后去查payment_notice
                $payment_notice = M('payment_notice');
                $payment_notice_sum_money = $payment_notice->where("user_id=$user_id and is_paid=1")->getField('sum(money)');
                if ($sum_money == $payment_notice_sum_money) {
                    //money_log中的充值记录=payment_notice表中的支付记录
                    //继续去连连充值表中找
                    $array_notice_sn = $payment_notice->where("user_id=$user_id and is_paid=1")->getField("notice_sn", true);
                    //判断投资额是否大于充值额度
                    $deal_money_sum = $deal_load->where("user_id=$user_id and status=0 and create_date>='2016-07-15'")->getField('sum(money)');
                    $user_money_log_sum = $money_log->where("user_id=$user_id and create_time>=1468512000 and (memo='在线充值' or memo='提现申请' or memo='提现手续费' or memo='偿还本息')")->getField("sum(money)");
                    if ($deal_money_sum - 10 > $user_money_log_sum) {
                        file_put_contents(__DIR__ . "/record2.txt", "user_id=" . $user_id . ",money_log_sum=" . $user_money_log_sum . ",deal_money_sum=" . $deal_money_sum . "\r\n", FILE_APPEND);
                    } else {

                    }

                    foreach ($array_notice_sn as $value) {
                        $bool_is_find = strpos($lianlianColBill, $value);
                        if ($bool_is_find <> false) {
                            //找到


                        } else {
                            //没找到,不正常
                            file_put_contents(__DIR__ . "/record2.txt", "user_id=" . $user_id . "," . $value . "单号未找到\r\n", FILE_APPEND);
                        }
                    }
                } else {
                    //money_log中的充值记录<>payment_notice表中的支付记录,
                    file_put_contents(__DIR__ . "/record2.txt", "user_id=" . $user_id . ",money_log_money=" . $sum_money . ",payment_notice_money=" . $payment_notice_sum_money . "\r\n", FILE_APPEND);

                }

            }
        } else {

        }

        echo "$name complete";

    }

    /**
     * @param $spreaderName :推广商名字
     * @param string $date :想要生成的日期
     * @param int $type :类型 1:日期的那一整天 2从日期到现在
     */
    public function createData($spreaderName, $date = '', $type = 1)
    {
        $BeginTime = $date." 00:00:00";
        if($type==1){
            //取那一整天
            $EndTime=date('Y-m-d 00:00:00',strtotime("+1 day",strtotime($BeginTime)));
        }else{
            //参数的日期到现在
            $EndTime=date('Y-m-d',time());
        }
        $spread=M('spread');
        $db=M();


        //查询某推广商的点击广告数量
        $sql="source_name='".$spreaderName."苹果' and create_time>='$BeginTime' and create_time<='$EndTime'";
        $spreadNumIOS=$spread->where($sql)->getField('count(*)');
        $sql="source_name='".$spreaderName."安卓' and create_time>='$BeginTime' and create_time<='$EndTime'";
        $spreadNumAndroid=$spread->where($sql)->getField('count(*)');
        $spreadNumAll=$spreadNumIOS+$spreadNumAndroid;
        //查询某推广商带来的注册量
        $sql="SELECT count(*) FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name ='".$spreaderName."苹果' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') as t)";
        $resultRegNumIOS=$db->query($sql);
        $regNumIOS=(int)$resultRegNumIOS[0]['count(*)'];
        $sql="SELECT count(*) FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name ='".$spreaderName."安卓' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') as t)";
        $resultRegNumAndroid=$db->query($sql);
        $regNumAndroid= (int)$resultRegNumAndroid[0]['count(*)'];
        $regNumAll=$regNumAndroid+$regNumIOS;

        //查询某推广商的成功投资人数
        $sql="SELECT count(DISTINCT user_id) FROM yjsdata_deal_load WHERE user_id IN ( SELECT user_id FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name='".$spreaderName."苹果' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') AS t ))";
        $ResultInvestNumIOS=$db->query($sql);
        $InvestNumIOS=(int)$ResultInvestNumIOS[0]['count(distinct user_id)'];
        $sql="SELECT count(DISTINCT user_id) FROM yjsdata_deal_load WHERE user_id IN ( SELECT user_id FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name='".$spreaderName."安卓' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') AS t ))";
        $ResultInvestNumAndroid=$db->query($sql);
        $InvestNumAndroid=(int)$ResultInvestNumAndroid[0]['count(distinct user_id)'];
        $InvestNumAll=$InvestNumAndroid+$InvestNumIOS;
        //查询某推广商的成功投资总额
        $sql="SELECT sum(money) FROM yjsdata_deal_load WHERE user_id IN ( SELECT user_id FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name ='".$spreaderName."苹果' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') AS t ))";
        $ResultInvestSumIOS=$db->query($sql);
        $InvestSumIOS=(float)$ResultInvestSumIOS[0]['sum(money)'];
        $sql="SELECT sum(money) FROM yjsdata_deal_load WHERE user_id IN ( SELECT user_id FROM (( SELECT * FROM yjsdata_spread AS s JOIN ( SELECT id AS user_id, apns_code AS ac FROM yjsdata_user ) AS t1 WHERE t1.ac = s.apns_code AND s.source_name ='".$spreaderName."安卓' AND create_time >= '".$BeginTime."' and create_time<='".$EndTime."') AS t ))";
        $ResultInvestSumAndroid=$db->query($sql);
        $InvestSumAndroid=(float)$ResultInvestSumAndroid[0]['sum(money)'];
        $InvestSumAll=$InvestSumIOS+$InvestSumAndroid;
        //投资平均值
        $InvestAverageAll=round($InvestSumAll/$InvestNumAll,2);
        /*if($InvestNumAll==0){
            $InvestAverageAll=0;
        }*/
        $InvestAverageIOS=round($InvestSumIOS/$InvestNumIOS,2);
        /*if($InvestNumIOS==0){
            $InvestAverageIOS=0;
        }*/
        $InvestAverageAndroid=round($InvestSumAndroid/$InvestNumAndroid,2);
        /*if($InvestNumAndroid==0){
            $InvestAverageAndroid=0;
        }*/
        $array=array(
            '推广方'=>$spreaderName,
            '统计开始时间'=>$date,
            '统计结束时间'=>$EndTime,
            '广告点击总量'=>$spreadNumAll, // 推广总量
            'IOS点击量'=>$spreadNumIOS,  //ios推广量
            'Android点击量'=>$spreadNumAndroid,//android推广量
            '总注册量'=>$regNumAll,//总注册量
            'IOS注册量'=>$regNumIOS,//ios注册量
            'Android注册量'=>$regNumAndroid,//android注册量
            '总投资人数'=>$InvestNumAll,//总投资人数
            'IOS投资人数'=>$InvestNumIOS,//ios投资人数
            'Android投资人数'=>$InvestNumAndroid,//android投资人数
            '投资总额'=>$InvestSumAll,//投资总额
            'IOS投资总额'=>$InvestSumIOS,//ios投资总额
            'Android投资总额'=>$InvestSumAndroid,//android投资总额
            '总投资平均值'=>$InvestAverageAll,//总投资平均值
            'IOS投资平均值'=>$InvestAverageIOS,//IOS投资平均值
            'Android投资平均值'=>$InvestAverageAndroid,//android投资平均值
        );
        $str_data=json_encode($array,JSON_UNESCAPED_UNICODE);
        //var_dump($array);
        //echo $str_data;
        return $str_data;
    }


    public function createData1( $date = '', $type = 1)
    {
        $BeginDate = $date . " 00:00:00";
        $BeginTime=strtotime($BeginDate);

        if ($type == 1) {
            //取那一整天
            $EndTime = date('Y-m-d 00:00:00', strtotime("+1 day", strtotime($BeginTime)));
        } else {
            //参数的日期到现在
            $EndTime = date('Y-m-d', time());
        }
        $spread = M('spread');
        $db = M();

        //自然新增用户(总的用户-万普-有米-点乐)
        //总的新增用户
        $sql="SELECT count(*) from yjsdata_user where create_time>='$BeginTime'";
        $NewAddUser=$db->query($sql);
        //
        //推广商的新增用户
        $sql="select 'data' from yjsdata_spread_data where data_begin_time>='".$BeginDate."' and  data_end_time<='".$EndTime."'";
        $jsonData=$db->query($sql);
        $arrData=json_decode($jsonData,true);
        //var_dump($arrData);
        //exit;
        $arrBeginTime=$arrData['统计开始时间'];
        $arrEndTime=$arrData['统计结束时间'];
        //推广方的注册用户
        $spreadName=$arrData['推广方'];
        $spreadRegistrations=$arrData['总注册量'];


        //当天的新曾投资总额
        $sql="SELECT sum(money) FROM yjsdata_deal_load WHERE create_time>='".$BeginTime."' and create_time<='".$EndTime."'";
        $newAddMoney=$db->query($sql);
        







    }

    /**
     * 生成所有厂商的数据,数据库初始化的时候调用一次
     */
    public function CreateAllData(){
        //生成点乐从8.3到8.13的数据
        $DayData=$this->createData('点乐','2016-8-3');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-4');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-5');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-6');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-7');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-8');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-9');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-10');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-11');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-12');
        $this->DataInsert($DayData);
        $DayData=$this->createData('点乐','2016-8-13');
        $this->DataInsert($DayData);




    }

    function DataInsert($DataJSON){
        $DataArray=json_decode($DataJSON,true);
        $data['source_name']=$DataArray['推广方'];
        $data['data_begin_time']=$DataArray['统计开始时间'];
        $data['data_end_time']=$DataArray['统计结束时间'];
        $data['data']=$DataJSON;
        $SpreadData=M('spread_data');
        $SpreadData->add($data);
    }
}
