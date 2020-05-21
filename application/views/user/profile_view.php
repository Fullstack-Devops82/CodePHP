<?php
// picture_name

?>
<div class="container-fluid page-profile">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center user-info" user_id="<?php echo $data['id']; ?>">
                    <!-- <h4 class="card-title">Personal Info</h4> -->
                    <div class="picture">
                        <img src="" />
                    </div>
                    <div class="name">

                    </div>
                    <div class="email">

                    </div>
                    <div class="city">

                    </div>
                    <div class="status">

                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btn_edit" type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#updateUserModal">Edit</button>
                                <button id="btn_password" type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#updatePasswordModal">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- edit profile modal  -->
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" class="modal-dialog modal-notify
        modal-success">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update
                    <?php echo $data['name']; ?> Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm" autocomplete="off">
                    <input type="hidden" name="user_id">
                    <div class="col-md-12">
                        <div class="preview">
                            <img>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label></label>
                        <div class="custom-file">
                            <input type="hidden" name="picture">
                            <input type="hidden" name="thumb">
                            <input id="" type="file" class="user-picture custom-file-input" style="display:none;"
                                accept=".png, .jpg" onchange="javascript:cropImage([128, 128], {'picture':[256, 256], 'thumb':[64, 64]}, this, 'file_name')">
                            <label class="custom-file-label" name="file_name" for="validatedCustomFile" onClick="javascript:$('#updateUserModal input.user-picture').click(); ">Choose
                                Picture file...</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label text-right col-form-label">Email Address</label>
                        <input class="form-control form-white" placeholder="Enter Email Address" type="email" name="email"
                            required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label text-right col-form-label">City</label>
                        <input class="automap form-control form-white" placeholder="Enter City" type="text" name="city">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-action">Update User</button>
            </div>
        </div>
    </div>
</div>
<!-- edit password modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" class="modal-dialog modal-notify
        modal-success">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm" autocomplete="off">
                    <input type="hidden" name="user_id" />
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-right col-form-label">Pre Password</label>
                        <input class="col-md-9 form-control form-white" placeholder="Enter Pre Password" type="text" id="pre_password"
                            name="pre_password" required autocomplete="off">
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-right col-form-label">New Password</label>
                        <input class="col-md-9 form-control form-white" placeholder="Enter New Password" type="text" id="new_password"
                            name="new_password" required autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-action">Update Password</button>
            </div>
        </div>
    </div>
</div>