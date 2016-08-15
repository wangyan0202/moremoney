<?php

// 配置文件设置内容
// 把相应设置信息添加到Common\Config\config.php文件中
Config
	config.php

// 控制器
// 注意命名空间
// 我用的是Home
Controller
	AliyunController.class.php

// 驱动相关文件
// 放置目录ThinkPHP\Library\Think\Upload\Driver
// libs跟src是阿里官方提供的demo中的文件
// 因为暂时只用到了上传，所以没做那么多功能
Driver
	Aliyun.class.php
	Aliyun
		libs
		src
		aliyun.php

// js带进度条上传用到的uploadify文件
// 依赖的js css等相关文件
// 具体配置信息在模板里面有注释
// 配置信息可以参考uploadify中文手册
// http://www.yauld.cn/uploadifydoc/
Public
	uploadify
		jquery.min.js
		jquery.uploadify.min.js
		uploadify.css
		uploadify.swf
		uploadify-upload.png

// 模板
// 表单上传跟js上传demo
// js返回信息在用console.log打印在控制台
// 如果js返回不正常
// 请把控制器方法中的dump之类的都注释掉
// 并关闭页面Trace
View
	Aliyun
		index.html

