<?php
/**
*  Create On 2010-8-21
*  Author Been
*  QQ:281443751
*  Email:binbin1129@126.com
**/

namespace Beenlee\Framework\Request;

class Request
{

    /**
     * 请求的路径 
     * 如： /baidu/ife/id/1
     * @var string
     */
    protected $_requistPath;

    /**
     * host
     * 如 http://localhost:8080
     */
    protected $_hostUrl;


    public function __construct(){
        $this->getRequestFromURL();
    }

    public function getRequestPath() {
        return $this->_requistPath;
    }

    /**
     * 从url中获取用户的请求参数
     * 如 http://ife.baidu.com/controllername/actionname/key1/value1/key2/value2
     */
    protected function getRequestFromURL(){

        $pathStr = dirname($_SERVER["SCRIPT_NAME"]);
        $len = strlen($pathStr);
        $filter_param = array('<','>','"',"'",'%3C','%3E','%22','%27','%3c','%3e');
        $uri = str_replace($filter_param, '', $_SERVER['REQUEST_URI']);
        $posi = strpos($uri, '?');

        if ($posi) {
            $uri = substr($uri, 0, $posi);
        }
        $this->_requistPath = $uri;

        if ($_SERVER['SERVER_PORT'] == 80){
            $this->hostUrl = "http://".$_SERVER['SERVER_NAME'];
        }
        else {
            $this->hostUrl = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'];
        }

        return $this;
    }

    /**
     * 根据key获取传来的数据的值 如果没有返回null
     *
     * @param string $key
     * @return string or NULL
     */
    public function get($key, $mode = null) {
        $val = null;
        $val = isset($_GET[$key]) ? $_GET[$key] : null;
        return $this->filter($val, $mode);
    }

    /**
     * 根据key获取传来的数据的值 如果没有返回null
     *
     * @param string $key
     * @return string or NULL
     */
    public function post($key, $mode = null) {
        $val = null;
        $val = array_key_exists($key, $_POST) ? $_POST[$key] : null;
        return $this->filter($val, $mode);
    }

    /**
     * 过滤参数
     * @param  string $val  值
     * @param  string $mode 期望的类型
     * @return mix
     */
    protected function filter($val, $mode) {
        if (null !== $val && $mode) {
            if ($mode == 'int') {
                return (int) $val;
            }
            else if ($mode == 'noscript') {
                $preg = "/<script[\s\S]*?<\/script>/i";
                return preg_replace($preg, '', $val, 3);
            }
            else if ($mode == 'htmlEncode') {
                return htmlspecialchars($val);
            }
        } 
        return $val;
    }

    public function __get($name) {
        return $this->$name;
    }

}