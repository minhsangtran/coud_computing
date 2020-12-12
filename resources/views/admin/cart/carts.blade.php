@extends('admin.layouts.admin')
<title>Danh sách đơn hàng</title>
@section('header')
<link href="{{ asset('frontend/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet"> -->
<link href="{{ asset('frontend/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('frontend/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('css')
<style>
@media (min-width: 768px){
    .modal-dialog {
        width: 400px;
        margin: 30px auto;
    }
}
</style>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Danh sách đơn hàng</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Admin</a>
            </li>
            <li>
                <a href="/admin">Quản lí đơn hàng</a>
            </li>
            <li class="active">
                <strong>Danh sách đơn hàng</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

@if(count($errors)>0)
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    {{$err}}<br>
    @endforeach
</div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="display: flex;justify-content: space-between;">
                    <div style="width: 30rem;">
                        <select class="form-control" style="border: none!important; padding: 0px;font-size: 15px;font-weight: 900;" id="select-type">
                            @if($type == 'all')
                            <option value="1" selected>Danh sách tất cả đơn hàng</option>
                            <option value="2">Danh sách đơn hàng cũ</option>
                            <option value="3">Danh sách đơn hàng mới</option>
                            @elseif($type == 'paid')
                            <option value="1">Danh sách tất cả đơn hàng</option>
                            <option value="2" selected>Danh sách đơn hàng cũ</option>
                            <option value="3">Danh sách đơn hàng mới</option>
                            @elseif($type == 'new')
                            <option value="1">Danh sách tất cả đơn hàng</option>
                            <option value="2">Danh sách đơn hàng cũ</option>
                            <option value="3" selected>Danh sách đơn hàng mới</option>
                            @endif
                        </select></div>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content ">
                    <div>
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table dataTables">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">#</th>
                                                <th style="width: 20%;">Tên khách hàng</th>
                                                <th style="width: 10%;">Số điện thoại</th>
                                                <th style="width: 15%;">Thời gian đặt</th>
                                                <th style="width: 15%;">Tổng hóa đơn</th>
                                                <th style="width: 10%;">Trạng thái</th>
                                                <th style="width: 15%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i  = 0;
                                        ?>
                                        @if(count($carts) > 0)
                                            @foreach ($carts as $cart)
                                                <tr>
                                                    <td>{{$i += 1}}</td>
                                                    <td class="breakline-when-overflow">{{$cart->customer_name ? $cart->customer_name : 'Underfined'}}</td>
                                                    <td class="breakline-when-overflow">{{$cart->customer_phone_number ? $cart->customer_phone_number : 'Underfined'}}</td>
                                                    <td class="breakline-when-overflow">{{$cart->order_time ? $cart->order_time : 'Underfined'}}</td>
                                                    <td class="breakline-when-overflow">{{$cart->total}}</td>
                                                    @if($cart->status == 1)
                                                    <td class="breakline-when-overflow"><a href="/admin/carts/change-status/{{$cart->id}}" type="button" class="btn btn-success" style="width:10rem;">Done</a></td>
                                                    @else
                                                    <td class="breakline-when-overflow"><a href="/admin/carts/change-status/{{$cart->id}}" type="button" class="btn btn-danger" style="width:10rem;">New</a></td>
                                                    @endif
                                                    <td>
                                                        <button class="btn btn-info btn-custom" style="width: 6rem;"  data-toggle="modal" data-target="#infoModal_{{$cart->id}}">Chi tiết</button>
                                                        <button class="btn btn-danger btn-custom btn-delete" data-id="{{$cart->id}}" style="width: 6rem;">Xóa</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade w-50" id="infoModal_{{$cart->id}}" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header pl-5 pr-5 d-flex align-items-baseline">
                                                                @if($cart->id < 10)
                                                                <h5 class="modal-title">Chi tiết đơn hàng số: HD-0{{$cart->id}}</h5>
                                                                @else
                                                                <h5 class="modal-title">Chi tiết đơn hàng số: HD-{{$cart->id}}</h5>
                                                                @endif
                                                            </div>
                                                            <div class="modal-body pl-5 pr-5 pb-5">
                                                                <div class="form-group mt-1">
                                                                    <label for="valid-email-1">Tên khách hàng: {{$cart->customer_name}}</label>
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <label for="valid-email-1">Số điện thoại: {{$cart->customer_phone_number}}</label>
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <label for="valid-email-1">Thời gian đặt: {{$cart->created_at}}</label>
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <label for="valid-email-1">Tổng đơn hàng: {{$cart->total}} VND</label>
                                                                </div>
                                                                <div class="form-group mt-1">
                                                                    <label for="valid-email-1">Chi tiết các món: </label>
                                                                </div>
                                                                @if(count($cart->details) > 0)
                                                                    @foreach($cart->details as $detail)
                                                                        <div class="form-group mt-1">
                                                                            <label for="valid-email-1">+ {{$detail->food_name}} - {{$detail->quantity}} phần - {{$detail->price}} VND </label>
                                                                        </div>
                                                                    @endforeach      
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('frontend/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('frontend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('frontend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{ asset('frontend/js/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{ asset('frontend/js/custom-link.js')}}"></script>
<script src="{{ asset('frontend/js/custom-summernote.js')}}"></script>

<!-- Chosen -->
<script src="{{ asset('frontend/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('frontend/js/plugins/chosen/chosen.jquery.js') }}"></script>
<!-- btn-delete -->
<script src="{{ asset('frontend/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.dataTables').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [],
            stateSave: true //save the state before reload
        });
        $('#select-type').on('change', function (e) {
            var select = $('#select-type').val();
            var type = 'all';
            if(select ==1){
                var type = 'all';
            }else if(select == 2){
                var type = 'paid';
            }else if(select == 3){
                var type = 'new';
            }
            window.location='/admin/carts/'+ type;
        });
    });
</script>
<script>
    $('.dataTables').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        swal({
                title: "Bạn có chắc chắn xóa không?",
                text: "Đơn hàng sau khi xóa sẽ không hồi phục lại được.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Có",
                cancelButtonText: "Không",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal("Đã xóa!", "Đã xóa đơn hàng.", "success");
                    window.location.href = "/admin/delete-cart/" + id;
                } else {
                    swal("Đã hủy", "Đã giữ lại đơn hàng", "error");
                }
            });
    });
</script>
@endsection