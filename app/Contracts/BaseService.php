<?php
/**
 * User: Master King
 * Date: 2018/11/12
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Model;

interface BaseService
{

    /**
     * 添加数据
     *
     * @param mixed $param
     * @param int $uid
     * @return array
     */
    public function create(
        $param,
        int $uid = 0
    ):array;

    /**
     * 查询一条数据
     * @param int $id
     * @param array $fields
     * @return array
     */
    public function findById(int $id, array $fields=[]):array ;

    /**
     * 分页查询
     * @param array $condition
     * @param int $limit
     * @return array
     */
    public function findAll(
        array $condition,
        int $limit
    ): array ;

    /**
     * 删除数据
     * @param array $ids    删除的ID
     * @return mixed
     */
    public function delete(array $ids) ;

    /**
     * 更新数据
     * @param array $ids    更新的ID
     * @param array $data   更新的数据
     * @return array
     */
    public function update(array $ids, array $data):array ;

    /**
     * 自增
     * @param int $id           自增的主键ID
     * @param string $field     自增的字段
     * @param int $step         增加的数据
     * @return mixed
     */
    public function increment($id, $field, $step);

    /**
     * 自减
     * @param int $id           自增的主键ID
     * @param string $field     自增的字段
     * @param int $step         增加的数据
     * @return mixed
     */
    public function decrement($id, $field, $step);
}