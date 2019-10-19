@include('admin.layouts.partials.validation-errors')
@include('flash::message')

{!! Field::text('name' , 'اسم التصنيف') !!}
{!! Field::fileWithPreview('photo','صورة الصنف') !!}
@if($model->photo != '')
    <div class="col-md-3">
        <img src="{{asset($model->photo)}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <br>
@endif


