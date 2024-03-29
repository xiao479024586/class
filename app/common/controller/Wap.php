<?php
// +----------------------------------------------------------------------
// | RXThinkCMF框架 [ RXThinkCMF ]
// +----------------------------------------------------------------------
// | 版权所有 2017~2020 南京RXThinkCMF研发中心
// +----------------------------------------------------------------------
// | 官方网站: http://www.rxthink.cn
// +----------------------------------------------------------------------
// | Author: 牧羊人 <1175401194@qq.com>
// +----------------------------------------------------------------------

namespace app\common\controller;


/**
 * H5控制器基类
 *
 * @author 牧羊人
 * @since 2020-04-21
 */
class Wap extends CommonBase
{
    // 模型
    protected $model;
    // 服务
    protected $service;
    // 校验
    protected $validate;
    // 请求参数
    protected $params;

    protected $middleware = ['app\api\middleware\CheckToken::class'];

    public function initialize()
    {

        parent::initialize(); // TODO: Change the autogenerated stub

        $this->params = $this->request->param();
    }
}