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

        $checkChanges = new Process(['git', 'status', '--porcelain']);
        $checkChanges->setWorkingDirectory(base_path());
        $checkChanges->run();

        if (empty(trim($checkChanges->getOutput()))) {
            $this->info('No changes detected. Skipping commit and push.');
            return;
        }

        $processes = [
            ['git', 'add', '.'],
            ['git', 'commit', '-m', $message],
            ['git', 'push'],
        ];

        foreach ($processes as $processCommand) {
            $process = new Process($processCommand);
            $process->setWorkingDirectory(base_path());
            $process->run();

            echo $process->getOutput();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }

        $this->info('Git operations completed successfully!');
    }
}
