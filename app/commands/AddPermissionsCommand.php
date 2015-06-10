<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddPermissionsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'auth:add-permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add one or more permissions to one or more roles';

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
		$roles 				= $this->strToArray($this->argument('roles'));
		$permissions 		= $this->strToArray($this->argument('permissions'));

		$migration_words 	= $this->getMigrationWords($roles, $permissions);
		$migration_name 	= $this->getDatePrefix() . '_' . implode('_', $migration_words) . '.php';
		$class_name 		= implode('', array_map('ucfirst', $migration_words));

		$up 				= $this->getUp($roles, $permissions);

		$template = file_get_contents(app_path() . '/commands/templates/migration.txt');

		$content = $this->compile($template, compact('up', 'class_name'));

		$file = file_put_contents(app_path().'/database/migrations/'.$migration_name, $content);

		$this->info("Created migration {$migration_name}.");

        $this->call('dump-autoload');

        // if we didn't get a flag to skip migration... then run it
        if(!$this->option('no-migrate')){
        	$this->call('migrate');
        }

	}

	private function getMigrationWords($roles, $permissions)
	{
		$permission_words = [];
		foreach($permissions as $permission){
			$ps = preg_split('/\s+/', $permission);
			$permission_words = array_merge($permission_words, $ps);
		}
		$role_words = [];
		foreach($roles as $role){
			$rs = preg_split('/\s+/', $role);
			$role_words = array_merge($role_words, $rs);
		}

		$p_word = 'permission' . (count($permissions) > 1 ? 's' : '');
		$r_word = 'role' . (count($roles) > 1 ? 's' : '');


		$words = array_merge(['add', $p_word], $permission_words, ['to', $r_word], $role_words);

		return $words;
	}

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    protected function compile($template, $data)
    {
        foreach($data as $key => $value)
        {
            $template = preg_replace("/\\$$key\\$/i", $value, $template);
        }

        return $template;
    }

	private function getUp($roles, $permissions){

		$up_lines = array();
		foreach($roles as $role){
			if($role_line = $this->getAddRoleLine($role)){
				$up_lines[] = "        // Role '{$role}' doesn't exist yet, so create it";
				$up_lines[] = $role_line;
			}
			foreach($permissions as $permission){
				$up_lines[] = $this->getAddPermissionLine($permission, $role);
			}
			$up_lines[] = " ";
		}
		$up = implode("\n", $up_lines);

		return $up;
	}

	private function getAddRoleLine($role_name)
	{
		if(!$role = Role::find($role_name)){
			$rank = $this->ask("What rank should '{$role_name}' have?");
			$line = "        Role::create(array('name'=>'{$role_name}', 'rank'=>'{$rank}'));";
			return $line;
		}
	}

	private function getAddPermissionLine($permission_name, $role_name)
	{
		$line = "        Permission::firstOrCreate(array('role_name'=>'{$role_name}', 'name'=>'{$permission_name}'));";
		return $line;
	}

	private function strToArray($str)
	{
		$trimmed = trim($str, " \"\t\n\r\0\x0B");
		$array_raw = explode(',', $trimmed);
		$array_clean = array_map('trim', $array_raw);

		$response = array_filter($array_clean);

		return $response;
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
	      array('roles', InputArgument::REQUIRED, 'Quoted, comma delimitted list or role names'),
	      array('permissions', InputArgument::REQUIRED, 'Quoted, comma delimitted list or permission names'),
	    );
	}

	protected function getOptions()
	{
		return array(
	      array('no-migrate', 's', InputOption::VALUE_NONE, 'tells the command whether to skip the migration right after creating')
	    );
	}

	

}
