<?php include_once 'include/admin_header.php'; ?>
<div class="mt-30">
    <div class="p-3">
            <?php if(isset($active_users) && count($active_users) > 0): ?>
                    <h4 class="mb-3 font-weight-normal text-center">All Users</h4>
                    <table class="table table-responsive-sm table-bordered ">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 10%">S/N</th>
                            <th scope="col" style="width: 45%">Name</th>
                            <th scope="col" style="width: 35%">Created</th>
                            <th scope="col" style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $wltNum = 0;?>
                        <?php foreach($active_users as $wlt): ?>
                            <?php $button2 = $wlt['status'] =="active" ? '<a href="#" class="btn btn-sm  btn-warning block-user-btn"  data-id="'.$wlt['id'].'">Block</a>' : 
                        '<a href="#" class="btn btn-sm btn-secondary unblock-user-btn" data-id="'.$wlt['id'].'">Unblock</a>' ;?>
                        <tr>
                        <th scope="row"><?php echo ++ $wltNum; ?></th>
                        <td><?php echo $wlt['firstname'] .' '.  $wlt['lastname'] ; ?></td>
                        <td class="text-center"><?php echo date_format(date_create($wlt['created_at']),"s:i:H d/m/Y "); ?></td>
                        <!-- <td class="text-center"><a href="#" class="btn btn-sm btn-info">Make Active</a></td> -->
                        <td class="text-center"><div class="mx-2 mb-1"><a href="" class="btn btn-sm btn-info open-fund-btn" data-id="<?php echo $wlt['id']; ?>">Fund</a></div>
                        <div class="mx-2 mb-1"><?php echo $button2; ?></div></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                    
                    
                <?php else: ?>
                    <div>
                        <h5 class="text-center">No Active User</h5>
                    </div>
                <?php endif; ?>
            </div>
    </div>
    <!-- Fund Account Modal -->
    <div class="modal fade" id="fundAccountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: 400px;">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Fund Account</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fund-form-block">
                <div class="fund-message text-center" id="fund-message"></div>
                <div class="form-group mb-4 mt-2">
				<label for="username" class="sr-only">Amount</label>
				<input type="number" id="fund-amount" name="username" class="form-control" placeholder="Amount">
                <div class="text-danger text-left ml-1 field_error" id="error-amount"></div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-sm w-100 btn-primary btn-block fund-btn" type="submit">Fund</button>
                </div>
                </div>
            
            </div>
            </div>
        </div>
    </div>
<?php include_once 'include/admin_footer.php'; ?>
