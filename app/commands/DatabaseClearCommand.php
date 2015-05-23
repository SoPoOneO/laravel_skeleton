<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseClearCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete all tables in the database.';

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

		$database = Config::get('database.connections.mysql.database');
		$field = "Tables_in_{$database}";
		while($tables = $this->getTables()){
			foreach($tables as $table){
				$table_name = $table->{$field};
				try{
					DB::select(DB::raw("drop table `{$table_name}`"));
				}catch(Illuminate\Database\QueryException $e) {
				    // Ignoring integrety constraint errors
				}
			}
		}

		$this->info('Database cleared.');
	}


	private function getTables(){

		$tables = DB::select(DB::raw("show tables;"));

		return $tables;
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
		return array();
	}

}
