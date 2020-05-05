<?php

declare(strict_types = 1);

namespace admin\common\models;

use Filebase\Database;
use library\FileDb;

abstract class Model
{
    /**
     * @var Database
     */
    protected $db;

    public function __construct()
    {
        $this->db = FileDb::client(md5(get_called_class()));
    }

    protected function item($name)
    {
        return $this->db->get($name);
    }
}
