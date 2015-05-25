<?php

class Permission extends Eloquent {

    protected $primaryKey = 'name';

    private static $all = null;

    public static function exists($permission)
    {
        // get/set a cached copy of all permissions
        if(is_null(self::$all)){
            self::$all = self::all();
        }

        return self::$all->contains($permission);
    }

    public function roles()
    {
        return $this->belongsToMany('Role', 'permission_role', 'permission_name', 'role_name');
    }


}