
@extends('admin.layouts.admin')
<title>Sửa category</title>
@section('css')
<link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet">
<style>
#uploadProgress{
    margin-left:1.5rem;
}
.progress{
    margin-right: 2rem;
}
#rate-area{
    height: 15rem;
    padding-right: 7rem;
    border: 1px solid black;
    overflow-x: scroll;
}
#rate-area p{
    margin-top: 5px;
}
</style>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Sửa category</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Quản lí category</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sửa category</strong>
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
                        <h5>Sửa category</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    @if($category)
                    <div class="ibox-content">
                        <form class="form-horizontal" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <!-- <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" /> -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tên category: </label>
                                <div class="col-sm-4">
                                    <input type="text" name="name" class="form-control" id="name" value="{{$category->name ? $category->name : 'Underfined'}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Hình minh họa</label>
                                <div class="col-sm-4">
                                    <input accept="image/*" type="file" class="banner-img-input" id="image" name="image">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="title"></label>
                                <div class="col-sm-10">
                                    <img style="width:200px;" src="{{$category->image ? $category->image : 'Underfined'}}" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"></label>
                                <div id="preview" class="col-lg-10">
                                </div>
                            </div>    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right" id="create-food-button">Sửa category</button>
                            </div>
                        </form>
                    </div>
                    @endif
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