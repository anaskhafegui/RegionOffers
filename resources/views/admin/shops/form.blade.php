@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('city','App\Models\City')
@inject('user','App\User')
@inject('category','App\Models\Category')

 @php  /*
$restaurant_admins = [ 0 => 'بدون مدير' ]+$user->whereHas('roles',function($q){
$q->where('name','restaurant_admin');
})->pluck('name','id')->toArray();
$restaurant_contractors = [ 0 => 'بدون مندوب' ]+$user->whereHas('roles',function($q){
$q->where('name','restaurant_contractor');
})->pluck('name','id')->toArray();
$cities = [0 => 'اختر المدينة'] + $city->pluck('name','id')->toArray();
$regions = [0 => 'اختر المنطقة'];
$selected = null;
$selectedRegion = null;
if($model->region_id > 0)
{
$selected =  $model->region->city->id;
$selectedRegion = $model->region->id;
$regions = $regions+$city->find($selected)->regions()->pluck('name','id')->toArray();
}
$plugin = 'select2';
$placeholder = 'اختر المدينة';

$days = [
0 => 'الأحد',
1 => 'الأثنين',
2 => 'الثلاثاء',
3 => 'الأربعاء',
4 => 'الخميس',
5 => 'الجمعة',
6 => 'السبت'
];

$option=' <option value="0">إختر المنطقة</option>'; */

$cities = [0 => 'اختر المدينة'] + $city->pluck('name','id')->toArray();
$regions = [0 => 'اختر المنطقة'];
$selected = null;
$selectedRegion = null;
if($model->region_id > 0)
{
$selected =  $model->region->city->id;
$selectedRegion = $model->region->id;
$regions = $regions+$city->find($selected)->regions()->pluck('name','id')->toArray();
}
$plugin = 'select2';
$placeholder = 'اختر المدينة';
$option=' <option value="0">إختر المنطقة</option>';
@endphp

<div class="row">
    <div class="col-md-12 ">
        {!! Field::text('name' , 'اسم المحل') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('email' , 'البريد الالكتروني للمحل') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('phone' , 'رقم الهاتف للمحل') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!! Field::text('contact','للتواصل') !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('delivery','خدمة توصيل الطلبات',[1  => 'نعم', 0 => 'لا']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('takeaway','خدمة التقاط الطلبات',[1 => 'نعم', 0 => 'لا']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('category_id','تصنيف المحل',$category->pluck('name','id')->toArray()) !!}
    </div>
    <div class="col-md-6">
        {!! Field::number('minimum_charger','الحد الأدني لسعر الطلبات') !!}
    </div>
    <div class="col-md-6">
        {!! Field::number('delivery_cost','سعر توصيل الطلبات') !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('availability','حالة المحل',['open' => 'مفتوح', 'soon' => 'قريبا', 'closed' => 'مغلق']) !!}
    </div>
    <div class="col-md-6">
    {!! Field::text('address' , 'العنوان') !!}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="city_id">إختر المدينة</label>
            <div class="">
                {!! Form::select('city_id',$cities,$selected,[
                "class" => "form-control ".$plugin,
                "id" => 'city_id',
                "data-placeholder"=> $placeholder,
                'data-url' => url('api/v1/regions_ajax?city_id')
                ])  !!}
            </div>
        </div>
    </div>

      <div class="col-md-12">
        <div  class="form-group">
            <label for="region_id" class="control-label">اختر المنطقة</label>

                {!! Field::multiSelect('region_id' , '', $regions,'',$selectedRegion,[
                "class" => "form-control ".$plugin,
                "id" => 'region_id',
                "data-placeholder"=> $placeholder
                ])



                !!}

        </div>
    </div>

    <div class="col-md-6">
        {!! Field::textarea('about','عن المحل') !!}
    </div>







   {{-- <div class="col-md-6">
        {!! Field::number('minimum_takeaway','الحد الأدني للطلبات') !!}
    </div>

    <div class="col-md-6">
        {!! Field::select('availability','حالة المطعم',['open' => 'مفتوح', 'soon' => 'قريبا', 'closed' => 'مغلق']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('user_id','مدير المطعم',$restaurant_admins) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('contractor_id','مندوب المطعم',$restaurant_contractors) !!}
    </div>--}}
</div>

<div class="clearfix"></div>

{{--{!! Field::multiSelect('regions_list' , 'اختر مناطق التوصيل',$delivery_regions) !!}--}}

<hr>

{!! Field::fileWithPreview('photo','صورة الصنف') !!}
@if($model->photo != '')
    <div class="col-md-3">
        <img src="{{asset($model->photo)}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <br>
@endif

<hr>
