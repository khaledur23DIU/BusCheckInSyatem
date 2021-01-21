@extends('layouts.app', ['activePage' => 'complain', 'titlePage' => __('My Complains')])

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
            <h4 class="card-title">{{ __('Complains') }}</h4>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th>{{ __('Title') }}</th>
                    <th class="disabled text-right">{{ __('Is Active?') }}</th>
                    <th class="disabled-sorting text-right">{{ __('Actions') }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>{{ __('Title') }}</th>
                    <th class="text-right">{{ __('Is Active?') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($complains as $complain)
                  <tr>
                    <td>
                        {!! ucFirst($complain->title) !!}
                    </td>
                    <td class="text-right">
                      @if ($complain->is_seen == 0)
                      <span class="badge badge-pill badge-info">{{__("Active")}}</span>
                      @else
                      <span class="badge badge-pill badge-success">{{__("Seen")}}</span>
                      @endif
                    </td>
                    <td class="td-actions text-right">
                      <a class="btn btn-primary btn-link btn-sm" href="{{ route('allComplains.complainSeen',$complain->id) }}">
                        <i class="material-icons">remove_red_eye</i>
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
        setFormValidation('#checkInValidation');

      });
  </script>

@endpush