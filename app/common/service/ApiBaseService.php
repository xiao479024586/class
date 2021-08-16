<?php


namespace app\common\service;

use app\api\repositories\UserTokenEloquent;
use app\common\constants\ErrorCode;
use app\common\constants\RedisKey;
use app\common\exception\ApiException;
use think\facade\Cache;

class ApiBaseService
{
    protected $redis;

    protected $bc;

    public function __construct()
    {
        $this->redis = Cache::store('redis')->handler();
        $this->bc = new \Bc();
    }

    public function checkToken($token = '', $userId = 0)
    {
        if (empty($token) || empty($userId)) ApiException::throwException(ErrorCode::TOKEN_EXPIRE);
        $currentToken = $this->redis->get(RedisKey::USER_TOKEN . $userId);
        if (empty($currentToken)) {
            $currentToken = (new UserTokenEloquent())->getTokenByUserId($userId);
            if (empty($currentToken)) ApiException::throwException(ErrorCode::USER_NEED_LOGIN);
            $currentToken = reset($currentToken);
            $currentToken = $currentToken['token'];
        }
        if ($token != $currentToken) ApiException::throwException(ErrorCode::TOKEN_EXPIRE);
    }
}