<?php

namespace App\Http\Controllers\Admin;

use App\DailyIncome;
use App\DailyIncomeEntry;
use App\Http\Controllers\Controller;
use App\MonthlyIncome;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:Income-Report-list|Income-Report-create|Income-Report-edit|Income-Report-delete', ['only' => ['index','store']]);
         $this->middleware('permission:Income-Report-create', ['only' => ['create','store']]);
         $this->middleware('permission:Income-Report-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Income-Report-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function dailyIncomePerBus()
    {
        $dailyIncomePerBuses = DailyIncomeEntry::orderBy('id','DESC')->get()->load('bus');
        return view('admin.income-report.dailyIncomePerBus', compact('dailyIncomePerBuses'));
    }

    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function totalDailyIncome()
    {
        $dailyIncomes = DailyIncome::orderBy('id','DESC')->cursor();
        return view('admin.income-report.dailyIncome', compact('dailyIncomes'));
    }

    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function totalMonthlyIncome()
    {
        $monthlyIncomes = MonthlyIncome::orderBy('id','DESC')->cursor();
        return view('admin.income-report.monthlyIncome', compact('monthlyIncomes'));
    }
}
