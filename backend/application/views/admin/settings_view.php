<?php include_once 'include/admin_header.php'; ?>
    <div class="mt-30">
           <div class="container">
            <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="ml-1">
                            <h5>System Settings</h5>
                        </div>
                    </div>
                
                </div>
                <div class="row mx-1 pt-4 bg-light-grey mb-4">
                    <div class="col-sm-12 setting-update-msg text-center"> </div>
                    <div class="col-sm-4 text-center">
                        <div class="card card-bg-none">
                            <div class="card-body">
                            <div class="form-group">
                                    <label for="current_profit" class="small">Current Profit</label>
                                    <input type="number" id="current_profit"  class="form-control border-0" placeholder="current profit"  value="<?php echo $system_data['current_profit']; ?>" data-value="<?php echo $system_data['current_profit']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="card card-bg-none">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="transaction_fee" class="small">Transaction Fee in %</label>
                                    <input type="number" id="transaction_fee" class="form-control border-0" placeholder="transaction fee"  value="<?php echo $system_data['transaction_percent']; ?>" data-value="<?php echo $system_data['transaction_percent']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="card card-bg-none">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="app_version" class="small">App Version</label>
                                    <input type="text" id="app_version" class="form-control border-0" placeholder="app version"  value="<?php echo $system_data['app_version']; ?>" data-value="<?php echo $system_data['app_version']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12  text-center">
                        <div class="card card-bg-none">
                            <div class="card-body">
                                <div class="form-group">
                                <button class="btn btn-sm update-btn" id="update_sytem-btn">UPDATE
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
           
       </div>
    </div>



<?php include_once 'include/admin_footer.php'; ?>
