
@extends('admin.layouts.admin')
<title>Sửa món ăn</title>
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
        <h2>Sửa món ăn</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>Quản lí món ăn</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sửa món ăn</strong>
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
                        <h5>Sửa món ăn</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    @if($food)
                    <div class="ibox-content">
                        <form class="form-horizontal" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <!-- <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" /> -->
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tên món ăn: </label>
                                <div class="col-sm-4">
                                    <input type="text" name="food_name" class="form-control" id="food_name" value="{{$food->name ? $food->name : 'Underfined'}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Chọn category: </label>
                                <div class="col-sm-4">
                                    <select class="select2_demo_1 form-control" name="food_cateID" id="food_cateID">
                                        @foreach($categories as $category)
                                        @if($category->id == $food->cateID)
                                        <option value="{{$category->id}}" selected >{{$category->name}}</option>
                                        @endif
                                        <option value="{{$category->id}}" >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" for="">Description</label>
                                <div class="col-lg-10">
                                    <textarea type="" name="food_description" id="food_description" value="" style="height: 100px;" class="form-control summernote"  required>
                                        {{$food->description ? $food->description : 'Underfined'}}
                                </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Giá món ăn: </label>
                                <div class="col-sm-4">
                                    <input type="number" name="food_price" class="form-control" id="food_price" value="{{$food->price ? $food->price : 'Underfined'}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Hình minh họa</label>
                                <div class="col-sm-4">
                                    <input accept="image/*" type="file" class="banner-img-input" id="food_image" name="food_image">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="title"></label>
                                <div class="col-sm-10">
                                    <img style="width:200px;" src="{{$food->image ? $food->image : 'Underfined'}}" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Số lượng: </label>
                                <div class="col-sm-4">
                                    <input type="number" name="food_stock" class="form-control" id="food_stock" value="{{$food->stock ? $food->stock : 0}}" required>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Rating: </label>
                                <div class="col-sm-4">
                                    <input type="number" name="food_rate" class="form-control" id="food_rate" value="{{$food->rate ? $food->rate : 0}}" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Rates: </label>
                                <div class="col-sm-4" id="rate-area">
                                    @if(count($rates) > 0)
                                    @foreach($rates as $rate)
                                    <p>Rate point: {{$rate->rate_value ? $rate->rate_value : 0}} - Comment: {{$rate->comment ? $rate->comment : 'Underfined'}}</p>
                                    @endforeach
                                    @endif
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-lg-2 control-label"></label>
                                <div id="preview" class="col-lg-10">
                                </div>
                            </div>    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right" id="create-food-button">Sửa món ăn</button>
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