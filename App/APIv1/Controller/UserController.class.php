<?php
namespace APIv1\Controller;
use Think\Controller;
class UserController extends Controller {
    /**用户登录
     * @param $userName:账号
     * @param $userPwd:密码
     */
    public function Login($userName,$userPwd){


    }

    /**用户登出
     * @param $OAuthToken:秘钥
     */
    public function LoginOut($OAuthToken){

    }


    /**获取用户详细资料 总资产 在投资产 余额 累计收益 绑定的银行卡
     * @param $OAuthToken
     */
    public function GetDetails($OAuthToken){

    }

    /**修改登录密码
     * @param $OAuthToken
     * @param $oldPsw:旧密码
     * @param $oldPswConfirm:旧密码确认
     * @param $newPsw:新密码
     */
    public function ChangeLoginPsw($OAuthToken,$oldPsw,$oldPswConfirm,$newPsw){

    }

    /**修改支付密码
     * @param $OAuthToken
     * @param $oldPsw:旧密码
     * @param $oldPswConfirm:旧密码确认
     * @param $newPsw:新密码
     */
    public function ChangePayPsw($OAuthToken,$oldPsw,$oldPswConfirm,$newPsw){

    }

    /**获取余额
     * @param $OAuthToken
     */
    public function GetBalance($OAuthToken){

    }

    /**获取投资记录
     * @param $OAuthToken
     * @param $page:第几页
     */
    public function GetInvestRecord($OAuthToken,$page){

    }

    /**获取资金记录
     * @param $OAuthToken
     * @param $page:页数
     */
    public function GetMoneyRecord($OAuthToken,$page){

    }

    /**提现
     * @param $OAuthToken
     * @param $cardNum:提现的卡号,要绑定的卡号才能提醒
     * @param $moneyAmount:提现金额,要小于等于余额
     */
    public function Withdraw($OAuthToken,$cardNum,$moneyAmount){

    }

    /**充值
     * @param $OAuthToken
     * @param $cardNum:用来充值的卡号
     * @param $moneyAmount:充值金额
     */
    public function charge($OAuthToken,$cardNum,$moneyAmount){

    }



}