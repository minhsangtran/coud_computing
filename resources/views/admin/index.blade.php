@extends('admin.layouts.admin')

@section('css')
<style>
.static__item {
    text-align: center;
}
.static__item span {
    font-size: 80px;
}
.static__item p {
    font-size: 20px;
}
.filter-time{
    margin-left: 3rem!important;
}
.list-group.clear-list .list-group-item {
    margin-left: 3rem;
}
#select-type{
    width: 20rem;
}
#new-user-title{
    font-size: 20px;
    font-weight: bold;
    padding-left: 3rem;
    padding-top: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e7eaec;
}
.new-title{
    padding-top: 1rem!important;
    font-size: 20px!important;
    font-weight: bold;
}
.count-new{
    color: #1EB0BB;
}
.ibox-content{
    min-height: 45rem;
}
.btn-info{
    background-color: #1EB0BB;
}
.base-info-index:hover span{
    color: #1EB0BB;
}
.base-info-index:hover p{
    color: #1EB0BB;
}
.breadcrumb-item {
    font-size: 16px;
    font-weight: bold;
}
.detail-chart{
    font-size: 20px;
    font-weight: bold;
}
#chart-detail{
    margin-left: 5rem;
    margin-top: 5rem;
}
</style>
@endsection

@section('content')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-12">
        <div class="row text-left">
            <div class="col-xs-4 static__item base-info-index" style="border-right: 1px solid #E5E5E5;">
                <span class="h4 font-bold m-t block">{{$count_user ? $count_user : 0}}</span>
                <p class="text-muted m-b block" style="font-weight:bold;">Người dùng</p>
            </div>
            <div class="col-xs-4 static__item base-info-index" style="border-right: 1px solid #E5E5E5;">
                <span class="h4 font-bold m-t block">{{$count_food ? $count_food : 0}}</span>
                <p class="text-muted m-b block" style="font-weight:bold;">Món ăn</p>
            </div>
            <div class="col-xs-4 static__item base-info-index">
                <span class="h4 font-bold m-t block">{{$count_cart ? $count_cart : 0}}</span>
                <p class="text-muted m-b block" style="font-weight:bold;">Đơn hàng</p>
            </div> 
        </div>
    </div>
</div>
<div class="wrapper wrapper-content" style="height: 815px;">
    <div class="col-lg-12" style="display: flex;">
        <div class="ibox float-e-margins col-lg-12" style="margin-top: 20px;">
            <div class="ibox-title" style="display: flex;">
                <h5 style="margin-top: 1rem;margin-right: 1rem;">Today: {{$today  ? $today : 'Underfined'}}</h5>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content" style="border:none;">
                            <div style="max-height: 450px">
                                <canvas height="80" id="barChart"></canvas>
                            </div>
                            <div id="chart-detail" >
                                <p class="detail-chart">Chi tiết</p>
                                <ul>
                                    <li class="detail-chart">Tổng doanh thu trong ngày: {{$total ? $total : 0}} VND</li>
                                    <li class="detail-chart">Tổng số đơn hàng: {{$count_cart ? $count_cart : 0}}</li>
                                    <li class="detail-chart">Số đơn hàng chưa xử lí: {{$count_cart_not ? $count_cart_not : 0}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var labels = "{{ $labels }}"
    var datas = "{{ $datas }}"
</script>
@endsection

@section('script')
<script src="{{ asset('frontend/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('frontend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('frontend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<script src="{{asset('frontend/js/plugins/chartJs/Chart.min.js')}}"></script>
<script src="{{asset('public/js/index.js')}}"></script>
@endsection
