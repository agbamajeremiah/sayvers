<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="<?php echo site_url(); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="<?php echo site_url('wallet'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Wallets
                </a>

                <a class="nav-link" href="<?php echo site_url('transactions'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Transactions
                </a>

                <a class="nav-link" href="<?php echo site_url('accounts/add'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Create Account
                </a>

                <a class="nav-link" href="<?php echo site_url('accounts'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Settings
                </a>

                <a class="nav-link" href="<?php echo site_url('auth/logout'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Logout
                </a>
            </div>
        </div>
    </nav>
</div>