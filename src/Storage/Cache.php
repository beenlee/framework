<?php
/**
 * @file 
 * @author: dabeen(lidianbin@baidu.com)
 * @date:   2017-01-03 16:25:37
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-03 17:03:09
 */

namespace Beenlee\Framework\Storage;
use Beenlee\Framework\Storage\StorageException;

class Cache {

    private $_config = null;
    private $_client = null;
    private $_type = null;
    private $_supportType = ['redis'];

    public function __construct($config, $type = 'redis') {
        if (!in_array($type, $this->_supportType)) {
            throw new StorageException("Cache type not Support");
        }
        $this->_config = $config;
        $this->_type = $type;
    }

    public function getCache() {
        if (!$this->_client) {
            if ($this->_type == 'redis') {
                $this->_client = new \Predis\Client($this->_config['params'], $this->_config['options']);
            }
            else {
                throw new StorageException("Cache type not Support");
            }
        }
        return $this->_client;
    }

    public function __call($name, $arguments) {
        return call_user_func_array(
            array($this->getCache(), $name),
            $arguments
        );
    }

}
