<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2016/7/30 0030
 * Time: 下午 9:09
 * 用户投资相关接口
 */
namespace APIv1\Controller;
use Think\Controller;
class InvestController extends Controller{
    /**投资某一个产品
     * @param $OAuthToken
     * @param $pID:产品ID
     * @param $amount:数量:金额
     * @param $redPacketID:使用的红包ID
     */
    public function BuyProduct($OAuthToken,$productID,$amount,$redPacketID){

    }

    /**获取产品细节
     * @param $OAuthToken
     * @param $productID:投资产品ID
     */
    public function GetProductDetails($OAuthToken,$productID){

    }

    /**获取投资产品列表
     * @param $OAuthToken
     */
    public function GetProductList($OAuthToken,$page){

    }

    /**获取订单支付状态
     * @param $paymentID:订单ID
     */
    public function GetPaymentStatus($paymentID){

    }



}