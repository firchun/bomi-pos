<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BomiUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bomi:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Bomi POS application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Update is running, please wait...");

        // Simulasi spinner sederhana
        $spinner = ['|', '/', '-', '\\'];
        for ($i = 0; $i < 10; $i++) {
            echo "\r" . $spinner[$i % 4] . " Updating...";
            usleep(200000);
        }

        system('git add .');
        $commitMessage = 'Auto Update: ' . now()->toDateTimeString();
        system("git commit -m \"$commitMessage\"");
        system('git pull origin main');

        echo "\r"; // bersihkan spinner

        $this->info("✅ Success, Bomi is up to date..");
    }
}