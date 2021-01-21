<?php

namespace App\Console\Commands;

use App\DailyIncome;
use App\DailyIncomeEntry;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailyIncomeMinuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyIncome:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $dailyIncomesEntry = DailyIncomeEntry::whereDate('created_at',Carbon::today()->toDateString())->get();
        if (!empty($dailyIncomesEntry)) {
            $countIncome = 0;
            foreach ($dailyIncomesEntry as $dataSet) {
                $countIncome = $countIncome + $dataSet->income;
            }

            $isAvailableInDailyIncome = DailyIncome::whereDate('created_at',Carbon::today()->toDateString())->first();
            if (empty($isAvailableInDailyIncome)) {
                   $todaysIncomeEntry = DailyIncome::create([
                        'dailyIncome' => $countIncome
                   ]);              
            }
            else{
                $isAvailableInDailyIncome->update([
                        'dailyIncome' => $countIncome
                ]);
            }
            return true;
        }
        else{
            return false;
        } 
        
    }
}
