
@extends('admin.layouts.admin')
<title>Chỉnh sửa người dùng</title>
@section('css')
<link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
<style>
#uploadProgress{
    margin-left:1.5rem;
}
.progress{
    margin-right: 2rem;
}
</style>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Chỉnh sửa người dùng</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Quản lí người dùng</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Chỉnh sửa người dùng</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chỉnh sửa người dùng</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <div class="form-group"><span style="color: red;">*</span>
                                <label class="col-lg-2 control-label">Tên người dùng: </label>
                                <div class="col-lg-4">
                                    <input value="{{$user->name ? $user->name : 'Underfined'}}" type="text" name="name" class="form-control" id="name" required>
                                </div>
                            </div>
                            <div class="form-group"><span style="color: red;">*</span>
                                <label class="col-lg-2 control-label">Email: </label>
                                <div class="col-lg-4">
                                    <input value="{{$user->email ? $user->email : 'Underfined'}}" type="email" name="email" class="form-control" id="email" required>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Số diện thoại: </label>
                                <div class="col-lg-4">
                                    <input value="{{$user->phone_number ? $user->phone_number : 'Underfined'}}" type="number" name="phone_number" class="form-control" id="phone_number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"></label>
                                <div id="preview" class="col-lg-10">(<span style="color: red;">*</span>) là bắt buộc phải điền
                                </div>
                            </div>    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right" id="edit-user-button">Chỉnh sửa người dùng</button>
                            </div>
                        </form>
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
@endsection