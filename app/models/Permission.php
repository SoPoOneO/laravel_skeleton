<?php

class Permission extends Eloquent {

    protected $primaryKey = 'name';

    public $timestamps = false;

    protected $guarded = ['id'];

    private static $all = null;

    public static function exists($permission_name)
    {
        // get/set a cached copy of all permissions
        if(is_null(self::$all)){
            self::$all = self::all();
        }

        return self::$all->contains($permission_name);
    }



}