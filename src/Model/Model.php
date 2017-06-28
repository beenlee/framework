<?php
/**
*  Create On 2010-7-12
*  Author Been
*  QQ:281443751
*  Email:binbin1129@126.com
**/

namespace Beenlee\Framework\Model;

use Beenlee\Framework\Abstracts\Base;
use Beenlee\Framework\Storage\Storage;
use Beenlee\SqlBuilder\SqlBuilder;

class Model extends Base {

    protected static $_sb;

    /**
     * 以后用下边这个吧不用这个了
     * @return [type] [description]
     */
    public function getSqlBuilder () {
       return self::sqlBuilder();
    }

    /**
     * 以后用这个吧不用上边那个了
     * @return [type] [description]
     */
    public static function sqlBuilder () {
        if (!self::$_sb) {
            self::$_sb = new SqlBuilder();
        }
        return self::$_sb;
    }

    /**
     * 删除
     * @param  SQL  $sql SQL语句
     * @return boolean      成功或者失败
     */
    public function delete ($sql = null) {
        return self::del($sql);
    }

    /**
     * [remove description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public static function del ($sql = null) {
        $sql === null && $sql = self::sqlBuilder()->getSql();
        return Storage::getDao()->del($sql);
    }

    /**
     * 更新
     * return bool true/false
     */
    public function update ($sql = null) {
        $sql === null && $sql = self::sqlBuilder()->getSql();
        return Storage::getDao()->update($sql);
    }

    /**
     * [modify description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    // public static function modify ($sql = null) {
    //     $sql === null && $sql = self::sqlBuilder()->getSql();
    //     return Storage::getDao()->update($sql);
    // }

    /**
     * 插入一条数据
     * return id or false
     */
    public function insert ($sql = null) {
        $sql === null && $sql = self::sqlBuilder()->getSql();
        return Storage::getDao()->insert($sql);
    }

    /**
     * 选取一条数据
     * return false / array
     */
    public function fetchRow ($sql = null) {
        return self::fetchOne($sql);
    }

    /**
     * 返回多条数据
     * return array
     */
    public function fetchAll ($sql = null) {
        return self::fetchMany($sql);
    }

    /**
     * [fetchOne description]
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    public static function fetchOne ($sql = null) {
        $sql === null && $sql = self::sqlBuilder()->getSql();
        return Storage::getDao()->fetchRow($sql);
    }

    /**
     * 返回多条数据
     * return array
     */
    public static function fetchMany ($sql = null) {
        $sql === null && $sql = self::sqlBuilder()->getSql();
        return Storage::getDao()->fetchAll($sql);
    }

    /**
    * 查询符合某个条件数据在某个表中的条数
    * @param $table $filter
    * @return int
    */
    public function getTotal ($table, $filter=NULL) {
        return Storage::getDao()->getTotal($table, $filter);
    }

}