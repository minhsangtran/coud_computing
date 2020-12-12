@extends('admin.layouts.admin')
<title>Analyst Revenue</title>
@section('header')
<link href="{{ asset('frontend/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('frontend/css/plugins/summernote/summernote.css') }}" rel="stylesheet"> -->
<link href="{{ asset('frontend/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('frontend/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

@endsection

@section('css')
<style>
.chart{
    height: 800px!important;
}
.ibox-title{
    border: none!important;
}
.circle-title{
    text-align: center;
}
#select-type{
    padding-bottom: 3px;
    padding-top: 1px;
    font-size: 20px;
    font-weight: bold;
    width: 15rem;
}
</style>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thống kê</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/admin">Admin</a>
            </li>
            <li>
                <a href="/admin">Thống kê</a>
            </li>
            <li class="active">
                <strong>Thống kê doanh thu</strong>
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
                    <div style="width: 30rem;"><h5>Số lượng dơn hàng</h5></div>
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
                    <div class="ibox-title" style="margin-left:4rem;">
                        <input type="month" style="font-size:20px;font-weight:bold;width:25rem;" id="input-month">
                        <select class="" id="select-type">
                            <option value="month">Theo tháng</option>
                            <option value="year">Theo năm</option>
                        </select>
                        <button class="btn btn-info" id="btn-filter-month">Filter</button>
                    </div>
                    <div>
                        <canvas class="chart" id="barChart" height="140"></canvas>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox-title">
                        <h5>Tỉ trọng đơn hàng theo category</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas class="" id="doughnutChart" height="140"></canvas>
                        </div>
                        <!-- <div class="col-lg-6">
                            <h3 class="circle-title">Theo món ăn</h3>
                            <canvas class="" id="doughnutChart_food" height="140"></canvas>
                        </div> -->
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="ibox-title">
                        <h5>Theo các món ăn</h5>
                    </div>
                    <div>
                        <canvas class="chart" id="barChart_food" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var labels = "{{$labels}}"
var datas = "{{$datas}}"
var labels_donut = "{{$labels_donut}}"
var datas_donut = "{{$datas_donut}}"
var labels_donut_food = "{{$labels_donut_food}}"
var datas_donut_food = "{{$datas_donut_food}}"
</script>
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

<!--Chart=-->
<script src="{{asset('frontend/js/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{asset('public/js/cart.js')}}"></script>
@endsection