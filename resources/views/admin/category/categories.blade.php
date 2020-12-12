@extends('admin.layouts.admin')
<title>Danh sách category</title>
@section('header')
<link href="{{ asset('frontend/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet"> -->
<link href="{{ asset('frontend/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('frontend/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Danh sách video</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Admin</a>
            </li>
            <li>
                <a href="/admin">Quản lí category</a>
            </li>
            <li class="active">
                <strong>Danh sách category</strong>
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
                    <h5>Danh sách category</h5>
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
                                                <th>Tên category</th>
                                                <th>Hình minh họa</th>
                                                <th>Số lượng món ăn</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i  = 0;
                                        ?>
                                        @if(count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{$i += 1}}</td>
                                                    <td>{{$category->name ? $category->name : 'Underfined'}}</td>   
                                                    <td><img style="width: 10rem;height: 8rem;" src="{{$category->image ? $category->image : 'Underfined'}}" alt="{{$category->image}}"></td>        
                                                    <td>{{$category->count_food ? $category->count_food : 0}}</td>           
                                                    <td>
                                                        <a href="/admin/edit-category/{{$category->id}}" class="btn btn-primary btn-custom">Cập nhật</a>
                                                        @if($category->count_food > 0)
                                                        <button class="btn btn-danger btn-custom btn-delete" style="width: 6rem;" disabled>Xóa</button>
                                                        @else
                                                        <button class="btn btn-danger btn-custom btn-delete" data-id="{{$category->id}}" style="width: 6rem;">Xóa</button>
                                                        @endif
                                                    </td>
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
                text: "Category sau khi xóa sẽ không hồi phục lại được.",
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
                    swal("Đã xóa!", "Đã xóa video.", "success");
                    window.location.href = "/admin/delete-category/" + id;
                } else {
                    swal("Đã hủy", "Đã dữ lại category", "error");
                }
            });
    });
</script>
@endsection