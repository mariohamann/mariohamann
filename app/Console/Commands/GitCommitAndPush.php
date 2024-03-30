<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GitCommitAndPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:commit-push {message=Changes from server [no ci]}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commits changes and pushes them to the remote repository';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting the Git operation...');

        $message = $this->argument('message');

        $processes = [
            ['git', 'add', '.'],
            ['git', 'commit', '-m', $message],
            ['git', 'push'],
        ];

        foreach ($processes as $processCommand) {
            $process = new Process($processCommand);
            $process->setWorkingDirectory(base_path());
            $process->run();

            // Check and handle errors.
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Output the result of the command.
            echo $process->getOutput();
        }

        $this->info('Git operations completed successfully!');
    }
}
