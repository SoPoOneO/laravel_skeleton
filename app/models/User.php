<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $hidden = array('password', 'remember_token', 'confirmation_code');

    protected $fillable = array('first_name', 'last_name', 'email', 'phone');

    public static $create_rules = array(
        'first_name'    => 'required',
        'last_name'     => 'required',
        'role_name'     => 'required|exists:roles,name',
        'phone'         => 'required',
        'email'         => 'required|email|unique:users',
        'password'      => 'sometimes|required|min:8|confirmed',
    );

    public static $update_rules = array(
        'email'         => 'sometimes|required|email|unique:users,email,$user_id',
        'password'      => 'sometimes|required|min:8|confirmed',
        'role_name'     => 'sometimes|required|exists:roles,name'
    );

    public function role()
    {
        return $this->belongsTo('Role', 'role_name', 'name');
    }

    public static function validator($data, $user_id=null)
    {
        // if we came in with a $user_id, it means we're updating
        $rules = $user_id ?
                 str_replace('$user_id', $user_id, self::$update_rules) :
                 self::$create_rules;

        return Validator::make($data, $rules);
    }

    public function getFullName()
    {
        $full_name = $this->first_name." ".$this->last_name;
        return $full_name;
    }

}
