<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $hidden = array('password', 'remember_token', 'confirmation_code');

    public static $create_rules = array(
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'role_name' => 'required|exists:roles,name'
    );

    public static $update_rules = array(
        'email' => 'email',
        'password' => 'min:8|confirmed',
        'role_name' => 'exists:roles,name'
    );

    public function role()
    {
        return $this->belongsTo('Role');
    }

    public static function validator($fields, $rules = null)
    {
        $rules = $rules ? $rules : self::$create_rules;

        $validator = Validator::make($fields, $rules);

        return Validator::make($fields, $rules);
    }


    public static function create(array $data = array())
    {
        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);
        $user = new User();
        foreach($data as $key => $val){
            $user->{$key} = $val;
        }
        $user->confirmation_code = md5( uniqid(mt_rand(), true) );
        $user->save();
        return $user;
    }

    public function getFullName()
    {
        $full_name = $this->first_name." ".$this->last_name;
        return $full_name;
    }

}
