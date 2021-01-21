@extends('layouts.app', ['activePage' => 'showComplain', 'titlePage' => __('Complain')])

@section('content')
  <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('allComplains.index') }}" class="btn btn-primary"><i class="material-icons">keyboard_arrow_left</i>{{('Back')}}</a>
            <h4 class="card-title">{{__('Complain By ').$complain->checker->name}}</h4>
          </div>
          <div class="card-body">
            <div id="accordion" role="tablist">
              <div class="card-collapse">
                <div class="card-header" role="tab" id="headingOne">
                  <h5 class="mb-0">
                    {{__('Complained At ').$complain->created_at->toFormattedDateString().'. And'}}&nbsp {{$complain->is_seen == 1 ? __('Seen Already.'):__('Not Seen Yet!') }}
                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
                      {!! $complain->title.' #' !!}
                      <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                  <div class="card-body">
                    {!! $complain->complain !!}
                  </div>
                </div>
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
        setFormValidation('#checkInValidation');

      });
  </script>


@endpush