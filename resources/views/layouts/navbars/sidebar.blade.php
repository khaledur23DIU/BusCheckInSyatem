<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-mini"> {{ __('BM')}} </a>
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      {{ config('app.name', 'BusMama') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    @auth
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#userAccount" aria-expanded="true">
          <i class="material-icons">account_circle</i>
          <p>{{ __('User Account') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ $activePage == 'profile' ? ' show' : '' }}" id="userAccount">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal">{{ __('My Profile') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @can('bus-list')
      <li class="nav-item{{ ($activePage == 'bus' || $activePage == 'editBus') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('bus.index') }}">
          <i class="material-icons">directions_bus</i>
            <p>{{ __('Bus Management') }}</p>
        </a>
      </li>
      @endcan
      @canany(['bus-route-list','bus-stops-list','bus-in-Route-list'])
      <li class="nav-item {{ ($activePage == 'busStop' || $activePage == 'editBusStop' || $activePage == 'busRoute' || $activePage == 'editBusRoute' || $activePage == 'busInRoute' || $activePage == 'editBusInRoute') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#busStands" aria-expanded="true">
          <i class="material-icons">location_on</i>
          <p>{{ __('Bus Stops') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'busStop' || $activePage == 'editBusStop' || $activePage == 'busRoute' || $activePage == 'editBusRoute' || $activePage == 'busInRoute' || $activePage == 'editBusInRoute') ? ' show' : '' }}" id="busStands">
          <ul class="nav">
            @can('bus-route-list')
            <li class="nav-item{{ ($activePage == 'busRoute' || $activePage == 'editBusRoute') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('busRoute.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Bus Routes') }} </span>
              </a>
            </li>
            @endcan
            @can('bus-stops-list')
            <li class="nav-item{{ ($activePage == 'busStop' || $activePage == 'editBusStop') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('busStop.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Bus Stops') }} </span>
              </a>
            </li>
            @endcan
            @can('bus-in-Route-list')
            <li class="nav-item{{ ($activePage == 'busInRoute' || $activePage == 'editBusInRoute') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('busInRoute.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Bus In Route') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcanany
      @canany(['passenger-category-list','ticket-price-list'])
      <li class="nav-item {{ ( $activePage == 'passengerCat' || $activePage == 'editPassengerCat' || $activePage == 'ticketPrice' || $activePage == 'editTicketPrice') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#ticket" aria-expanded="true">
          <i class="material-icons">request_page</i>
          <p>{{ __('Tickets Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ( $activePage == 'passengerCat' || $activePage == 'editPassengerCat' || $activePage == 'ticketPrice' || $activePage == 'editTicketPrice') ? ' show' : '' }}" id="ticket">
          <ul class="nav">
            @can('passenger-category-list')
            <li class="nav-item{{ ($activePage == 'passengerCat' || $activePage == 'editPassengerCat') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('passengerCategory.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Passenger Category') }} </span>
              </a>
            </li>
            @endcan
            @can('ticket-price-list')
            <li class="nav-item{{ ($activePage == 'ticketPrice' || $activePage == 'editTicketPrice') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('ticketPrice.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Pricing') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcanany
      @canany(['checker-list','assign-checker-list'])
      <li class="nav-item {{ ($activePage == 'assignChecker' || $activePage == 'editAssignChecker' || $activePage == 'editCheckers' || $activePage == 'checkers') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#checkers" aria-expanded="true">
          <i class="material-icons">assignment_ind</i>
          <p>{{ __('Checkers') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'assignChecker' || $activePage == 'editAssignChecker' || $activePage == 'editCheckers' || $activePage == 'checkers') ? ' show' : '' }}" id="checkers">
          <ul class="nav">
            @can('checker-list')
            <li class="nav-item{{ $activePage == 'checkers' || $activePage == 'editCheckers' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('checkers.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('All Checkers') }} </span>
              </a>
            </li>
            @endcan
            @can('assign-checker-list')
            <li class="nav-item{{ $activePage == 'assignChecker' || $activePage == 'editAssignChecker' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('assignChecker.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Assign Checker') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcanany
      @can('complains-list')
      <li class="nav-item{{ $activePage == 'complain' || $activePage == 'showComplain' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('allComplains.index') }}">
          <i class="material-icons">report</i>
            <p>{{ __('Complains') }}</p>
        </a>
      </li>
      @endcan
      @can('check-in-list')
      <li class="nav-item{{ $activePage == 'checkIn' || $activePage == 'editCheckIn' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('checkIn.index') }}">
          <i class="material-icons">assignment</i>
            <p>{{ __('My Check In') }}</p>
        </a>
      </li>
      @endcan
      @can('checker-complain-list')
      <li class="nav-item{{ $activePage == 'checkerComplain' || $activePage == 'showCheckerComplain' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('checkerComplain.index') }}">
          <i class="material-icons">report</i>
            <p>{{ __('My Complains') }}</p>
        </a>
      </li>
      @endcan
      @canany(['all-Check-in-list','Income-Report-list'])
      <li class="nav-item {{ ($activePage == 'dailyIncome' || $activePage == 'dailyIncomePerBus' || $activePage == 'monthlyIncome' || $activePage == 'allCheckIn' || $activePage == 'checkerCheckIn') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="true">
          <i class="material-icons">pageview</i>
          <p>{{ __('Reports') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ( $activePage == 'dailyIncome' || $activePage == 'dailyIncomePerBus' || $activePage == 'monthlyIncome' || $activePage == 'allCheckIn' || $activePage == 'checkerCheckIn') ? ' show' : '' }}" id="report">
          <ul class="nav">
            @can('all-Check-in-list')
            <li class="nav-item{{ $activePage == 'allCheckIn' || $activePage == 'checkerCheckIn' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('allCheckIn.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal">{{ __('All Check In') }} </span>
              </a>
            </li>
            @endcan
            @can('Income-Report-list')
            <li class="nav-item{{ $activePage == 'dailyIncomePerBus' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('incomeReport.dailyIncomePerBus') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Daily Income By Bus') }} </span>
              </a>
            </li>
            @endcan
            @can('Income-Report-list')
            <li class="nav-item{{ $activePage == 'dailyIncome' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('incomeReport.totalDailyIncome') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Daily Income') }} </span>
              </a>
            </li>
            @endcan
            @can('Income-Report-list')
            <li class="nav-item{{ $activePage == 'monthlyIncome' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('incomeReport.totalMonthlyIncome') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Monthly Income') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcanany
      @canany(['settings-list','role-list','user-list'])
      <li class="nav-item {{ ($activePage == 'users' || $activePage == 'editUser' || $activePage == 'roles' || $activePage == 'editRoles'|| $activePage == 'siteSetting') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="true">
          <i class="material-icons">settings</i>
          <p>{{ __('Settings') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'users' || $activePage == 'editUser' || $activePage == 'roles' || $activePage == 'editRoles'|| $activePage == 'siteSetting') ? ' show' : '' }}" id="settings">
          <ul class="nav">
            @can('settings-list')
            <li class="nav-item{{ $activePage == 'siteSetting' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('siteSetting.settings') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal">{{ __('General') }} </span>
              </a>
            </li>
            @endcan
            @can('role-list')
            <li class="nav-item{{ ($activePage == 'roles' || $activePage == 'editRoles') ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('Roles Permissions') }} </span>
              </a>
            </li>
            @endcan
            @can('user-list')
            <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('users.index') }}">
                <i class="material-icons">radio_button_unchecked</i>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcanany
    </ul>
    @endauth
  </div>
</div>