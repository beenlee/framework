<?php
/**
 * @file 
 * @author: dabeen(lidianbin@baidu.com)
 * @date:   2017-01-03 17:50:29
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-22 14:45:42
 */

namespace Beenlee\Framework\Route;
use Beenlee\Framework\Abstracts\Base;
use Beenlee\Framework\Request\Request;

class Route extends Base {

    protected $cName = 'Index';
    protected $aName = 'Index';
    protected $routerPath = 'Index\\Index';
    protected $params = [];

    public function getAName () {
        return $this->aName;
    }

    public function getCName () {
        return $this->cName;
    }

    public function getRouterPath () {
        return $this->routerPath;
    }

    public function getParams () {
        return $this->params;
    }

    public function setAName ($aName) {
        $this->aName = $aName;
    }

    public function setCName ($cName) {
        $this->cName = $cName;
    }

    public function setRouterPath ($routerPath) {
        $this->routerPath = $routerPath;
    }

    public function setParams ($params) {
        $this->params = $params;
    }

    public function getRoute () {
        return [$this->cName, $this->aName, $this->params];
    }

    public function route (Request $request) {

        $paths = explode('/', trim($request->getRequestPath(), '/'));
        if (isset($paths[0])) {
            $this->cName = ucwords(array_shift($paths));
            if ($this->cName == '') {
                $this->cName = "Index";
            }
        }
        else {
            $this->cName = "Index";
        }

        if (isset($paths[0])) {
            $this->aName = ucwords(array_shift($paths));
            if ($this->cName == '') {
                $this->cName = "Index";
            }
        }
        else {
            $this->aName = "Index";
        }

        $this->routerPath = $this->cName . '\\' . $this->aName;

        while (isset($paths[0])) {
            $this->params[] = array_shift($paths);
        }
    }

    public function forward ($cName, $aName = 'Index', $params = null) {
        $this->setAName($aName);
        $this->setCName($cName);
        $this->setParams($params);
    }

}
