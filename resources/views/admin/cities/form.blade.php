@include('admin.layouts.partials.validation-errors')
@include('flash::message')

{!! Field::text('name' , 'اسم المدينة') !!}
{!! Field::text('name_ar' , 'اسم المدينة') !!}