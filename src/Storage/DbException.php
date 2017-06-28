<?php
/**
 * @file 
 * @author: dabeen(lidianbin@baidu.com)
 * @date:   2017-01-04 13:21:46
 * @Last Modified by:   dabeen
 * @Last Modified time: 2017-01-19 15:17:05
 */

namespace Beenlee\Framework\Storage;
use Beenlee\Framework\Storage\StorageException;

class DbException extends StorageException {
    const ER_DUP_ENTRY = 1062;
}