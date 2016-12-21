<?php
/**
 * @Author: beenlee
 * @Date:   2016-03-17 14:22:06
 * @Last Modified by:   dabeen
 * @Last Modified time: 2016-12-21 14:18:27
 */
namespace Beenlee\Framework\MiddleWare;
use Beenlee\Framework\Base\Base;
include_once('Base.class.php');

abstract class MiddleWare extends \Been\Base {

    abstract public function excute();
    
    public function getCName(){
        return $this->getRequest()->cName;
    }
    
    public function getAName(){
        return $this->getRequest()->aName;
    }

}
