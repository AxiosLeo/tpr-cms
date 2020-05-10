<?php

declare(strict_types=1);

namespace admin\index\controller;

use admin\common\controller\AdminLogin;
use function cms\createUrl;
use function cms\getDayBeginEndTime;
use tpr\Path;

class Index extends AdminLogin
{
    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
        if ($this->request->isPost()) {
            $disk_size = floor(disk_free_space(Path::root()) / (1024 * 1024));
            $disk_size = $disk_size < 100 ? '磁盘空间已小于100M' : $disk_size . 'M';
            $data      = [
                'domain'       => $this->request->host(),
                'os'           => PHP_OS,
                'server_ip'    => $this->request->server('SERVER_ADDR'),
                'server_env'   => PHP_VERSION,
                'disk'         => $disk_size,
                'username'     => 'AxiosCros',
                'upload_limit' => ini_get('upload_max_filesize'),
            ];
            $req       = [
                'env'                => $data,
                'users_number'       => rand(10000, 99999),
                'users_number_today' => rand(0, 100),
            ];
            $this->response($req);
        }
        $this->assign('user_number', rand(10000, 99999));
        $this->assign('register_today', rand(0, 100));

        return $this->fetch();
    }

    public function user()
    {
        $dayArr   = $this->getLastSevenDay();
        $day_list = [];
        $data     = [];
        foreach ($dayArr as $d) {
            $day_list[] = $d['day'];
            $data[]     = rand(0, 100);
        }
        $this->success([
            'day'  => $day_list,
            'data' => $data,
        ]);
    }

    public function logout()
    {
        $this->user->clearInfo();
        $this->redirect(createUrl('user', 'index', 'login'));
    }

    private function getLastSevenDay()
    {
        $time   = time();
        $dayArr = [];
        $n      = 0;
        $total  = 7;
        for ($i = 0; $i < $total; ++$i) {
            $timestamp           = $time - ($total - $n) * 3600 * 24;
            $dayArr[$n]['day']   = date('Y-m-d', $timestamp);
            $temp                = getDayBeginEndTime($dayArr[$n]['day']);
            $dayArr[$n]['begin'] = $temp['begin'];
            $dayArr[$n]['end']   = $temp['end'];
            ++$n;
        }

        return $dayArr;
    }
}
