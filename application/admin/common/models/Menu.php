<?php

declare(strict_types=1);

namespace admin\common\models;

class Menu extends Model
{
    public function getMenu()
    {
        $menus = [];
        $top   = $this->db->query()->where('parent_name', '==', '')->results();
        foreach ($top as $menu) {
            $item = [
                'id'         => $menu['name'],
                'title'      => $menu['title'],
                'icon'       => $menu['icon'],
                'module'     => $menu['module'],
                'controller' => $menu['controller'],
                'action'     => $menu['action'],
                'sub'        => [],
            ];
            $sub  = $this->db->query()->where('parent_name', '==', $menu['name'])->results();
            if ($sub) {
                foreach ($sub as $s) {
                    array_push($item['sub'], [
                        'id'         => $s['name'],
                        'title'      => $s['title'],
                        'icon'       => $s['icon'],
                        'module'     => $s['module'],
                        'controller' => $s['controller'],
                        'action'     => $s['action'],
                    ]);
                }
            }
            array_push($menus, $item);
        }

        return $menus;
    }

    public function init()
    {
        $this->db->flush(true);
        $this->add('home', [
            'parent_name' => '',
            'title'       => '后台主页',
            'icon'        => 'home',
            'module'      => 'index',
            'controller'  => 'index',
            'action'      => 'main',
        ]);
        $this->add('system', [
            'parent_name' => '',
            'title'       => '系统设置',
            'icon'        => 'cogs',
            'module'      => 'system',
            'controller'  => 'index',
            'action'      => 'index',
        ]);
        $this->add('system_menu', [
            'parent_name' => 'system',
            'title'       => '菜单管理',
            'icon'        => 'list',
            'module'      => 'system',
            'controller'  => 'menu',
            'action'      => 'index',
        ]);

        return $this->findAll();
    }
}
