<?php

namespace app\common\constants;

return [
    /*************系统相关************/
    ErrorCode::SUCCESS  =>  'success',
    ErrorCode::SYSTEM_ERROR =>  '系统错误',
    ErrorCode::INVALID_PARAMS   =>  '缺少参数',
    ErrorCode::INVALID_TOKEN    =>  '缺少token',
    ErrorCode::TOKEN_EXPIRE =>  'token已失效',

    /*************登录相关***********/
    ErrorCode::LOGIN_SMS_LIMIT  =>  '短信验证码已达上限',
    ErrorCode::SMS_CODE_EXPIRED =>  '验证码已过期',
    ErrorCode::REGISTER_ERROR   =>  '注册失败',
    ErrorCode::USER_NEED_LOGIN  =>  '请先登录',
    ErrorCode::USER_NOT_EXISTS  =>  '用户不存在',
    ErrorCode::NOT_REPEAT   =>  '请勿重复操作',
    ErrorCode::NOT_BUSINESS_LICENSE =>  '请上传营业执照',
    ErrorCode::SMS_CODE_ERROR   =>  '验证码错误',
    ErrorCode::USER_NEED_REGISTER   =>  '请先注册',

    /*************用户相关***********/
    ErrorCode::NEED_BOND    =>  '请先缴纳保证金',
    /*************订单相关***********/
    ErrorCode::ORDER_NOT_EXISTS =>  '订单不存在',
    ErrorCode::ORDER_NOT_FOLLOW_YOU =>  '此订单不属于您',
    ErrorCode::PAY_ORDER_ERROR  =>  '支付订单有误',
    ErrorCode::PAY_MONEY_GT_TOTAL_ERROR =>  '支付金额大于订单总金额，不可支付',

    /*************司机相关***********/
    ErrorCode::CAR_ROUND_NO_SHOP => '周边暂无维修店',

    /*************维修店相关***********/
    ErrorCode::SHOP_NOT_EXISTS  =>  '店铺不存在',
    ErrorCode::SHOP_NOT_WORK    =>  '店铺不在合作中',
    ErrorCode::USER_ADDRESS_NOT_EXISTS  =>  '收货地址不存在',
    ErrorCode::USER_ADDRESS_STATUS_ERROR    =>  '收货地址状态有误，不可操作',
    ErrorCode::CATEGORY_NOT_EXISTS  =>  '分类不存在',
    ErrorCode::GOODS_NOT_EXISTS =>  '商品不存在',
    ErrorCode::PLEASE_ADD_CART  =>  '请先加入购物车',
    ErrorCode::GOODS_MUST_BUY_ONE   =>  '商品至少购买1件哦',
    ErrorCode::GOODS_MORE_THAN  =>  '库存已达上限',
    ErrorCode::BOND_MONEY_ERROR =>  '金额不符',
    ErrorCode::PLEASE_SELECT_RIGHT_GOODS    =>  '请选择正确的商品',
    ErrorCode::CART_HAS_QUOTA_ERROR =>  '购物车中存在库存不足商品，请重新提交订单',
    ErrorCode::CART_GOODS_ERROR =>  '请选择正确的商品',
    ErrorCode::OLD_PASSWORD =>  '请输入正确的原密码',
    ErrorCode::USER_BALANCE_ERROR   =>  '用户余额不足',
    ErrorCode::GOODS_QUOTA_ERROR    =>  '商品库存不足',
    ErrorCode::NEED_SKILL_WORKER    =>  '请选择技师',
];
