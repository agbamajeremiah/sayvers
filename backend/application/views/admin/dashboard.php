<?php include_once 'include/admin_header.php'; ?>

<!--start dashboard -->
    <div class="mt-30 mx-auto ">
       <div class="mx-3">
            <div class="row">
                <div class="col-sm-12  col-md-6 mb-2">
                    <div class="ml-2">
                        <h5>Overiew</h5>
                    </div>
                </div>
               
            </div>
            <div class="row pt-4 px-2 bg-light-grey">
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4 text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-2">
                                <h3 class="value font-weight-bold" style="margin-bottom:0"><?php echo number_format($active_users); ?></h3>
                            </div> 
                            <div>
                                <p class="item small">Active Users</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4 text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-2">
                                <h3 class="value font-weight-bold" style="margin-bottom:0"><?php echo number_format($active_wallets); ?></h3>
                            </div>
                            <div>
                                <p class="item small">Active Wallets</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4 text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-2">
                                <h3 class="value font-weight-bold" style="margin-bottom:0"><?php echo $total_tranx; ?></h3>
                            </div>
                            <div>
                                <p class="item small">Transactions</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4 text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-2">
                                <h3 class="value font-weight-bold" style="margin-bottom:0"><?php echo $current_profit . '%'; ?></h3>
                            </div>
                            <div>
                                <p class="item small">Trading Profit</p>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="row  mt-5">
                <div class="col-sm-12 mb-2">
                    <div class="ml-2">
                        <h5>Monthly Chart</h5>
                    </div>
                </div>
               
            </div>
       </div>
    </div>



<?php include_once 'include/admin_footer.php'; ?>
