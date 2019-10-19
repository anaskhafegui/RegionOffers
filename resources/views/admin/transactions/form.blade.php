@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('restaurant','App\Restaurant')

{!! \App\anas\MyClasses\Field::select('restaurant_id','المطعم  ',$restaurant->get()->pluck('restaurant_details','id')->toArray()) !!}
{!! \App\anas\MyClasses\Field::number('amount' , 'المبلغ') !!}
{!! Field::text('note','بيان العملية') !!}
