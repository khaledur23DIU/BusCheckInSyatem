@extends('layouts.app', ['activePage' => 'passengerCat', 'titlePage' => __('Passenger Category Management')])

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
            <h4 class="card-title">{{ __('Passengers Categories') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Passenger Category') }}</th>
                    <th>{{ __('Cost In Percentage') }}</th>
                    <th>{{ __('Updated At') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('SL') }}</th>
                    <th>{{ __('Passenger Category') }}</th>
                    <th>{{ __('Cost In Percentage') }}</th>
                    <th>{{ __('Updated At') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($passCategories as $key => $category)
                  <tr>
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! $category->passenger_category !!}
                    </td>
                    <td>
                        {!! $category->cost_in_percentage.' %' !!}
                    </td>
                    <td>{!! $category->updated_at->toFormattedDateString() !!}</td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('passengerCategory.edit',$category->id) }}">
                        <i class="material-icons">edit</i>
                      </a>
                    </td>
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
  <script>
    $(document).ready(function() {
        setFormValidation('#passengerValidation');
      });
  </script>

@endpush