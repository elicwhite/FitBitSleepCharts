<?php
namespace Application\Entities;

class Users extends \Spot\Entity
{
	protected static $_datasource = 'users';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'username' => array('type' => 'string'),
            'password' => array('type' => 'string'),
        );
    }
    
    public static function relations()
    {
        return array(
        );
    }
}
