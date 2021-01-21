@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_bus</i>
              </div>
              <p class="card-category">{{__('Todays Running Bus')}}</p>
              <h3 class="card-title">{{$todaysRunningBusCount}}/{{$totalRunningBusCount}}
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> {{__('Just Updated')}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">account_balance</i>
              </div>
              <p class="card-category">Today's Income </p>
              <h3 class="card-title">{{ !empty($todaysIncome) ? $todaysIncome->dailyIncome.' BDT': '0 BDT' }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">directions_run</i>
              </div>
              <p class="card-category">{{__('Checkers')}}</p>
              <h3 class="card-title">{{$totalCheckersCount}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Intotal
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">report</i>
              </div>
              <p class="card-category">{{__('Unseen Complains')}}</p>
              <h3 class="card-title">+{{$totalUnseenComplainsCount}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart">
                {!! $dailyIncomeChart->container() !!}
              </div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Income</h4>
              <p class="card-category">
                <span class="text-success"><i class="fa fa-long-arrow-up"></i></span> Update in last 7 days.</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> Updated 1 minutes ago
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <div class="ct-chart">
                {!! $monthlyIncomeChart->container() !!}
              </div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Monthly Income</h4>
              <p class="card-category">Month Performance</p>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> Updated starting of current month
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">{{__('5 Latest History:')}}</span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#complain" data-toggle="tab">
                        <i class="material-icons">bug_report</i> {{__('Complains')}}
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#running_bus" data-toggle="tab">
                        <i class="material-icons">directions_bus</i> {{__('Running Bus')}}
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#personCheckers" data-toggle="tab">
                        <i class="material-icons">directions_run</i> {{__('Checkers')}}
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="complain">
                  <table class="table">
                    <tbody>
                      @if (!$complains->isEmpty())
                      @foreach ($complains as $key => $complain)
                      <tr>
                        <td>
                          {{ $key+1 }}
                        </td>
                        <td>{{Str::words($complain->title,7, '...').' By '.$complain->checker->name}}</td>
                        <td class="td-actions text-right">
                          <a href="{{ route('allComplains.complainSeen',$complain->id) }}" rel="tooltip" title="Read" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">remove_red_eye</i>
                          </a>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td> {{__('No Data Found')}} </td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="running_bus">
                  <table class="table">
                    <tbody>
                      @if (!$runningBus->isEmpty())
                      @foreach ($runningBus as $bus)
                      @php
                        {{$runningPlace = App\CheckIn::where('id',$bus->check_in_ids[(count($bus->check_in_ids)-1)])->first();}}
                      @endphp
                      <tr>
                        <td>Bus NO: {{ $bus->bus->bus_no }} - Already left - {{($runningPlace->busStop->bus_stop)}}</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Details" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">remove_red_eye</i>
                          </button>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td> {{__('No Data Found')}} </td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="personCheckers">
                  <table class="table">
                    <tbody>
                      @if (!$lastFiveCheckInByCheckers->isEmpty())
                      @foreach ($lastFiveCheckInByCheckers as $checkers)
                      <tr>
                        <td>{{$checkers->checker->name.' In '.$checkers->busStop->bus_stop.' Check In Bus No '.$checkers->bus->bus_no.' At '.$checkers->created_at->toFormattedDateString() }}</td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="See Details" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">remove_red_eye</i>
                          </button>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr>
                        <td> {{__('No Data Found')}} </td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
  @if($dailyIncomeChart)
    {!! $dailyIncomeChart->script() !!}
  @endif

  @if($monthlyIncomeChart)
    {!! $monthlyIncomeChart->script() !!}
  @endif
@endpush