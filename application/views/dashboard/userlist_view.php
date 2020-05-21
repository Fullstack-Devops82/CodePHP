<div class="container-fluid page-userlist">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-container col-md-12">
                        <button id="btn-add" type="button" class="btn
                            btn-success">
                            Add
                        </button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                    </h5>
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped
                            table-bordered"
                            style="width:100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th>Sex</th>
                                    <th>Birthday</th>
                                    <th>Age</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th>Sex</th>
                                    <th>Birthday</th>
                                    <th>Age</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" class="modal-dialog modal-notify
        modal-success">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Name</label>
                            <input class="form-control form-white" placeholder="Enter Name" type="text" name="name"
                                required autocomplete="off">
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">User ID</label>
                            <input class="form-control form-white" placeholder="Enter User ID" type="text" name="userid"
                                required autocomplete="off">
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Sex</label>
                            <select class="bg form-control form-white" data-placeholder="Choose Sex" name="sex"
                                required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Birthday</label>
                            <input class="form-control form-white" placeholder="Enter Birthday" type="date" name="birthday"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Age</label>
                            <input class="form-control form-white" placeholder="Enter Age" type="number" name="age"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Password</label>
                            <input class="form-control form-white" placeholder="Enter password" type="password" name="password"
                                required autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn-add-submit" type="button" class="btn
                    btn-primary">Add User</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" class="modal-dialog modal-notify
        modal-success">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm" autocomplete="off">
                    <input type="hidden" name="userid">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Name</label>
                            <input class="form-control form-white" placeholder="Enter Name" type="text" name="name"
                                required autocomplete="off">
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">User ID</label>
                            <input class="form-control form-white" placeholder="Enter User ID" type="text" name="userid"
                                required autocomplete="off" disabled="disabled">
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Sex</label>
                            <select class="bg form-control form-white" data-placeholder="Choose Sex" name="sex"
                                required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Birthday</label>
                            <input class="form-control form-white" placeholder="Enter Birthday" type="date" name="birthday"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Age</label>
                            <input class="form-control form-white" placeholder="Enter Age" type="number" name="age"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Password</label>
                            <input class="form-control form-white" placeholder="Enter password" type="password" name="password"
                                autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btn-update-submit" type="button" class="btn
                    btn-primary">Update User</button>
            </div>
        </div>
    </div>
</div>
