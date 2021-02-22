            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Skycombabs</div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets/assets/demo/datatables-demo.js'); ?>"></script>
        <script>
            $(function(){
                $('#credit-wallet').click(function(){
                    $('#credit-wallet-form').show();
                })

                $('#debit-wallet').click(function(){
                    $('#debit-wallet-form').show();
                })
            })
        </script>
        <?php if(@$page == 'settings'):?>
            <script>

                let rate = $(this).val();
                const req = {uuid: "<?php echo $this->session->userdata('user_id'); ?>", amount : 1, currency:"GHS"}
                
                $.ajax({
                    type: "post",
                    url: "https://skycombabs.com/app/api/v1/transfer/international/rates",
                    data: {uuid: req.uuid, amount: req.amount, currency: req.currency},
                    success: (response) => {
                        let conv = response.data.AmountInNaira;
                        $('#show_rate').text(`Your rate will be ${conv} instead of ${response.data.ActualRate}`);
                    }
                });

                $(document).on('keyup', '#rate_change', function(){
                    let rate = $(this).val();
                    $('#show_rate').text('Computing your rate');
                    const req = {uuid: "<?php echo $this->session->userdata('user_id'); ?>", amount : 1, currency:"GHS"}
                    
                    $.ajax({
                        type: "post",
                        url: "https://skycombabs.com/app/api/v1/transfer/international/rates",
                        data: {uuid: req.uuid, amount: req.amount, currency: req.currency},
                        success: (response) => {
                            let conv = response.data.ActualRate;
                            let newRate = (conv * (rate / 100)) + conv;

                            $('#show_rate').text(`Your rate will be ${newRate} instead of ${conv}`);
                        }
                    })

                    
                })
            
            </script>
        <?php endif; ?>
    </body>
</html>
