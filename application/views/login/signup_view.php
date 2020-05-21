<form id="signupform" class="form-horizontal m-t-20" action='<?php echo base_url(); ?>login/signupprocess' method='post'
    name='process'>
    <div class="row p-b-30">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                </div>
                <input id="name" name="name" type="text" class="form-control form-control-lg" placeholder="Username"
                    aria-label="Username" aria-describedby="basic-addon1" required>
            </div>
            <!-- email -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                </div>
                <input id="email" name="email" type="email" class="form-control form-control-lg" placeholder="Email Address"
                    aria-label="Username" aria-describedby="basic-addon1" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                </div>
                <input id="password" name="password" type="password" class="form-control form-control-lg" placeholder="Password"
                    aria-label="Password" aria-describedby="basic-addon1" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                </div>
                <input id="confirm" name="confirm" type="password" class="form-control form-control-lg" placeholder=" Confirm Password"
                    aria-label="Password" aria-describedby="basic-addon1" required>
            </div>
        </div>
    </div>
    <div class="row border-top border-secondary">
        <div class="col-12">
            <div class="form-group">
                <div class="p-t-20">
                    <button id="btn_login" class="btn btn-info float-right" type="button" href="<?php echo base_url(); ?>login/">go
                        to Sign in</button>
                    <button id="btn_signup" class="btn btn-success" type="submit">Sign up</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>