<?php
/**
 * @Author: beenlee
 * @Date:   2016-03-17 14:22:06
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-05 18:07:13
 */
namespace Beenlee\Framework\MiddleWare;

use Beenlee\Framework\Abstracts\Base;

abstract class MiddleWare extends Base {

    // dispatch 之前
    public function excuteBefore() {
    }

    // dispatch 之后
    public function excuteAfter() {
    }

    public function excute($next, $param) {
        $this->next($next, $param);
    }

    protected function next($next, $param) {
        call_user_func($next, $param);
    }

}
