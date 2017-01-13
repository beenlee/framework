<?php
/**
*  Create On 2010-7-12
*  Author Been
*  QQ:281443751
*  Email:binbin1129@126.com
**/

namespace Beenlee\Framework\App;
use Beenlee\Framework\Storage\Storage;
use Beenlee\Framework\Request\Request;
use Beenlee\Framework\MiddleWare\MiddleWare;
use Beenlee\Framework\Route\Route;

class App {
    protected static $_instance = null;
    protected $_request;

    protected $_appNameSpace;

    protected $_view;

    protected $_router;

    protected $_data = array(); //用于存储一些自定义的数据在内存中
    protected $_models = array();//用于存储加载过的model类

    protected $_confPath = "./";
    protected $_confs = array();//用于存储加载过的配置项

    // 中间件列表
    protected $_MWList = array();

    protected function __construct(){
        Storage::getSession()->start();
        $this -> _request = new Request();
    }

    /**
     * 获取实例 
     * @return APP
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function run($appNameSpace) {
        $this->_appNameSpace = $appNameSpace;
        if (!$this->_router) {
            $this->setRouter(new Route($this->_appNameSpace));
        }
        $this->_router->route($this->_request);
        $this->excuteMiddleWare(array($this, 'dispatch'));
    }

    /**
     * 依次执行middleWare
     *
     * @param  mix $callback
     */
    public function excuteMiddleWare($callback) {
        $mw = array_shift($this->_MWList);
        if (!$mw) {
            call_user_func($callback);
        }
        else {
            $mw->excuteBefore();
            $mw->excute(array($this, 'excuteMiddleWare'), $callback);
            $mw->excuteAfter();
        }
    }

    /**
     * 获取request数据
     * */
    public function getRequest () {
        return $this->_request;
    }

    public function dispatch () {
        call_user_func_array([$this, 'runCA'], $this->_router->getRoute());
        // $this->runCA();
    }

    public function getRouter() {
        return $this->_router;
    }

    public function setRouter(Route $router = null) {
        $this->_router = $router;
    }

    /**
     * 
     * @param unknown_type $Viewarr
     * @return string
     */
    public function setView ($view) {
        $this -> _view = $view;
        return $this;
    }

    /**
     * 
     * @return View
     */
    public function getView () {
        return $this -> _view;
    }

    /**
     * 注册中间件
     * @param  MiddleWare $mw [description]
     * @return [type]         [description]
     */
    public function registMiddleWare(MiddleWare $mw) {
        $this -> _MWList[] = $mw;
        return $this;
    }


    /**
     * 添加缓存数据
     * @param unknown_type $key
     * @param unknown_type $value
     */
    public function putData ($namespace, $key, $value) {
        if (!isset($this -> _data[$namespace])) {
            $this -> _data[$namespace] = array();
        }
        $this -> _data[$namespace][$key] = $value;
        return $this;
    }
    
    /**
     * 通过key获取缓存的数据
     * @param unknown_type $key
     * @return multitype:
     */
    public function getData ($namespace, $key = null) {
        if (isset($this->_data[$namespace])) {
            if ($key !== null) {
                return isset($this->_data[$namespace][$key]) ? $this->_data[$namespace][$key] : null;
            }
            else {
                return $this->_data[$namespace];
            }
        }

        return null;
    }

    /**
     * 执行控制器的方法
     *
     * @param string $cName
     * @param string $aName
     * @return controller
     */
    protected function runCA($cName, $aName, $param = null) {

        $cName = $this->_appNameSpace . '\\Controller\\' . $cName . 'Controller';

        if (class_exists($cName)) {
            $aName = $aName . 'Action';
            $controller = new $cName();

            if (method_exists($controller, $aName)) {
                call_user_func_array([$controller, $aName], [$param]);
            }
            else {
                throw new \Exception("$cName::$aName Not Exists");
            }
        }
        else {
            throw new \Exception("$cName Not Exists");
        }

        // if ($param) {
        //     $controller->$aName($param);
        // }
        // else {
        //     $controller->$aName();
        // }
    }



}