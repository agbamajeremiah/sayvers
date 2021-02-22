<main>
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Users</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                All Blocked Users
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/n</th>
                                <th>Personal Data</th>
                                <th>Login details</th>
                                <th>Date Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S/n</th>
                                <th>Personal Data</th>
                                <th>Login details</th>
                                <th>Start Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                $i = 0;
                                foreach($users as $u):
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo "<span style='color: red'>Name:</span> $u->firstname $u->lastname <br> <span style='color: red'>Email:</span> $u->email <br> <span style='color: red'>Phone number:</span> $u->phone"; ?></td>
                                <td><?php echo '<span style="color: red">Last LoggedIn:</span> '. date('d M-Y h:i A', strtotime($u->last_login)).' <br> <span style="color: red">IP Address: </span>'. $u->ip_address; ?></td>
                                <td><?php echo date('d M-Y h:i A', strtotime($u->created_at)); ?></td>
                                <td><span class="badge badge-<?php echo $u->status === 'active' ? 'success' : ($u->status === 'inactive' ? 'warning' : 'danger'); ?>"><?php echo $u->status; ?></span></td>
                                <td>
                                    <a href="<?php echo site_url("dashboard/edit_user/$u->uuid") ?>" class="btn btn-info btn-sm"> Edit </a>
                                    <a href="<?php echo site_url("dashboard/delete_user/$u->uuid/delete") ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? Action cannot be undone')"> Delete </a>
                                    <a href="<?php echo site_url("dashboard/edit_user/$u->uuid/activate") ?>" class="btn btn-primary btn-sm"> Activate </a>
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
    