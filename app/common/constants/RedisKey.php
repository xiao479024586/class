<?php


namespace app\common\constants;


class RedisKey
{
    // 登录短信每个账户每天的发送量
    const LOGIN_SMS_QUOTA = 'login:sms:day:';
    // 手机号登录的code
    const LOGIN_SMS_CODE = 'login:sms:code:';
    // 当前用户的token
    const USER_TOKEN = 'user:token:';
    // 技师地理位置集合
    const USER_LOCATION = 'user:location';
    // 司机端显示周围维修店距离
    const CAR_ROUND_DISTANCE = 100;
    // 技师每天都有哪些是已经接单了的
    const SKILL_WORK_DAY = 'skill:work:day:';
}