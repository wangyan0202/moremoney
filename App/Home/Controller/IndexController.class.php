<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show("hello",'utf-8');
    }
    public function findHackUser($deal_id){
        //打开连连充值表

        $lianlianColBill=file_get_contents(__DIR__."/lianlian.csv");

        $deal=M('deal');
        $name=$deal->where("id=$deal_id")->getfield('name');
        file_put_contents(__DIR__."/record.txt","deal_name=".$name."\r\n",FILE_APPEND);
        $deal_load=M('deal_load');
        $result=$deal_load->where("deal_id=$deal_id")->group('user_id')->order('user_id asc')->select();
        if($result){
            //循环,根据user_id去查资金记录
            foreach($result as $k=>$v){
                $user_id=$result[$k]['user_id'];
                $money_log=M('user_money_log');
                $sum_money=$money_log->where("user_id=$user_id and memo='在线充值'")->getField('sum(money)');
                //然后去查payment_notice
                $payment_notice=M('payment_notice');
                $payment_notice_sum_money=$payment_notice->where("user_id=$user_id and is_paid=1")->getField('sum(money)');
                if($sum_money==$payment_notice_sum_money){
                    //money_log中的充值记录=payment_notice表中的支付记录
                    //继续去连连充值表中找
                    $array_notice_sn=$payment_notice->where("user_id=$user_id and is_paid=1")->getField("notice_sn",true);
                    //
                    foreach($array_notice_sn as $v){
                        $bool_is_find=strpos($lianlianColBill,$v);
                        if($bool_is_find<>false){
                            //找到


                        }else{
                            //没找到,不正常
                            file_put_contents(__DIR__."/record.txt","user_id=".$user_id.",".$v."单号未找到\r\n",FILE_APPEND);
                        }
                    }
                }else{
                    //money_log中的充值记录<>payment_notice表中的支付记录,
                    file_put_contents(__DIR__."/record.txt","user_id=".$user_id.",money_log_money=".$sum_money.",payment_notice_money=".$payment_notice_sum_money."\r\n",FILE_APPEND);

                }

            }
        }else{

        }

        echo "$name complete";

    }
    public function findHackUser2($deal_id){
        //打开连连充值表

        $lianlianColBill=file_get_contents(__DIR__."/lianlian.csv");

        $deal=M('deal');
        $name=$deal->where("id=$deal_id")->getfield('name');
        file_put_contents(__DIR__."/record2.txt","deal_id=".$deal_id.",deal_name=".$name."\r\n",FILE_APPEND);
        $deal_load=M('deal_load');
        $result=$deal_load->where("deal_id=$deal_id")->distinct(true)->field('user_id')->select();
        if($result){
            //循环,根据user_id去查资金记录
            foreach($result as $k=>$v){
                $user_id=$result[$k]['user_id'];
                $money_log=M('user_money_log');
                $sum_money=$money_log->where("user_id=$user_id and memo='在线充值'")->getField('sum(money)');
                //然后去查payment_notice
                $payment_notice=M('payment_notice');
                $payment_notice_sum_money=$payment_notice->where("user_id=$user_id and is_paid=1")->getField('sum(money)');
                if($sum_money==$payment_notice_sum_money){
                    //money_log中的充值记录=payment_notice表中的支付记录
                    //继续去连连充值表中找
                    $array_notice_sn=$payment_notice->where("user_id=$user_id and is_paid=1")->getField("notice_sn",true);
                    //判断投资额是否大于充值额度
                    $deal_money_sum=$deal_load->where("user_id=$user_id and status=0 and create_date>='2016-07-15'")->getField('sum(money)');
                    $user_money_log_sum=$money_log->where("user_id=$user_id and create_time>=1468512000 and (memo='在线充值' or memo='提现申请' or memo='提现手续费' or memo='偿还本息')")->getField("sum(money)");
                    if($deal_money_sum-10>$user_money_log_sum){
                        file_put_contents(__DIR__."/record2.txt","user_id=".$user_id.",money_log_sum=".$user_money_log_sum.",deal_money_sum=".$deal_money_sum."\r\n",FILE_APPEND);
                    }else{

                    }

                    foreach($array_notice_sn as $value){
                        $bool_is_find=strpos($lianlianColBill,$value);
                        if($bool_is_find<>false){
                            //找到


                        }else{
                            //没找到,不正常
                            file_put_contents(__DIR__."/record2.txt","user_id=".$user_id.",".$value."单号未找到\r\n",FILE_APPEND);
                        }
                    }
                }else{
                    //money_log中的充值记录<>payment_notice表中的支付记录,
                    file_put_contents(__DIR__."/record2.txt","user_id=".$user_id.",money_log_money=".$sum_money.",payment_notice_money=".$payment_notice_sum_money."\r\n",FILE_APPEND);

                }

            }
        }else{

        }

        echo "$name complete";

    }


}