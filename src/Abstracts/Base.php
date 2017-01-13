<?php
/**
 * @Author: beenlee
 * @Date:   2016-03-06 00:37:56
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-10 14:29:52
 */

namespace Beenlee\Framework\Abstracts;
use Beenlee\Framework\App\App;
use Beenlee\Framework\Storage\Storage;

abstract class Base {

    /**
     * App 对象
     * @var App对象
     */
    protected $_app = null;

    /**
     * 获取应用
     * @return App
     */
    public function getApp() {
        
        if (null === $this->_app) {
            $this->_app = App::getInstance();
        }
        return $this->_app;
    }
    
    public function  getRequest () { 
        return $this->getApp()->getRequest();
    }

    public function getView () {
        return $this->getApp()->getView();
    }

    /**
     * 获取内存中缓存的数据
     * @param  string $ns  命名空间
     * @param  string $key 变量名
     * @return mix      缓存的变量
     */
    public function getData ($ns, $key) {
        return $this->getApp()->getData($ns, $key);
    }
}
