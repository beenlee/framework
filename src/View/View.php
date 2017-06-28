<?php
/**
*  Create On 2010-7-12
*  Author Been
*  QQ:281443751
*  Email:binbin1129@126.com
**/

namespace Beenlee\Framework\View;
use Smarty;

class View {

    protected $_smartyConf = null;
    protected $_engine = null;

    protected $jsonArray = array("status"=>null, "statusInfo" => null, "data"=>null );
    protected $_tplData = array();

    // 需要被替换的文字
    protected $replaceWord = array();
    protected $_globalVars = array();

    public function __construct($conf){
        $this->_smartyConf = $conf;
        $this->replaceWord = $conf["replace_word"];
        $this->_globalVars = $conf["global_var"];
    }

    public function getEngine(){
        if (!$this->_engine) {
            $this->_engine = new Smarty();
            $this->_engine->left_delimiter  = $this->_smartyConf['left_delimiter'];
            $this->_engine->right_delimiter = $this->_smartyConf['right_delimiter'];
            $this->_engine->template_dir    = $this->_smartyConf['template_dir'];
            $this->_engine->compile_dir     = $this->_smartyConf['compile_dir'];
            $this->_engine->caching         = $this->_smartyConf['caching'];

            if ($this->_smartyConf['caching']) {
                $this->_engine->cache_lifetime  = $this->_smartyConf['cache_lifetime'] ? $this->_smartyConf['cache_lifetime'] : 3600;
                $this->_engine->cache_dir       = $this->_smartyConf['cache_dir'];
            }
        }
        return $this->_engine;
    }

    public function __set($key, $val) {
        $this->_tplData[$key] = $val;
    }

    public function __get($key){
        return $this->_tplData[$key];
    }

    public function __isset($key){
        return $this->getEngine()->getTemplateVars($key) !== null;
    }

    public function __unset($key){
        return $this->getEngine()->clearAssign($key);
    }

    public function assign($spec,$value=null){
        if(is_array($spec)){
            $this->getEngine()->assign($spec);
            return;
        }

        $this->getEngine()->assign($spec,$value);
    }

    public function clearVars() {
        $this->getEngine()->clear_all_assign();
    }
    
    public function setMsg($val) {
        $this->jsonArray["statusInfo"]=$val;
        return $this;
    }
    public function setStatus($val) {
        $this->jsonArray["status"]=$val;
        return $this;
    }
    public function setData($val) {
        $this->jsonArray["data"]=$val;
        return $this;
    }
    
    public function render($name) {
        if ($name == "json"){
            return $this -> preRender(json_encode($this->jsonArray, JSON_UNESCAPED_UNICODE));
        } 
        else if ($name == "debug") {
            return json_encode($this->_tplData, JSON_UNESCAPED_UNICODE);
        }
        $this->getEngine()->assign($this->_globalVars);
        $this->getEngine()->assign($this->_tplData);
        return $this->preRender($this->getEngine()->fetch($name));
    }

    public function display($name) {
        if ($name == 'json') {
            header("content-type:application/json;charset=utf-8");
        }
        else if ($name == 'debug') {
            header("content-type:application/json;charset=utf-8");
        }
        else {
            header("content-type:text/html;charset=utf-8");
        }

        echo $this->render($name);
    }
    
    /**
     * 在渲染之前对数据进行处理
     * 替换一些不该出现的文字
     */
    protected function preRender($str){
        
        foreach($this->replaceWord as $key => $val ){
            $str = str_replace($val,$key,$str);
        }
        return $str;
    }
}
