<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    protected $hidden = array('password', 'remember_token', 'confirmation_code');

    protected $fillable = array('first_name', 'last_name', 'email', 'phone');

    private $all_permissions = null;

    private $our_permissions = null;

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

    public static function validator($data, $user_id=null)
    {
        // if we came in with a $user_id, it means we're updating
        $rules = $user_id ?
                 str_replace('$user_id', $user_id, self::$update_rules) :
                 self::$create_rules;

        return Validator::make($data, $rules);
    }

    // ------------------------------------------------------ //

    public function role()
    {
        return $this->belongsTo('Role', 'role_name', 'name');
    }

    public function can($permission)
    {
        // cache the set all of all permissions
        if(is_null($this->all_permissions)){
            $this->all_permissions = Permission::all()->lists('name');
        }

        // cache the set of our permisisons
        if(is_null($this->our_permissions)){
            $this->our_permissions = $this->role->permissions->lists('name');
        }

        // if we're looking for a permission that doesn't even exist...
        if(!in_array($permission, $this->all_permissions)){
            throw new Exception("The permission \"{$permission}\" doesn't exist", 1);
        }

        return in_array($permission, $this->our_permissions);

        return $can;
    }

    public function getFullName()
    {
        $full_name = $this->first_name." ".$this->last_name;
        return $full_name;
    }

}
