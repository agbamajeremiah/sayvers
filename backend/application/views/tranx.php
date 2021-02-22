<main>
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Transactions</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Transactions
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/n</th>
                                <th>Amount</th>
                                <th>Trans. Type</th>
                                <th>Trans. Ref</th>
                                <th>Affected User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S/n</th>
                                <th>Amount</th>
                                <th>Trans. Type</th>
                                <th>Trans. Ref</th>
                                <th>Affected User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                $i = 1;
                                foreach($tranx as $u):
                                    // $wallet = $this->crud_m->fetch(array('uuid' => $u->receiver), 'wallets');
                            ?>

                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $u->amount; ?></td>
                                <td><?php echo $u->tranx_type; ?></td>
                                <td><?php echo $u->tranx_ref; ?></td>
                                <td><?php echo $u->receiver; ?></td>
                                <td><?php echo date('d M-Y h:i A', strtotime($u->created_at)); ?></td>
                                <td>
                                    <a href="<?php echo site_url("transactions/view/$u->id") ?>" class="btn btn-info btn-sm"> View </a>
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
    