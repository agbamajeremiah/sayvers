<?php include_once 'include/admin_header.php'; ?>
<div class=" mt-30 mx-auto ">
        <div class="mx-3">
            <?php if(isset($all_withdrawals)): ?>
                <h4 class="mb-3 font-weight-normal text-center">Withdrawals</h4>
                <table class="table table-responsive-sm table-bordered">
                <thead>
                    <tr>
                        <th scope="col" style="width: 7%">S/N</th>
                        <th scope="col" style="width: 25%">Customer Name</th>
                        <th scope="col" style="width: 8%">Amount</th>
                        <th scope="col" style="width: 20%">Created</th>
                        <th scope="col" style="width: 10%">Status</th>
                        <th scope="col" style="width: 15%">Action</th>

                    </tr>
                </thead>
                    <?php $wltNum = 0;?>
                     <?php foreach($all_withdrawals as $wlt): ?>
                        <?php $button2 = $wlt['status'] =="pending" ?  '<a href="process_withdrawal/'.$wlt['id'].'" class="btn btn-sm w_75 btn-success" data-id="'.$wlt['id'].'">Transfer</a>' : 
                         '<span>NIL</span>'; ?>
                        <tr>
                        <tr>
                        <th scope="row"><?php echo ++ $wltNum; ?></th>
                        <td><?php echo $wlt['firstname'] .' '.  $wlt['lastname'] ; ?></td>
                        <td><?php echo $wlt['amount']; ?></td>
                        <td class="text-center"><?php echo date_format(date_create($wlt['created_at']),"s:i:H d/m/Y "); ?></td>
                        <td class="text-center"><?php echo $wlt['status']; ?></td>
                        <td class="text-center"><?php echo $button2; ?></td>

                        </tr>
                    <?php endforeach; ?>
                </table>
                
                
            <?php else: ?>
                <div>
                    <h5 class="text-center">No Active Wallet</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php include_once 'include/admin_footer.php'; ?>
