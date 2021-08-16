<?php


namespace app\common\constants;


class ErrorCode
{
    /***************系统相关***************/
    const SUCCESS = 200;
    // 系统错误
    const SYSTEM_ERROR = 500;
    // 缺少参数
    const INVALID_PARAMS = 1000;
    // 缺少token
    const INVALID_TOKEN = 1001;
    // token失效
    const TOKEN_EXPIRE = 1002;
    /***************登录相关*****************/
    // 短信登录已达上限
    const LOGIN_SMS_LIMIT = 1100;
    // 验证码已失效
    const SMS_CODE_EXPIRED = 1101;
    // 注册失败
    const REGISTER_ERROR = 1102;
    // 请先登录
    const USER_NEED_LOGIN = 1103;
    // 请先注册
    const USER_NEED_REGISTER = 1108;
    // 用户不存在
    const USER_NOT_EXISTS = 1104;
    // 请勿重复操作
    const NOT_REPEAT = 1105;
    // 请上传营业执照
    const NOT_BUSINESS_LICENSE = 1106;
    // 验证码错误
    const SMS_CODE_ERROR = 1107;

    /*************用户相关****************/
    const NEED_BOND = 1200;

    /*************订单相关****************/
    // 订单不存在
    const ORDER_NOT_EXISTS = 1400;
    // 此订单不属于您
    const ORDER_NOT_FOLLOW_YOU = 1401;
    // 支付订单有误
    const PAY_ORDER_ERROR = 1402;
    // 支付金额大于订单总金额，不可支付
    const PAY_MONEY_GT_TOTAL_ERROR = 1403;

    /*************司机端相关****************/
    const CAR_ROUND_NO_SHOP = 1500;


    /*************维修店相关****************/
    // 店铺不存在
    const SHOP_NOT_EXISTS = 1600;
    // 店铺不在合作中
    const SHOP_NOT_WORK = 1601;
    // 收货地址不存在
    const USER_ADDRESS_NOT_EXISTS = 1602;
    // 收货地址状态有误不可操作
    const USER_ADDRESS_STATUS_ERROR = 1603;
    // 分类不存在
    const CATEGORY_NOT_EXISTS = 1604;
    // 商品不存在
    const GOODS_NOT_EXISTS = 1605;
    // 请先加入购物车
    const PLEASE_ADD_CART = 1606;
    // 至少购买一件哦
    const GOODS_MUST_BUY_ONE = 1607;
    // 库存已达上限
    const GOODS_MORE_THAN = 1608;
    // 保证金金额不对
    const BOND_MONEY_ERROR = 1609;
    // 请选择正确的商品
    const PLEASE_SELECT_RIGHT_GOODS = 1610;
    // 购物车中存在库存不足商品，请重新提交订单
    const CART_HAS_QUOTA_ERROR = 1611;
    // 请选择正确的商品
    const CART_GOODS_ERROR = 1612;
    // 请输入正确的原密码
    const OLD_PASSWORD = 1613;
    // 用户余额不足
    const USER_BALANCE_ERROR = 1614;
    // 商品库存不足
    const GOODS_QUOTA_ERROR = 1615;
    // 请选择技师
    const NEED_SKILL_WORKER = 1616;
}