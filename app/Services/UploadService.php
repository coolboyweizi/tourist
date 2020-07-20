<?php
/**
 * User: Master King
 * Date: 2019/1/18
 */

namespace App\Services;

use App\Contracts\StorageService;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use OSS;

class UploadService implements StorageService
{
    private static $accessKeyId = "LTAIZVPk8q0SbCY5";
    private static $accessKeySecret = "1uillCelM1jeCttF4yUsA3FfDvk6TW";
    private static $endpoint = "https://oss-cn-shenzhen.aliyuncs.com";
    private static $ossClient = '';
    private $data = [];


    /**
     * 只需要实例一次
     * @return OSS\OssClient|string
     * @throws OSS\Core\OssException
     */
    protected static function getClient(){
        if (!self::$ossClient instanceof OSS\OssClient) {
            self::$ossClient = new OSS\OssClient(self::$accessKeyId,self::$accessKeySecret,self::$endpoint);
        }
        return self::$ossClient;
    }

    /**
     * @param string $bucket
     * @param string $file
     * @return array
     * @throws OSS\Core\OssException
     */
    public function upload(string $bucket, string $file): array
    {
        if ($this->createBucket($bucket) ) {
            $this->data = self::getClient()->uploadFile($bucket, $this->getUniqName(),$file);
            return $this->data;
        }
        return [];
    }

    /**
     * 创建一个存储路径
     * @param string $bucketName
     * @return bool
     * @throws OSS\Core\OssException
     */
    public function createBucket(string $bucketName): bool
    {
        return self::doesBucketExist($bucketName)?:( count(self::getClient()->createBucket($bucketName)) > 0 ? true : false);
    }

    /**
     * 删除
     * @param string $bucketName
     * @return bool
     * @throws OSS\Core\OssException
     */
    public function deleteBucket(string $bucketName): bool
    {
        return !self::doesBucketExist($bucketName)?:self::getClient()->deleteBucket($bucketName);
    }

    /**
     * 判断是否存在
     * @param string $bucketName
     * @return bool
     * @throws OSS\Core\OssException
     */
    public function doesBucketExist(string $bucketName): bool
    {
        return self::getClient()->doesBucketExist($bucketName);
    }


    /**
     * @param $key
     * @return string
     */
    public function getFile($key): string
    {
        // TODO: Implement getFile() method.
    }

    /**
     * 获取唯一名字
     * @return string
     */
    private function getUniqName(){
        return Uuid::uuid();
    }
}