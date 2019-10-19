@include('admin.layouts.partials.validation-errors')
@include('flash::message')

<h3>اعدادات التطبيق</h3>

<h4>بيانات التواصل الاجتماعي</h4>
{!! \App\anas\MyClasses\Field::text('facebook' , 'فيس بوك') !!}
{!! \App\anas\MyClasses\Field::text('twitter','تويتر') !!}
{!! \App\anas\MyClasses\Field::text('instagram' , 'انستقرام') !!}
<hr>
{!! \App\anas\MyClasses\Field::number('commission','عمولة التطبيق') !!}
{!! \App\anas\MyClasses\Field::editor('about_app','عن التطبيق') !!}
{!! \App\anas\MyClasses\Field::editor('terms','الشروط والأحكام') !!}
<hr>
<h4>بيانات صفحة العمولة</h4>
{!! \App\anas\MyClasses\Field::textarea('commissions_text' , 'نص العمولة') !!}
{!! \App\anas\MyClasses\Field::editor('bank_accounts' , 'الحسابات بنكية') !!}
<hr>



