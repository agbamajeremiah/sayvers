<main>
    <div class="container-fluid">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Accounts</li>
            <li class="breadcrumb-item active">An an account</li>
        </ol>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-body">
                                        <form method="post" action="<?php echo site_url("accounts/add"); ?>">
                                        <?php 
                                           if(@$this->session->flashdata('error')){
                                                echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
                                            }

                                            if(@$this->session->flashdata('success')){
                                                echo '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>';
                                            }
                                        ?>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4" id="inputFirstName" type="text" name="firstname" placeholder="Enter first name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" id="inputLastName" type="text" name="lastname" placeholder="Enter last name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" >Email</label>
                                                        <input class="form-control py-4" type="email" name="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1">Phone number</label>
                                                        <input class="form-control py-4" type="text" name="phone" placeholder="+2349011111111" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1">Password</label>
                                                        <input class="form-control py-4" type="password" name="password" placeholder="Enter password" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1">Confirm Password</label>
                                                        <input class="form-control py-4" type="password" name="confirmpwd" placeholder="Confirm password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1">BVN</label>
                                                        <input class="form-control py-4" type="text" name="bvn" placeholder="211000000000" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="dob">Date of Birth</label>
                                                        <input class="form-control py-4" id="dob" type="date" name="dob" placeholder="date of birth" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="dob">Currency</label>
                                                <input class="form-control py-4" id="currency" type="text" name="currency" placeholder="currency" />
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" type="submit">Add User </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</main>
    