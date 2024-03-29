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

namespace app\admin\model;


use app\common\model\BaseModel;

/**
 * 菜单模型
 * @author 牧羊人
 * @since: 2020/6/30
 * Class Menu
 * @package app\admin\model
 */
class Menu extends BaseModel
{
    // 设置数据表
    protected $name = "menu";

    /**
     * 获取缓存信息
     * @param int $id 记录ID
     * @return \app\common\model\数据信息|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 牧羊人
     * @since: 2020/6/30
     */
    public function getInfo($id)
    {
        $info = parent::getInfo($id); // TODO: Change the autogenerated stub
        if ($info) {
            // 菜单类型
            if ($info['type']) {
                $info['type_name'] = config('admin.menu_type')[$info['type']];
            }
            // 获取权限节点
            $funcList = $this->getList([
                ['pid', '=', $info['id']],
                ['type', '=', 4]
            ], "sort asc");
            if (!empty($funcList)) {
                $info['funcList'] = array_key_value($funcList, "sort");
            }
        }
        return $info;
    }

    /**
     * 获取子级菜单
     * @param int $pid 上级ID
     * @param bool $isMenu 是否获取菜单
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 牧羊人
     * @since: 2020/6/30
     */
    public function getChilds($pid = 0)
    {
        $map = [
            'pid' => $pid,
            'mark' => 1,
        ];
        $result = $this->where($map)->order("sort asc")->select();
        $list = [];
        if ($result) {
            foreach ($result as $val) {
                $id = (int)$val['id'];
                $info = $this->getInfo($id);
                if (!$info) {
                    continue;
                }
                $itemList = $this->getChilds($id);
                if (!empty($itemList)) {
                    $info['children'] = $itemList;
                } else {
                    $info['children'] = [];
                }
                $list[] = $info;
            }
        }
        return $list;
    }

}