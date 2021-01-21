<?php

namespace App\Http\Controllers;

use App\Bus;
use App\BusRoute;
use App\Charts\DailyIncomeChart;
use App\Charts\MonthlyIncomeChart;
use App\CheckIn;
use App\CheckInIncome;
use App\Complain;
use App\DailyIncome;
use App\DailyIncomeEntry;
use App\MonthlyIncome;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->roles[0]->id != 2) {
          
        $runningBus = DailyIncomeEntry::orderBy('created_at','DESC')->whereDate('created_at',Carbon::today()->toDateString())->limit(5)->get()->load('bus');

        $dailyIncomes = DailyIncome::orderBy('updated_at','DESC')->limit(7)->get();       
        
        $dailyIncomesValueSet = array();
        $dailyIncomesKeySet = array();
        foreach ($dailyIncomes as $incomes) {
            $dailyIncomesValueSet[] = $incomes->dailyIncome;
            $dailyIncomesKeySet[] = $incomes->created_at->format('d M');
        }
        $dailyIncomeChart = new DailyIncomeChart;
        $dailyIncomeChart->labels($dailyIncomesKeySet);
        $dailyIncomeChart->dataset('last 7 Days Income', 'bar', $dailyIncomesValueSet)
            ->color("rgb(191, 165, 255)")
            ->backgroundcolor("rgb(191, 165, 255)");


        $monthlyIncomes = MonthlyIncome::orderBy('updated_at','DESC')->limit(12)->get();       
        
        $monthlyIncomesValueSet = array();
        $monthlyIncomesKeySet = array();
        foreach ($monthlyIncomes as $incomes) {
            $monthlyIncomesValueSet[] = $incomes->monthlyIncome;
            $monthlyIncomesKeySet[] = $incomes->created_at->format('M y');
        }
        $monthlyIncomeChart = new MonthlyIncomeChart;
        $monthlyIncomeChart->labels($monthlyIncomesKeySet);
        $monthlyIncomeChart->dataset('Monthly Income', 'bar', $monthlyIncomesValueSet)
            ->color("rgb(106, 90, 205)")
            ->backgroundcolor("rgb(106, 90, 205)");


        $lastFiveCheckInByCheckers = CheckIn::orderBy('created_at','DESC')->whereDate('created_at',Carbon::toDay()->toDateString())->limit(5)->get()->load(['checker','bus','busStop']);
        
        $complains = Complain::orderBy('id','DESC')->where('is_seen',0)->limit(5)->get()->load('checker');

        $todaysRunningBusCount = DailyIncomeEntry::whereDate('created_at',Carbon::toDay()->toDateString())->count();
        $totalRunningBusCount = Bus::where('is_running',1)->count();
        $todaysIncome = DailyIncome::whereDate('created_at',Carbon::toDay()->toDateString())->first();
        $totalCheckersCount = (Role::where('id',2)->first())->users()->count();
        $totalUnseenComplainsCount = Complain::orderBy('id','DESC')->where('is_seen',0)->count();

        return view('dashboard', [ 'dailyIncomeChart' => $dailyIncomeChart, 
                                    'monthlyIncomeChart' => $monthlyIncomeChart,
                                    'runningBus' => $runningBus, 
                                    'lastFiveCheckInByCheckers' => $lastFiveCheckInByCheckers, 
                                    'complains' => $complains, 
                                    'todaysRunningBusCount' => $todaysRunningBusCount, 
                                    'totalRunningBusCount' => $totalRunningBusCount, 
                                    'todaysIncome' => $todaysIncome, 
                                    'totalCheckersCount' => $totalCheckersCount, 
                                    'totalUnseenComplainsCount' => $totalUnseenComplainsCount, 
                                ] );

        }
        else{
            $todaysTotalCheckIn = CheckIn::whereDate('created_at',Carbon::toDay()->toDateString())->count();
            $checkerBusStop = Auth::user()->checkIn->checkingPlace;
            $checkerBusRoute = Auth::user()->checkIn->checkingPlace->busRoute;
            $checkIns = CheckIn::orderBy('id','DESC')->where('checker_id',Auth::user()->id)->where('bus_stop_id',Auth::user()->checkIn->checkingPlace->id)->get()->load('checkInPassenger');
            return view('checker-dashboard',compact('checkIns','todaysTotalCheckIn','checkerBusStop','checkerBusRoute') );
        }
        
    }
}
