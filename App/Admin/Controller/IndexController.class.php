<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display();
    }

    public function progressData()
    {
        //查询有米转化率

        $arr = $this->getConvertPercent('有米');
        $this->assign('regPercentYoumi', $arr['regPercent']);
        $this->assign('investPercentYoumi', $arr['investPercent']);

        $arr = $this->getConvertPercent('万普');
        $this->assign('regPercentWanpu', $arr['regPercent']);
        $this->assign('investPercentWanpu', $arr['investPercent']);

        $arr = $this->getConvertPercent('点乐');
        $this->assign('regPercentDianle', $arr['regPercent']);
        $this->assign('investPercentDianle', $arr['investPercent']);

        $this->display();
    }

    /**显示投资总额各个渠道的占比和投资总额变化
     *
     */
    public function investData()
    {
        //渲染总额饼状图开始
        $arr = $this->getInvestSum('有米');
        $this->assign('investSumYoumi', $arr['investSum']);
        $arr = $this->getInvestSum('点乐');
        $this->assign('investSumDianle', $arr['investSum']);
        $arr = $this->getInvestSum('万普');
        $this->assign('investSumWanpu', $arr['investSum']);
        //渲染总额饼状图结束
        //渲染每日总额折线变化图开始
        $data=$this->get7DaysInvest('有米');
        $this->assign('youmiData',$data['investData']);
        $data=$this->get7DaysInvest('万普');
        $this->assign('wanpuData',$data['investData']);
        $data=$this->get7DaysInvest('点乐');
        $this->assign('dianleData',$data['investData']);


        //渲染每日总额折线变化图结束
        //渲染日期
        $this->assign('date',$data['investDate']);

        $this->display();
    }

    /**显示新增用户来源
     *
     */
    public function sourceData(){

    }

    /**获取最近7天的某推广商的投资总额
     * @param $spreaderName:推广商名字
     * @return array:'investData'=>$returnData,'investDate'=>$returnDate
     */
    function get7DaysInvest($spreaderName)
    {
        $returnData='';
        $returnDate='';
        $sd = M('spread_data');
        $db=M();
        $sql="select * from ((select * from yjsdata_spread_data where source_name='$spreaderName' order by id desc limit 7) as t) order by id";
        $result=$db->query($sql);
        //取最近7天的数据
        //$result = $sd->where("source_name='$spreaderName'")->order('id desc')->limit(7)->select();
        if ($result) {
            foreach ($result as $k => $v) {
                $data = $v['data'];
                $dataArr = json_decode($data, true);
                $returnData=$returnData.$dataArr['投资总额'].",";
                $returnDate=$returnDate."'".$dataArr['统计开始时间']."',";
            }
        }
        return array('investData'=>$returnData,'investDate'=>$returnDate);

    }

    /**获取某推广商的总转化率
     * @param $spreaderName :推广商名字
     * @return array
     */
    function getConvertPercent($spreaderName)
    {
        //查询有米的所有点击总量
        $clickNum = 0;
        $regNum = 0;
        $investNum = 0;

        $clickNumIOS = 0;
        $clickNumAndroid = 0;
        $regNumIOS = 0;
        $regNumAndroid = 0;
        $investNumIOS = 0;
        $investNumAndroid = 0;
        $spreadData = M('spread_data');
        $result = $spreadData->where("source_name='$spreaderName'")->select();
        if ($result) {
            foreach ($result as $k => $v) {
                $data = $v['data'];
                $dataArr = json_decode($data, true);
                $clickNum += $dataArr['广告点击总量'];
                $regNum += $dataArr['总注册量'];
                $investNum += $dataArr['总投资人数'];
            }
        }
        $regPercent = round($regNum / $clickNum, 4) * 100;
        $investPercent = round($investNum / $clickNum, 4) * 100;
        $arr = array('regPercent' => $regPercent, 'investPercent' => $investPercent);
        return $arr;
    }

    /**获取某推广商的投资总额
     * @param $spreaderName
     */
    function getInvestSum($spreaderName)
    {
        $investSum = 0;
        $investSumIOS = 0;
        $investSumAndroid = 0;
        $spreadData = M('spread_data');
        $result = $spreadData->where("source_name='$spreaderName'")->select();
        if ($result) {
            foreach ($result as $k => $v) {
                $data = $v['data'];
                $dataArr = json_decode($data, true);
                $investSum += $dataArr['投资总额'];
                $investSumIOS += $dataArr['IOS投资总额'];
                $investSumAndroid += $dataArr['Android投资总额'];
            }
        }
        $investSum = round($investSum, 2);
        $investSumIOS = round($investSumIOS, 2);
        $investSumAndroid = round($investSumAndroid, 2);


        $arr = array('investSum' => $investSum, 'investSumIOS' => $investSumIOS, 'investSumAndroid' => $investSumAndroid);
        return $arr;

    }

}














