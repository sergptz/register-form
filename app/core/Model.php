<?php
namespace Application\Core;

abstract class Model
{
    protected $db;
    const HOST = 'mysql:dbname=test;host=localhost';
    const USERNAME = 'test';
    const PASSWORD = '12345678';

    public function __construct()
    {
        $this->db = new DB(self::HOST, self::USERNAME, self::PASSWORD);
    }

    abstract public function get();

    abstract public function save();

    abstract  public function update();
}
