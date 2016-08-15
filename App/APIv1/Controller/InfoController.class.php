<?php
/**
 * Created by PhpStorm.
 * User: Jimersy Lee
 * Date: 2016/7/30 0030
 * Time: 下午 11:14
 * 获取一些公共信息,无需权限
 */

namespace APIv1\Controller;
use Think\Controller;

class InfoController extends Controller
{

    public function index(){
        $this->show("info");
    }
    /**
     * 获取公告列表
     */
    public function GetNoticeList($page){

    }

    /**获取公告内容
     * @param $noticeID:公告ID
     */
    public function GetNotice($noticeID){

    }

    /**获取新闻列表
     * @param $page
     */
    public function GetNewsList($page){

    }

    /**获取新闻内容
     * @param $newsID:新闻ID
     */
    public function GetNews($newsID){

    }


    /**
     * 获取帮助列表
     */
    public function GetHelpList(){

    }

    /**获取帮助内容
     * @param $helpID:帮助ID
     */
    public function GetHelp($helpID){

    }

}