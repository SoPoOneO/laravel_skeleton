<?php

class Role extends Eloquent {

    protected $primaryKey = 'name';

    public $timestamps = false;

    private static $all = null;

    public function permissions()
    {
        return $this->hasMany('Permission', 'role_name', 'permission_name');
    }

    public function users()
    {
        return $this->hasMany('User', 'role_name', 'name');
    }

    public static function exists($role_name)
    {
        // get/set a cached copy of all permissions
        if(is_null(self::$all)){
            self::$all = self::all();
        }

        return self::$all->contains($role_name);
    }


}