<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Hotspot <?= $title ?></h3>
                <div class="col-lg-6">
                <form action="<?= site_url('hotspot/saveEditUser') ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="user">User</label>
                                        <input type="hidden"  value="<?= $user['.id']?>" name="id">
                                        <input type="text" name="user" autocomplete="off" value="<?= $user['name']?>" class="form-control" id="user" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password"  value="<?= $user['password']?>" class="form-control" id="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="server">Server</label>
                                        <select name="server" id="server" class="form-control">
                                            <option ><?= $user['server']?></option>
                                            <?php foreach ($server as $data) { ?>
                                                <option><?= $data['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile">Profiles</label>
                                        <select name="profile" id="profile" autocomplete="off" class="form-control">
                                            <?php foreach ($profile as $data) { ?>
                                                <option><?= $user['profile']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="timelimit">Time Limit</label>
                                        <input type="text" name="timelimit" class="form-control" autocomplete="off"  value="<?= $user['limit-uptime']?>" id="timelimit">
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <input type="text" name="comment" class="form-control"  value="<?= $user['comment']?>" id="comment">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-outline-dark">Save</button>
                                </div>
                </form>
            </div>
        </div>
     </div>
</div>