@extends('admin.layouts.admin')
<title>Thống kê sản phẩm</title>
@section('header')
<link href="{{ asset('frontend/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet"> -->
<link href="{{ asset('frontend/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('frontend/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('css')
<style>
 #select-type{
        top: 60px;
        left: 20px;
        position: absolute;
        z-index: 100;
        width: 30rem;
        height: 5rem;
        background-color: #EDEDED;
        border: none!important;
        padding: 0px;
        font-size: 20px;
        font-weight: 900;
    }
</style>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thống kê món ăn</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Admin</a>
            </li>
            <li>
                <a href="/admin">Thống kê</a>
            </li>
            <li class="active">
                <strong>Sản phẩm</strong>
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
                <div class="ibox-title" style="display: flex;justify-content: space-between;position: relative;">
                    <h5>Thống kê món ăn</h5>
                </div>
                <div class="ibox-content ">
                    <div class="ibox float-e-margins">
                        <div class="table-responsive">
                            <table class="table dataTables">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">#</th>
                                        <th style="width: 20%;">Tên món ăn</th>
                                        <th style="width: 20%;">Ảnh minh họa</th>
                                        <th style="width: 10%;">Số hóa đơn</th>
                                        <th style="width: 15%;">Số lượng bán</th>
                                        <th style="width: 15%;">Đánh giá</th>
                                        <th style="width: 15%;">Tổng giá trị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i  = 0;
                                ?>
                                @if(count($foods) > 0)
                                    @foreach ($foods as $food)
                                        <tr>
                                            <td>{{$i += 1}}</td>
                                            <td class="breakline-when-overflow">{{$food->name ? $food->name : 'Underfined'}}</td>
                                            <td><img style="width: 10rem;" src="{{$food->image ? $food->image : 'Underfined'}}" alt="{{$food->image}}"></td>
                                            <td class="breakline-when-overflow">{{$food->count_cart ? $food->count_cart : 0}}</td>
                                            <td class="breakline-when-overflow">{{$food->sold_time ? $food->sold_time : 0}}</td>
                                            @if($food->rate == 'Non')
                                            <td class="breakline-when-overflow">Non</td>
                                            @else
                                            <td class="breakline-when-overflow">{{$food->rate}}</td>
                                            @endif
                                            <td class="breakline-when-overflow">{{$food->sold_total ? $food->sold_total : 0}}</td>
                                        </tr>
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
    });
</script>
<script>
    $('.dataTables').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        swal({
                title: "Bạn có chắc chắn xóa không?",
                text: "Món ăn sau khi xóa sẽ không hồi phục lại được.",
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
                    swal("Đã xóa!", "Đã xóa món ăn.", "success");
                    window.location.href = "/admin/delete-food/" + id;
                } else {
                    swal("Đã hủy", "Đã giữ lại món ăn", "error");
                }
            });
    });
</script>
@endsection