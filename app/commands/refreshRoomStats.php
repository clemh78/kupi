<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class refreshRoomStats extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wc:refreshRoomStats';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Permet de recalculer l\'ensemble des stats concernant les salons.';

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
        $rooms = Room::get();

        foreach($rooms as $room) {
            $this->info('MAJ stats du salon  '.$room->name);
            $room->refreshRoomStats();
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
