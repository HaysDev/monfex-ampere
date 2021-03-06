<?php

namespace Ampere\Commands;

use Ampere\Services\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends \Illuminate\Console\Command
{
    /**
     * Command constructor.
     */
    public function __construct()
    {
        $this->signature .= ' {--space=}';

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!ampere_config()) {
            $spaces = Config::getSpaces();

            if (count($spaces) > 1) {
                if ($targetSpace = $this->option('space', false)) {
                    Config::useSpace($targetSpace);
                } else {
                    $this->info('You have more then one space');
                    $targetSpace = $this->choice('Please select one', array_keys($spaces));

                    Config::useSpace($targetSpace);
                }
            } else {
                Config::useSpace(array_keys($spaces)[0]);
            }
        }

        return parent::execute($input, $output); // TODO: Change the autogenerated stub
    }
}