@extends('layouts.app', ['activePage' => 'dailyIncome', 'titlePage' => __('Daily Income')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">supervisor_account</i>
            </div>
            <h4 class="card-title">{{ __('Daily Income') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Total Income') }}</th>
                    <th>{{ __('Income Date') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Total Income') }}</th>
                    <th>{{ __('Income Date') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($dailyIncomes as $key => $income)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $income->dailyIncome.' BDT' !!}
                    </td>
                    <td>{!! $income->created_at->toFormattedDateString() !!}</td>
                  </tr>
                   @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <!-- end content-->
        </div>
        <!--  end card  -->
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')

@endpush