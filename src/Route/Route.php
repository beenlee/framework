<?php
/**
 * @file 
 * @author: dabeen(lidianbin@baidu.com)
 * @date:   2017-01-03 17:50:29
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-09 12:09:01
 */

namespace Beenlee\Framework\Route;
use Beenlee\Framework\Abstracts\Base;
use Beenlee\Framework\Request\Request;

class Route extends Base {

    protected $cName = 'Index';
    protected $aName = 'Index';
    protected $params = [];

    public function getAName() {
        return $this->aName;
    }

    public function getCName() {
        return $this->cName;
    }

    public function getParams() {
        return $this->params;
    }

    public function setAName($aName) {
        $this->aName = $aName;
    }

    public function setCName($cName) {
        $this->cName = $cName;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function getRoute() {
        return [$this->cName, $this->aName, $this->params];
    }

    public function route(Request $request) {

        $paths = explode('/', trim($request->getRequestPath(), '/'));
        if (array_key_exists(0, $paths)) {
            $this->cName = ucwords(array_shift($paths));
            if ($this->cName == '') {
                $this->cName = "Index";
            }
        }
        else {
            $this->cName = "Index";
        }

        if (array_key_exists(0,$paths)) {
            $this->aName = ucwords(array_shift($paths));
            if ($this->cName == '') {
                $this->cName = "Index";
            }
        }
        else {
            $this->aName = "Index";
        }

        while (array_key_exists(0,$paths)) {
            $this->params[array_shift($paths)] = array_shift($paths);
        }
    }

    public function forward($cName, $aName = 'Index', $params = null) {
        $this->setAName($aName);
        $this->setCName($cName);
        $this->setParams($params);
    }

}
