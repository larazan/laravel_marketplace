{!! Form::open(['url'=> Request::path(),'method'=>'GET','class' => 'input-daterange form-inline']) !!}
<header class="card-header">
    <div class="row gx-3">
        <div class="col-lg-2 col-md-2 me-auto">
            <input type="text" class="form-control input-block" name="q" value="{{ !empty(request()->input('q')) ? request()->input('q') : '' }}" placeholder="Type code or name"> 
        </div>
        <div class="col-lg-2 col-md-2 me-auto">
            <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="from">
        </div>
        <div class="col-lg-2 col-md-2 me-auto">
            <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="to">
        </div>
        <div class="col-lg-2 col-6 col-md-3">
            {{ Form::select('status', $statuses, !empty(request()->input('status')) ? request()->input('status') : null, ['placeholder' => 'All Status', 'class' => 'form-control input-block']) }}
        </div>
        <div class="col-lg-2 col-6 col-md-3">
            <button type="submit" class="btn btn-primary btn-default">Show</button>
        </div>
    </div>
</header>
{!! Form::close() !!}