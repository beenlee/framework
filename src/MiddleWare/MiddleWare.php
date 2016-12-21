<?php
/**
 * @Author: beenlee
 * @Date:   2016-03-17 14:22:06
 * @Last Modified by:   dabeen
 * @Last Modified time: 2016-12-21 15:35:01
 */
namespace Beenlee\Framework\MiddleWare;

use Beenlee\Framework\Abstracts\Base;

abstract class MiddleWare extends Base {

    abstract public function excute();
    
    public function getCName(){
        return $this->getRequest()->cName;
    }
    
    public function getAName(){
        return $this->getRequest()->aName;
    }

}
