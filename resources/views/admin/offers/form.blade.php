@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('offer','App\Models\Offer')
@inject('shops','App\Models\Shop')

@php
$shops = [ '' => 'اختر المطعم'] + $shops->pluck('name','id')->toArray();
@endphp

{!! \App\anas\MyClasses\Field::text('title' , 'اسم العرض') !!}
{!! \App\anas\MyClasses\Field::text('title_ar' , 'بالعربي اسم العرض') !!}
{!! Field::number('price' , 'السعر') !!}
{!! \App\anas\MyClasses\Field::textarea('description','محتوى العرض')!!}
{!! \App\anas\MyClasses\Field::textarea('description_ar','محتوى العرض بالعربي')!!}
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
      <time class="entry-date updated" datetime="2019-05-19 00:55:00" placeholder="2019-05-19 00:55:00">
        {!! \App\anas\MyClasses\Field::text('starting_at','بداية العرض') !!}
      </time>
    </div>
    <div class="col-md-6">
      <time class="entry-date updated" datetime="2019-05-19 00:55:00" placeholder="2019-05-19 00:55:00">
        {!! \App\anas\MyClasses\Field::date('ending_at','نهاية العرض') !!}
      </time>
    </div>


</div>
