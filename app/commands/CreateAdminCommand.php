<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateAdminCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'admin:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create an admin user';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$data = array();
		$data['first_name'] = $this->ask('First name?');
        $data['last_name'] = $this->ask('Last name?');
        $data['phone'] = $this->ask('Phone?');
		$data['email'] = $this->ask('Email?');
		$data['password'] = $this->secret('Password? (at least 8 characters)', '');
		$data['password_confirmation'] = $this->secret('Confirm Password?');
        $data['role_name'] = Role::orderBy('rank', 'ASC')->first()->name;

        $validator = User::validator($data);

		if($validator->fails()){
			echo $this->error("User creation failed");
			foreach($validator->errors()->all() as $error){
				$this->error("{$error}");
			}
		}else{
            $user = User::cliCreate($data);
			echo $this->info("User " . $user->getFullName() . " with role \"" . $user->role_name . "\" created successfully");
		}
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
