<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        foreach(Role::orderBy('rank', 'ASC')->get() as $i => $role){

            $d = $i+1;

            $data = array();
            $data['role_name'] = $role->name;
            $data['first_name'] = str_replace(' ', '', $role->name);
            $data['last_name'] = 'Test';
            $data['phone'] = "{$d}{$d}{$d}-{$d}{$d}{$d}-{$d}{$d}{$d}{$d}";
            $data['email'] = strtolower(str_replace(' ', '', $role->name)) . '@test.com';
            $data['password'] = 'password';

            if(!User::where('email', '=', $data['email'])->first()){

                $user = User::cliCreate($data);

                $this->command->info("Created {$user->role_name}: {$user->first_name} {$user->last_name} ({$user->email} / ".$data['password'].")");
            }
        }

    }

}