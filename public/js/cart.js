$(document).ready(function(){{
    const monthControl = document.querySelector('input[type="month"]');
    const date= new Date()
    const month=("0" + (date.getMonth() + 1)).slice(-2)
    const year=date.getFullYear()
    monthControl.value = `${year}-${month}`;

    $('#btn-filter-month').click(function(){
        var time = $('#input-month').val();
        var time_array = time.split("-");
        var type = $('#select-type').val();
        var token = $('meta[name="csrf-token"]').attr('content');

        fetch(
            '/admin/cart-chart/' + time_array[1] +'/'+ time_array[0]+'/'+type,
            {
                method: 'GET',
                headers: {
                    "X-CSRF-TOKEN": token
                },
            }
        )
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            if (res.message == 'success') {
                var labels_array = res.labels;
                var datas_array = res.datas;
                var total = res.total;
                // $('#total-value').html('$'+ total);  
    
                var rows = labels_array.split(",");
                var datas = datas_array.split(",");
                var barData = {
                    labels: rows,
                    datasets: [
                        {
                            label: "Số đơn hàng",
                            backgroundColor: 'rgba(26,179,148,0.5)',
                            borderColor: "rgba(26,179,148,0.7)",
                            pointBackgroundColor: "rgba(26,179,148,1)",
                            pointBorderColor: "#fff",
                            data: datas 
                        }
                    ]
                };
                var barOptions = {
                    responsive: true
                };
                var ctx2 = document.getElementById("barChart").getContext("2d");
                new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});  
            } else if (res.edit == 'unauthorized') {
                window.location='/login';
            } else{
                console.log(res);
            }
        })
    });

    //Số lượng đơn hàng tháng hiện tại
    var rows_original = labels.split(",");
    var datas_original = datas.split(",");
    var barData = {
        labels: rows_original,
        datasets: [
            {
                label: "Số đơn hàng",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: datas_original
            }
        ]
    };
    var barOptions = {
        responsive: true
    };
    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
    //Số lượng đơn hàng theo category
    var rows_original_donut = labels_donut.split(",");
    var datas_original_donut = datas_donut.split(",");
    var doughnutData = {
    labels: rows_original_donut,
        datasets: [{
            data: datas_original_donut,
            backgroundColor: ["#a3e1d4","#dedede","#b5b8cf","#374644"]
        }]
    } ;
    var doughnutOptions = {
        responsive: true
    };
    var ctx4 = document.getElementById("doughnutChart").getContext("2d");
    new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    //Số đơn hàng theo món ăn
    var rows_original_donut_food = labels_donut_food.split(",");
    var datas_original_donut_food = datas_donut_food.split(",");
    var barData = {
        labels: rows_original_donut_food,
        datasets: [
            {
                label: "Số đơn hàng",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: datas_original_donut_food
            }
        ]
    };
    var barOptions = {
        responsive: true
    };
    var ctx2 = document.getElementById("barChart_food").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});   
}});