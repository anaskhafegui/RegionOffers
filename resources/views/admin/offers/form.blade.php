@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('offer','App\Models\Offer')
@inject('shops','App\Models\Shop')

@php
$shops = [ '' => 'اختر المطعم'] + $shops->pluck('name','id')->toArray();
@endphp

{!! \App\anas\MyClasses\Field::text('title' , 'اسم العرض') !!}
{!! Field::number('price' , 'السعر') !!}
{!! \App\anas\MyClasses\Field::textarea('description','محتوى العرض')!!}
{!! Field::select('shop_id','اختر المطعم',$shops , 'اختر المطعم') !!}
<div class="row">
      <div class="col-md-12"> {!! Field::fileWithPreview('photo','صورة الصنف') !!}
@if($model->photo != '')
    <div class="col-md-3">
        <img src="{{asset($model->photo)}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <br>
@endif </div>
    <div class="col-md-6">
        {!! \App\anas\MyClasses\Field::text('starting_at','بداية العرض') !!}
    </div>
    <div class="col-md-6">
        {!! \App\anas\MyClasses\Field::date('ending_at','نهاية العرض') !!}
    </div>
    
</div>