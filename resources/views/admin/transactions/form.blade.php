@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('shop','App\Models\Shop')

{!! \App\anas\MyClasses\Field::select('shop_id','المطعم  ',$shop->get()->pluck('shop_details','id')->toArray()) !!}
{!! \App\anas\MyClasses\Field::number('amount' , 'المبلغ') !!}
{!! Field::text('note','بيان العملية') !!}
