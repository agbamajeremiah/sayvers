<main>
    <div class="container-fluid">
        <h1 class="mt-4">Account</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Settings</li>
        </ol>
        <div class="row">
            <div class="col-md-8 mr-auto ml-auto">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Settings
                    </div>
                    <div class="card-body">
                        <?php 
                            if(@$this->session->flashdata('error')){
                                echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
                            }
                            if(@$this->session->flashdata('success')){
                                echo '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>';
                            }
                        ?>

                        <form class="mt-4" method="post" action="<?php echo site_url('accounts/save_settings'); ?>">
                            
                            <div class="form-group">
                                <label>Transfer Rate (in %)</label>
                                <input type="number" class="form-control" id="rate_change" name="rates" min="0" max="10" value="<?php echo $account->rates; ?>" />
                                <small style="color: #cc0000">Example, If you set transfer rate as "2", 2% of the GHS to NGN conversion rate will be added to the conversion rate</small>
                            </div>

                            <div class="form-group">
                                <label>Transfer Commission Rate (in %)</label>
                                <input type="number" class="form-control" name="commission" min="0" max="10" value="<?php echo $account->commission; ?>" />
                                <small style="color: #cc0000">If you set commission as "1", 1% of the amount will be charged as commission</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    