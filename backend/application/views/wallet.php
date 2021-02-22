<main>
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Wallets</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Wallets
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
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <tr>
                            <td>Wallet Phone Number</td>
                            <td>Account Name</td>
                            <td>Account Number</td>
                            <td>Bank Name</td>
                            <td>Available Balance</td>
                        </tr>
                        <tbody>
                            <tr>
                                <td><?php echo $wallet->phoneNumber; ?></td>
                                <td><?php echo $wallet->accountName; ?></td>
                                <td><?php echo $wallet->accountNumber; ?></td>
                                <td><?php echo $wallet->bank; ?></td>
                                <td><?php echo $wallet->availableBalance; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="footer">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto">
                            <a id="credit-wallet" class="btn btn-info btn-block"> Credit </a>
                            <a id="debit-wallet" class="btn btn-warning btn-block"> Dedit </a>
                        </div>
                        <div class="col-md-8 ml-auto mr-auto">
                            <form class="mt-4" method="post" action="<?php echo site_url('wallet/credit'); ?>" id="credit-wallet-form" style="display: none;">
                                <hr />
                                <h3>Credit User</h3>
                                <input type="hidden" name="uuid" value="<?php echo $wallet->uuid; ?>" />
                                <input type="hidden" name="phone" value="<?php echo $wallet->phoneNumber; ?>" />
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Amount" />
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>

                            <form class="mt-4" method="post" action="<?php echo site_url('wallet/debit'); ?>" id="debit-wallet-form" style="display: none;">
                                <hr />
                                <h3>Debit User</h3>
                                <input type="hidden" name="uuid" value="<?php echo $wallet->uuid; ?>" />
                                <input type="hidden" name="phone" value="<?php echo $wallet->phoneNumber; ?>" />
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Amount" />
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</main>
    