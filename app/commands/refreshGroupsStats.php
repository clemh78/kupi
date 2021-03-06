<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class refreshGroupsStats extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
    protected $name = 'wc:refreshGroupsStats';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Permet de recalculer l\'ensemble des stats concernant les équipes.';

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
        $teams = Team::get();

        foreach($teams as $team){
            $this->info('MAJ stats de l\'équipe '.$team->name);
            $team->refreshTeamStats();
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
		return array();
	}

}
