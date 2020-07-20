<?php
/**
 * User: Master King
 * Date: 2018/10/30
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

class AppException extends Exception
{
    // 记录次数
    private static $logtime = 0;

    /**
     * AppException constructor.
     * @param string $outputMessage  输出错误信息
     * @param int|null $code         输出错误码
     * @param Exception|null $e      捕捉的Exception，如果为null 就用前者
     */
    public function __construct(string $outputMessage,  ?int $code = 0, Exception $e=null)
    {
        if ($e != null) $this->logger($e);
        parent::__construct(
            $outputMessage,
            $code
        );
    }

    private function logger(Exception $e){
        if (Request::capture()->cookies->count() == 0) {
            print $e->getTraceAsString();
        }else {
            if (self::$logtime == 0) {
                $logger = app(LoggerInterface::class);
                $logger->error(
                    $e->getMessage(),
                    ['exception' => $e]
                );
            }
            self::$logtime++;
        }

    }
}
