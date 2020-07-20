<?php
/**
 * User: Master King
 * Date: 2019/1/18
 *
 *
 */

namespace App\Contracts;


interface StorageService
{
    public function upload(string $bucket, string  $file): array ;

   /**
    * 创建一个文件存储的文件夹
    * @param string$bucketName
    * @return bool
    */
   public function createBucket(string $bucketName): bool ;

    /**
     * 删除一个文件夹
     * @param string $bucketName
     * @return bool
     */
   public function deleteBucket(string $bucketName): bool ;

    /**
     * @param string $bucketName
     * @return bool
     */
   public function doesBucketExist(string $bucketName):bool ;


    /**
     * 根据一个key返回一个文件的地址
     * @param $key
     * @return string
     */
   public function getFile($key):string ;
}