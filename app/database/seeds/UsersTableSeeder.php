<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $user = new User;
        $user->email = 'superadmin@test.com';
        $user->password = 'password';
        $user->password_confirmation = 'password';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;

        if(! $user->save()) {
            Log::info('Unable to create user '.$user->email, (array)$user->errors());
        } else {
            Log::info('Created user '.$user->email);
        }
    }
}