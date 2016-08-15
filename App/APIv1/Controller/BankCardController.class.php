<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2016/7/30 0030
 * Time: 下午 8:51
 有关银行卡的API接口  www.duomi.com/APIv1/BankCard
 */

namespace APIv1\Controller;
use Think\Controller;
class BankCardController extends Controller {
    /**绑定银行卡
     * @param $OAuthToken
     * @param $cardNum:卡号
     */
    public function Bind($OAuthToken,$cardNum){

    }

    /**解绑银行卡
     * @param $OAuthToken
     * @param $cardNum:卡号
     */
    public function UnBind($OAuthToken,$cardNum){

    }

    /**获取所有绑定的银行卡
     * @param $OAuthToken
     */
    public function GetAllCard($OAuthToken){

    }

    /**获取银行卡详情
     * @param $OAuthToken
     * @param $cardNum
     */
    public function GetCardDetails($OAuthToken,$cardNum){

    }


}


/**检查银行卡号是否合法
 * @param $cardNum:卡号
 * @return bool:合法为true,非法为false
 */
function checkCardNum($cardNum){


    return false;
}