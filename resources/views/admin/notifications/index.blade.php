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
								'page_header'		=> 'التنبيهات',
								'page_description'	=> 'عرض المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('flash::message')
            @if(count($notifications) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>الاشعار</th>
                        <th>العميل </th>


                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($notifications as $notification)
                            <tr id="removable{{$notification->id}}">
                                <td>{{$count}}</td>
                              @if($notification->read == 0)

                                <td><a class="notification-read" style="cursor: pointer"  data-toggle="modal" data-target="#myModal{{$notification->id}}">{{$notification->title}}</a></td>


                              @else

                                <td><a style="color:black; cursor: pointer" data-toggle="modal" data-target="#myModal{{$notification->id}}">{{$notification->title}}</a></td>


                              @endif
                                <td>
                                    @if(($notification))
                                        {{$notification->client->name}}
                                </td>
                                    @endif


                                </td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$notification->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">{{$notification->title}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <ul>
                                                      <li> الاشعار  : {{$notification->content}}  </li>

                                                      <hr>
                                                        <li>الطلب :    {{$notification->order->offers[0]->title}}     </li>
                                                        <li>حالة الطلب : {{$notification->order->state}}    </li>

                                                    </ul>
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


            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد سجلات</div>
                </div>
            @endif

        </div>
    </div>


@stop
