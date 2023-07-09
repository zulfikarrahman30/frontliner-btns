<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notif;
class senReminderEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder event';

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
     * @return int
     */
    public function handle()
    {
        $data = new Notif();
        $exceute = $data->getReminderSent();
        $this->info($exceute);
    }
}
