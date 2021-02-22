$(function() {
    let base_url = "http://localhost/sayvers/backend/admin/admin/";
    console.log( "ready test" );
    $(document).on("click", ".open-fund-btn", function (e) {
        e.preventDefault();
        console.log("fund-btn-clicked");
        userId = this.dataset.id;
        $('.fund-form-block').prepend('<input type="hidden" name="fieldname" id="fund-user" value="'+ userId +'" />');
        $("#fundAccountModal").modal('show');
    });
    $(document).on("click", ".fund-btn", function (e) {
        e.preventDefault();
        console.log("fund account");
         var amount = $("#fund-amount").val();
         var userId = $("#fund-user").val();
        console.log(amount + userId);
        if(amount == ''){
            $("#error-amount").html('<p cllass="text-dander">*Amount required</p>');
        }
        else{
            $("#error-amount").html('');
            $.ajax({
                type: "post",
                url: base_url + 'fund_user',
                data: {userId: userId, amount: amount},
                success: (response) => {
                    console.log(response);
                    if(response.status){
                        $('#fund-amount').val('')
                        $("#fund-message").html('<p class="text-success">Fund added successfully</p>');
                    }else{
                        $("#fund-message").html('<p class="text-danger">Error occured!</p>');
                    }
                }
            })

            console.log("yeah"+ userId);
        }
        
    });

    $(document).on("click", ".block-user-btn", function (e) {
        e.preventDefault();
        var userId = this.dataset.id;
        $.ajax({
            type: "post",
            url: base_url + 'block_user',
            data: {userId},
            success: (response) => {
                console.log(response);
                if(response.status){
                    $(this).parent().html('<a href="#" class="btn btn-sm btn-secondary unblock-user-btn" data-id="'+ userId +'">Unblock</a>')
                }else{
                    console.log("Error occured");
                }
            }
        })
    });
    $(document).on("click", ".unblock-user-btn", function (e) {
        e.preventDefault();
        var userId = this.dataset.id;
        $.ajax({
            type: "post",
            url: base_url + 'unblock_user',
            data: {userId},
            success: (response) => {
                console.log(response);
                if(response.status){
                    $(this).parent().html('<a href="#" class="btn btn-sm btn-warning block-user-btn" data-id="'+ userId +'">Block</a>')
                }else{
                    console.log("Error occured");
                }
            }
        })
    });

    // System settings page
    $(document).on("click", "#update_sytem-btn", function (e) {
        e.preventDefault();
        $('.setting-update-msg').html('');
        console.log('system-btn pressed');
        //new values
        var profit = $('#current_profit').val();
        var tranx_fee = $('#transaction_fee').val();
        var app_version = $('#app_version').val();
        //old values
        var saved_profit = $('#current_profit').data('value');
        var saved_tranx_fee = $('#transaction_fee').data('value')
        var saved_app_version = $('#app_version').data('value');
        // console.log(saved_profit + saved_tranx_fee + saved_app_version);

        if(profit == "" && tranx_fee == "" && app_version == ""){
            $('.setting-update-msg').html('<p class="text-danger field_error">Empty Fields. No Data Changed</p>');
            console.log('yeah');
        }
        else if(profit == saved_profit && tranx_fee == saved_tranx_fee && app_version == saved_app_version){
            $('.setting-update-msg').html('<p class="text-info field_error">No Data Changed</p>');
            console.log('yeah');
        }
        else{
            if(profit == ""){
                profit = saved_profit;
            }
            if(tranx_fee == ""){
                tranx_fee = saved_tranx_fee;
            }
            if(app_version == ""){
                app_version = saved_app_version;
            }
            var data = {profit: profit, tranx_fee: tranx_fee, app_version: app_version};
            console.log(data);

            $.ajax({
                type: "post",
                url: base_url + 'update_settings',
                data: data,
                success: (response) => {
                    console.log(response);
                    if(response.status){
                        $('.setting-update-msg').html('<p class="text-success field_error">Settings Updated</p>');

                    }else{
                        $('.setting-update-msg').html('<p class="text-info field_error">Error occured. Try again!</p>');
                        
                    }
                }
            })
        
        }

    });
    
    
});