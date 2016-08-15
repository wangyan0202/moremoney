<?php
/**
 * tzp
 * oss上传
 */

namespace Think\Upload\Driver;
require_once dirname(__FILE__)."/Oss/oss-sdk-php.phar";
use OSS\OssClient;
use OSS\Core\OssException;
class Oss{
    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath;

    /**
     * 上传错误信息
     * @var string
     */
    private $error = ''; //上传错误信息    

    public $config = array(
        'OSS_KEYID'     =>  '',
        'OSS_SECRET'    =>  '',
        'OSS_SERVER'    =>  '',
        'OSS_SPACE'     =>  '',
        'OSS_DOMAIN'    =>  '',
        'OSS_SCHEME'    =>  '',
    );

    private static $oss = null;

    /**
     * 构造函数，用于设置上传根路径
     * @param string $root 根目录
     */
	public function __construct($root, $config = null){
           
        $this->config = array_merge($this->config, $config);
        $this->rootPath = str_replace('./', '', $root);
        


		$keyid 	= $this->config['OSS_KEYID'];			
		$secret = $this->config["OSS_SECRET"];
		$server = $this->config["OSS_SERVER"];
		$space 	= $this->config["OSS_SPACE"];
		$domain = $this->config["OSS_DOMAIN"];
		$scheme = $this->config["OSS_SCHEME"];



		$this->space = $space;
		if($domain){		
			$this->domain = $domain;
		}else{			
			$this->domain = $scheme."://".$space.".".$server;
		}

        if(!self::$oss){
        	self::$oss = new OssClient($keyid, $secret, $server);
        }
     
     	self::$oss = new OssClient($keyid, $secret, $server);   
	}

    /**
     * 检测上传根目录
     * @return boolean true-检测通过，false-检测失败
     */
    public function checkRootPath(){
		if(strpos($this->rootPath,".")===0 || strpos($this->rootPath,"/")===1 || strpos($this->rootPath,"/")===0){
			$this->error = "根目录配置不正确";
			return false;			
		}
		return true;

    }    

    /**
     * 检测保存目录
     * @param  string $savepath 上传目录
     * @return boolean          检测结果，true-通过，false-失败
     */
	public function checkSavePath($savepath){
		return true;
    }


    /**
     * 创建文件夹 
     * @param  string $savepath 目录名称
     * @return boolean          true-创建成功，false-创建失败
     */
    public function mkdir($savepath){
    	return true;
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @param  boolean $replace 同名文件是否覆盖
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save(&$file,$replace=true) {
 
    	$tagerPath = $this->rootPath.$file['savepath'].$file['savename'];

    	$selfPath = $file['tmp_name'];

        


    	try{
			self::$oss->uploadFile($this->space,$tagerPath,$selfPath);
			$file['url'] = $this->domain."/".$tagerPath;
			return true;
		}catch(OssException $e){
			$this->error = $e->getMessage();
			return false;
		}
    }


    /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->error;
    }    
}
