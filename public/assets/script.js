$(function( $ ){
    $('#order_service_id').change(function(){
        if (!$(this).val()) {
            $('#order_price').val(0)
        } else {
            let service_id = $('#order_service_id').val();
            $.ajax({
                url: "/api/service/get_price_by_service",
                method: 'POST',
                data: {
                    service_id: service_id
                },
                success: function (data) {
                    $('#order_price').val(data.price)
                }
            });
        }
    })
})