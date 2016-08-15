<?php
define('OSS', 'http://*.oss-cn-qingdao.aliyuncs.com/'); //把*替换成对应的Bucket 由于经常用到该链接，所以定义成常量
return array(
    'UPLOAD_SITEIMG_OSS' => array (
                'maxSize' => 5 * 1024 * 1024,//文件大小
                'rootPath' => './',
                'saveName' => array ('uniqid', ''),
                'savePath' => 'aliyun/',    //保存路径
                'driver' => 'Aliyun',
                'driverConfig' => array (
                        'AccessKeyId' => '',    //AccessKeyId
                        'AccessKeySecret' => '',//AccessKeySecret
                        'domain' => OSS,        //
                        'Bucket' => '',         //Bucket
                        'Endpoint' => 'http://oss-cn-qingdao.aliyuncs.com',
                        //如果是杭州的服务器
                        //Endpoint设置成
                        //'Endpoint' => 'http://oss-cn-hangzhou.aliyuncs.com',
            ),
    	)
);