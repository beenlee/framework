<?php
/**
 * @file 
 * @author: dabeen(lidianbin@baidu.com)
 * @date:   2017-01-04 17:50:59
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-04 17:58:27
 */

namespace Beenlee\Framework\Conf;

class Conf {

    /**
     * 配置项所在路径
     * @var string
     */
    protected static $_confPath = '';

    /**
     * 已经加载的配置项
     * @var string
     */
    protected static $_confs = [];

    /**
     * 禁止使用new
     */
    protected function __construct() {}

    /**
     * 设置配置文件的路径末尾不加 /
     * @param string $path
     */
    public static function init ($path) {
        self::$_confPath = rtrim($path, "/");
    }

    /**
     * 加载配置文件
     * @param  string $confName 配置项名字
     * @return mix           配置信息
     */
    public static function load ($confName) {
        if (array_key_exists($confName, self::$_confs)) {
            return self::$_confs[$confName];
        }
        // 载入文件
        return  self::$_confs[$confName] = require_once(self::$_confPath . '/' . $confName . '.php');
    }
}
