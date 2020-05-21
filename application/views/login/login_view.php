<form class="form-horizontal m-t-20" id="loginform" action='<?php echo base_url(); ?>login/process' method='post' name='process'>
    <div class="row p-b-30">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                </div>
                <input type="text" name="name" class="form-control
                    form-control-lg" placeholder="Username"
                    aria-label="Username" aria-describedby="basic-addon1" required="">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-receipt"></i></span>
                </div>
                <input type="password" name="password" class="form-control
                    form-control-lg"
                    placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required="">
            </div>
        </div>
    </div>
    <div class="row border-top border-secondary">
        <div class="col-12">
            <div class="form-group">
                <div class="p-t-20">
                    <!-- <button id="btn_signup" class="btn btn-info float-right" type="button" href="<?php echo base_url(); ?>login/signup">Sign
                        up</button> -->
                    <button id="btn_login" class="btn btn-success  form-control" type="submit">Sign in</button>
                </div>
            </div>
        </div>
    </div>
</form>