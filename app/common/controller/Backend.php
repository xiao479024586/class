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

use app\admin\model\AdminRom;
use app\admin\model\Menu;
use app\admin\service\AdminRomService;
use app\common\model\system\Admin;
use think\App;
use think\exception\HttpResponseException;
use \think\facade\View;

/**
 * 系统中台控制器基类
 *
 * @author 牧羊人
 * @since 2020-04-21
 */
class Backend extends CommonBase
{
    // 模型
    protected $model;
    // 服务
    protected $service;
    // 校验
    protected $validate;
    // 登录ID
    protected $adminId;
    // 登录信息
    protected $adminInfo;
    // 网络请求
    protected $param;

    protected $middleware = ['app\admin\middleware\CheckLogin::class'];

    /**
     * 初始化
     */
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        // 初始化配置
        $this->initConfig();

        // 初始化登录信息
        $this->initLogin();

//        // 权限验证
//        $this->checkAuth();

    }

    /**
     * 初始化配置
     * @author 牧羊人
     * @since: 2020/6/30
     */
    public function initConfig()
    {
        // 系统全称
        View::assign("siteName", SITE_NAME);
        // 系统简称
        View::assign("nickName", NICK_NAME);
        // 系统版本
        View::assign("version", SYSTEM_VERSION);

        // 请求参数
        $this->param = $this->request->param();

        // 分页基础默认值
        defined('PERPAGE') or define('PERPAGE', isset($this->param['limit']) ? $this->param['limit'] : 20);
        defined('PAGE') or define('PAGE', isset($this->param['page']) ? $this->param['page'] : 1);
    }

    /**
     * 校验登录
     * @author 牧羊人
     * @since: 2020/6/30
     */
    public function initLogin()
    {
//        $noLoginActs = ['Login'];
//        if (!$this->isLogin() && !in_array($this->request->controller(), $noLoginActs)) {
//            // 跳转登录页
//            // 正确重定向方法，一定写url()
//            return $this->redirectTo(url('/login/index'));
//        }

        // 登录用户ID
        $adminId = session('adminId');
        $this->adminId = $adminId;

        // 登录用户信息
        $adminModel = new \app\admin\model\Admin();
        $adminInfo = $adminModel->getInfo($adminId);
        $this->adminInfo = $adminInfo;
        // 数据绑定
        View::assign("adminId", $this->adminId);
        View::assign("adminInfo", $this->adminInfo);

        // 获取权限列表
        $adminRomService = new AdminRomService();
        $permissionList = $adminRomService->getPermissionFuncList($adminId);
        View::assign("permissionList", $permissionList);
    }

//    /**
//     * 判断用户是否登录
//     * @return bool
//     */
//    public function isLogin()
//    {
//        // 用户未登录返回 false
//        if (empty(session('adminId'))) {
//            return false;
//        }
//        // 用户已登录返回 true
//        return true;
//    }

//    /**
//     * 自定义重定向方法
//     * @param $args
//     */
//    public function redirectTo(...$args)
//    {
//        // 此处 throw new HttpResponseException 这个异常一定要写
//        throw new HttpResponseException(redirect(...$args));
//    }

//    /**
//     * 检查权限
//     * @return array|mixed
//     * @throws \think\db\exception\DataNotFoundException
//     * @throws \think\db\exception\ModelNotFoundException
//     * @throws \think\exception\DbException
//     * @author 牧羊人
//     * @since 2020/7/9
//     */
//    private function checkAuth()
//    {
//        if (!in_array($this->request->controller(), ['Login', 'Index'])) {
//            // 获取菜单操作权限
//            $menuMod = new Menu();
//            $requestUrl = strtolower("/" . $this->request->controller() . "/" . $this->request->action());
//            $menuInfo = $menuMod->where([
//                'type' => 3,
//                'url' => $requestUrl,
//                'mark' => 1
//            ])->find();
//            if (!$menuInfo) {
//                if (IS_POST || IS_GET) {
//                    return message('暂无操作权限', false);
//                }
//                return $this->render('public/404');
//            }
//
//            // 获取节点权限
//            $adminRomMod = new AdminRom();
//            $funcList = $adminRomMod->getPermissionFuncList($this->adminInfo['role_ids'], $this->adminId, $menuInfo['id']);
//            View::assign("funcList", $funcList);
//            if (!in_array($menuInfo['permission'], $funcList)) {
//                if (IS_POST) {
//                    return message('暂无操作权限', false);
//                }
//                return $this->render('public/404');
//            }
//        }
//    }

    /**
     * 空操作捕捉
     * @return mixed
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function _empty()
    {
        return $this->render("public/403");
    }

    /**
     * 控制器默认入口
     * @return mixed
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function index()
    {
        if (IS_POST) {
            $result = $this->service->getList();
            return $result;
        }
        // 取消模板布局
        $this->app->view->layout(false);
        // 默认参数
        $data = func_get_args();
        if (isset($data[0])) {
            foreach ($data[0] as $key => $val) {
                View::assign($key, $val);
            }
        }
        return $this->render();
    }

    /**
     * 添加或编辑入口
     * @return mixed
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function edit()
    {
        if (IS_POST) {
            $result = $this->service->edit();
            return $result;
        }
        $info = [];
        $id = input("get.id", 0);
        if ($id) {
            $info = $this->model->getInfo($id);
        } else {
            $data = func_get_args();
            if (isset($data[0])) {
                foreach ($data[0] as $key => $val) {
                    $info[$key] = $val;
                }
            }
        }
        View::assign("info", $info);
        return $this->render();
    }

    /**
     * 详情入口
     * @return mixed
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function detail()
    {
        if (IS_POST) {
            $result = $this->service->edit();
            return $result;
        }
        $id = input("get.id", 0);
        if ($id) {
            $info = $this->model->getInfo($id);
            View::assign("info", $info);
        }
        return $this->render();
    }

    /**
     * 模板渲染
     * @param string $tpl 模板地址
     * @param array $data 参数
     * @return mixed
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function render($tpl = "", $data = [])
    {
        return View::fetch($tpl, $data);
    }

    /**
     * 删除单条记录
     * @return array
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function drop()
    {
        if (IS_POST) {
            $id = input('post.id');
            $info = $this->model->getInfo($id);
            if ($info) {
                $result = $this->model->drop($id);
                if ($result !== false) {
                    return message();
                }
            }
            return message($this->model->getError(), false);
        }
    }

    /**
     * 重置缓存
     * @return array
     * @author 牧羊人
     * @date 2019/5/12
     */
    public function cache()
    {
        if (IS_POST) {
            $id = input('post.id');
            if (!$id) {
                return message("记录ID不能为空", false);
            }
            $result = $this->model->_cacheReset($id, '');
            if (!$result) {
                return message("缓存重置失败", false);
            }
            return message("缓存重置成功");
        }
    }

    /**
     * 一键复制
     * @return mixed
     * @author 牧羊人
     * @date 2019/5/12
     */
    public function copy()
    {
        if (IS_POST) {
            $result = $this->service->edit();
            return $result;
        }
        $info = [];
        $id = input("get.id", 0);
        if ($id) {
            $info = $this->model->getInfo($id);
        } else {
            $data = func_get_args();
            if (isset($data[0])) {
                foreach ($data[0] as $key => $val) {
                    $info[$key] = $val;
                }
            }
        }
        // 复制作为新增数据，主键ID必须置空
        unset($info['id']);
        View::assign("info", $info);
        return $this->render('edit');
    }

    /**
     * 更新单个字段
     * @return array
     * @author 牧羊人
     * @date 2019/5/12
     */
    public function update()
    {
        if (IS_POST) {
            $data = request()->param();
            $result = $this->model->edit($data);
            if ($result) {
                return message("更新成功");
            } else {
                return message("更新失败", false);
            }
        }
    }

    /**
     * 批量删除记录
     * @return array
     * @author 牧羊人
     * @date 2019/2/25
     */
    public function batchDrop()
    {
        if (IS_POST) {
            $ids = explode(',', $_POST['id']);
            //批量删除
            $num = 0;
            foreach ($ids as $key => $val) {
                $res = $this->model->drop($val);
                if ($res !== false) {
                    $num++;
                }
            }
            return message('本次共选择' . count($ids) . "个条数据,删除" . $num . "个");
        }
    }

    /**
     * 批量重置缓存
     * @return array
     * @author 牧羊人
     * @date 2019/5/9
     */
    public function batchCache()
    {
        if (IS_POST) {
            $ids = explode(',', $_POST['id']);
            //重置缓存
            foreach ($ids as $key => $val) {
                $this->model->_cacheReset($val);
            }
            return message('重置缓存成功！');
        }
    }

    /**
     * 批量设置状态
     * @return array
     * @author 牧羊人
     * @date 2019/5/15
     */
    public function batchStatus()
    {
        if (IS_POST) {
            $ids = explode(',', $_POST['id']);
            $status = (int)$_POST['status'];
            if (!is_array($ids)) {
                return message("请选择数据记录", false);
            }
            $num = 0;
            foreach ($ids as $key => $val) {
                $result = $this->model->edit([
                    'id' => $val,
                    'status' => $status,
                ]);
                if ($result) {
                    $num++;
                }
            }
            return message("本次共更新【{$num}】条记录");
        }
    }

    /**
     * 设置状态
     * @return mixed
     * @author 牧羊人
     * @date 2019/11/2
     */
    public function setStatus()
    {
        if (IS_POST) {
            $result = $this->service->setStatus();
            return $result;
        }
    }

}