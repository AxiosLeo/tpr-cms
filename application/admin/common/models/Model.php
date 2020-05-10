<?php

declare(strict_types=1);

namespace admin\common\models;

use Filebase\Database;
use library\Service;

abstract class Model
{
    /**
     * @var Database
     */
    protected $db;

    public function __construct()
    {
        $this->db = Service::filedb(md5(\get_called_class()));
    }

    public function add($name, $data)
    {
        $item           = $this->item($name);
        $item->{'name'} = $name;
        foreach ($data as $key => $val) {
            $item->{$key} = $val;
        }
        $item->save();
    }

    public function findAll()
    {
        $items = $this->db->findAll();
        $data  = [];
        foreach ($items as $item) {
            array_push($data, $item->getData());
        }

        return $data;
    }

    protected function item($name)
    {
        return $this->db->get($name);
    }
}
