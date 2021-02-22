<main>
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Wallets</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                All Wallets
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/n</th>
                                <th>Wallet Phone Number</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Bank Name</th>
                                <th>Available</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S/n</th>
                                <th>Wallet Phone Number</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Bank Name</th>
                                <th>Available Balance</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                $i = 0;
                                foreach($wallets as $u):
                            ?>

                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $u->phoneNumber; ?></td>
                                <td><?php echo $u->accountName; ?></td>
                                <td><?php echo $u->accountNumber; ?></td>
                                <td><?php echo $u->bank; ?></td>
                                <td><?php echo $u->availableBalance; ?></td>
                                <td><?php echo date('d M-Y h:i A', strtotime($u->created_at)); ?></td>
                                <td>
                                    <a href="<?php echo site_url("wallet/view/$u->uuid") ?>" class="btn btn-info btn-sm"> View </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
    