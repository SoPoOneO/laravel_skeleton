<?php

class Permission extends Eloquent {

    protected $primaryKey = 'name';

    public function roles()
    {
        return $this->belongsToMany('Role', 'permission_role', 'permission_name', 'role_name');
    }


}