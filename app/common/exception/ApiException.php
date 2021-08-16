<?php


namespace app\common\exception;


use Exception;

class ApiException extends Exception
{
    const DEFAULT_CODE = 500;

    protected static $messageTemplate = [];

    public static function setMsgTemplate($template = [])
    {
        static::$messageTemplate = $template;
    }

    public static function getMsgTemplate(): array
    {
        return static::$messageTemplate;
    }

    public function errorMsg(): string
    {
        return "异常信息：文件-" . $this->getFile() . " 行号-" . $this->getLine() . "错误码-" . $this->getCode() . " 信息-" . $this->getMessage();
    }

    /**
     * @param $code
     * @param bool $isChinese 是否直接抛出中文
     */
    public static function throwException($code, $isChinese = false)
    {
        $class = __CLASS__;
        if ($isChinese) {
            throw new $class($code, self::DEFAULT_CODE);
        } else {
            //根据code获取msg
            $msg = static::getMsg($code);
            throw new $class($msg, $code);
        }
    }

    public static function getMsg($code)
    {
        $template = self::getMsgTemplate();

        if (isset($template[$code])) {
            return $template[$code];
        } else {
            $class = __CLASS__;
            throw new $class("错误码未设置" . $code);
        }
    }
}