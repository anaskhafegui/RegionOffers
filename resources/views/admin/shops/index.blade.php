@inject('regions','App\Models\Region')
@inject('user','App\User')

<style>
    span.select2-container {
        z-index: 10050;
        width: 100% !important;
        padding: 0;
    }

    .select2-container .select2-search--inline {
        float: left;
        width: 100%;
    }

    .restaurant-filter span.select2-container {
        z-index: 999;
        width: 100% !important;
        padding: 0;
    }

    /*.modal-open .modal {*/
        /*overflow-x: hidden;*/
        /*overflow-y: auto;*/
        /*z-index: 99999;*/
    /*}*/
</style>
@extends('admin.layouts.main',[
								'page_header'		=> 'المطاعم',
								'page_description'	=> 'عرض المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
               
                
                <br>
                <div class="restaurant-filter">
                    {!! Form::open([
                    'method' => 'get'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المطعم',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('region_id',$regions->get()->pluck('name','id')->toArray() ,request()->input('region_id'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'المدينة'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- 'soon' => 'قريبا', --}}
                            <div class="form-group">
                                {!! Form::select('availability',['open' => 'مفتوح', 'closed' => 'مغلق'],request()->input('availability'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'حالة المطعم'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(count($shops) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>المدينة</th>
                         <th>المناطق</th>
                        <th class="text-center">العمولات المستحقة</th>
                        <th class="text-center">حالة المطعم</th>
                        <th class="text-center">تفعيل / إيقاف</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($shops as $shop)
                            <tr id="removable{{$shop->id}}">
                                <td>{{$count}}</td>
                                <td><a style="cursor: pointer" data-toggle="modal" data-target="#myModal{{$shop->id}}">{{$shop->name['en']}}</a></td>
                                <td>
                                    @if(count($shop->regions))
                                        {{$shop->regions[0]->city->name}} </td>
                                      @endif    
                                        <td>
                                        @if(count($shop->regions))
                                          @foreach ($shop->regions as $region)
                                            
                                       
                                        {{$region->name}} 

                                          @endforeach
                                      </td>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $shop->total_commissions - $shop->total_payments }}
                                </td>
                                <td class="text-center">
                                    @if($shop->availability == 'open')
                                        <i class="fa fa-circle-o text-green"></i> مفتوح
                                    @else
                                        <i class="fa fa-circle-o text-red"></i> مغلق
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if($shop->activated)
                                        <a href="shop/{{$shop->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="shop/{{$shop->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>
                                <td class="text-center"><a href="shop/{{$shop->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a></td>
            

                                <td class="text-center">
                                    <button id="{{$shop->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('shop.destroy',$shop->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$shop->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">{{$shop->name['en']}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <ul>
                                                        <li> العنوان :  {{$shop->address}}</li>
                                                        <li> المدينة :
                                                            @if(count($shop->regions))
                                                                {{$shop->regions[0]->name}}
                                                                @if(count($shop->regions))
                                                                    {{$shop->regions[0]->name}}
                                                                @endif
                                                            @endif
                                                        </li>
                                                        <li> الحد الأدنى للطلبات : </li>
                                                        <li> للتواصل : </li>
                                                        <hr>
                                                        <li>إجمالي الطلبات :          </li>
                                                        <li>إجمالي العمولات المستحقة :</li>
                                                        <li>إجمالي المبالغ المسددة :  </li>
                                                        <li>صافي العمولات المستحقة :   </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img height="150px" width="150px" src="{{url('/'.$shop->photo.'/')}}"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                        
                    </table>
                    <div class="pull-right">
                            <a href="{{url('admin/shop/create')}}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> اضافه مطعم جديد 
                            </a>
                </div>
                <div class="text-center">
                    {!! $shops->appends([
                        'name' => request()->input('name'),
                        'region_id' => request()->input('region_id'),
                        'availability' => request()->input('availability'),
                    ])->render() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد سجلات</div>
                </div>
            @endif

        </div>
    </div>


@stop