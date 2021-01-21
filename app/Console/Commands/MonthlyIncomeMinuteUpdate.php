<?php

namespace App\Console\Commands;

use App\DailyIncome;
use App\DailyIncomeEntry;
use App\MonthlyIncome;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MonthlyIncomeMinuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlyIncome:update';

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
        $dailyIncomesEntry = DailyIncome::whereMonth('created_at',Carbon::today()->format('m'))->get();
        if (!empty($dailyIncomesEntry)) {
            $countIncome = 0;
            foreach ($dailyIncomesEntry as $dataSet) {
                $countIncome = $countIncome + $dataSet->dailyIncome;
            }

            $isAvailableInMonthlyIncome = MonthlyIncome::whereMonth('created_at',Carbon::today()->format('m'))->first();
            if (empty($isAvailableInMonthlyIncome)) {
                   $todaysIncomeEntry = MonthlyIncome::create([
                        'monthlyIncome' => $countIncome
                   ]);              
            }
            else{
                $isAvailableInMonthlyIncome->update([
                        'monthlyIncome' => $countIncome
                ]);
            }
            return true;
        }
        else{
            return false;
        }
    }
}
