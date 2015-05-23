<?php

class Role extends Eloquent {

    protected $primaryKey = 'name';

    public function permissions()
    {
        return $this->belongsToMany('Permission', 'permission_role', 'role_name', 'permission_name');
    }

    public function users()
    {
        return $this->hasMany('User', 'role_name', 'name');
    }


}