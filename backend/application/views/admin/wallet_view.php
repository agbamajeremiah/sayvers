<?php include_once 'include/admin_header.php'; ?>
<div class="mt-30 mx-auto ">
        <div class="mx-3">
            <?php if(isset($all_wallet)): ?>
                <h4 class="mb-3 font-weight-normal text-center">All Wallets</h4>
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%">S/N</th>
                        <th scope="col" style="width: 30%">UUID</th>
                        <th scope="col" style="width: 10%">Asset</th>
                        <th scope="col" style="width: 10%">Earnings</th>
                        <th scope="col" style="width: 10%">Status</th>
                        <th scope="col" style="width: 20%">Created</th>
                    </tr>
                </thead>
                    <?php $wltNum = 0;?>
                     <?php foreach($all_wallet as $wlt): ?>
                          
                        <tr>
                        <th scope="row"><?php echo ++ $wltNum; ?></th>
                        <td><?php echo $wlt['firstname'] .' '.  $wlt['lastname'] ; ?></td>
                        <td><?php echo $wlt['asset']; ?></td>
                        <td><?php echo $wlt['earnings']; ?></td>
                        <td class="text-center"><?php echo $wlt['status']; ?></td>
                        <td class="text-center"><?php echo date_format(date_create($wlt['created_at']),"s:i:H d/m/Y "); ?></td>
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
