<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-4 side-left d-flex align-items-stretch">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <div class="row">
                                <h4 class="col-auto mr-auto card-title">Users Info</h4>
                                <a class="col-auto btn btn-danger text-white" href="<?= base_url() ?>users">
                                    <i class="mdi mdi-keyboard-backspace text-white"></i>Back</a>
                            </div>
                            <img src="<?= base_url('images/pelanggan/') . $user['fotopelanggan']; ?>">
                            <p class="name"><?= $user['fullnama'] ?></p>
                            <h4 class="text-center text-primary">
                                <i class="mdi mdi-wallet mr-1 text-primary "></i>Wallet</h4>
                            <p class="text-center">
                                <?= $duit ?>
                                <?= number_format($user['saldo'] ,0, ".", ".") ?>
                            </p>
                            <span class="d-block text-center text-dark"><?= $user['email'] ?></span>
                            <span class="d-block text-center text-dark"><?= $user['no_telepon'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body overview">
                            <ul class="achivements">
                                <li>
                                    <p class="text-success">Id</p>
                                    <p><?= $user['id'] ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Order</p>
                                    <p><?= count($countorder) ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Status</p>
                                    <p>
                                        <?php if ($user['status'] == 1) {
                                            echo 'active';
                                        } else {
                                            echo 'Blocked';
                                        } ?>
                                    </p>
                                </li>
                            </ul>
                            <div class="info-links">
                                <i class="mdi mdi-account-check text-gray">Created On:
                                </i>
                                <p><?= $user['created_on'] ?></p>
                                <i class="mdi mdi-calendar text-gray">Date Of Birth:
                                </i>
                                <p><?= $user['tgl_lahir'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">

                <div class="card-body">
                    <?php if ($this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">User Detail</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Profile Picture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security">Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history">Transaction History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet">Wallet</a>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">

                        <hr>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('users/ubahid'); ?>
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="fullnama" value="<?= $user['fullnama'] ?>" required>
                                </div>

                                <label class="text-small">Phone Number</label>
                                <div class="row">

                                    <div class="form-group col-2">
                                        <input type="tel" id="txtPhone" class="form-control" name="countrycode" value="<?= $user['countrycode'] ?>" required>
                                    </div>
                                    <div class=" form-group col-10">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_lahir">Birth Date</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= $user['tgl_lahir'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" placeholder="Change email address" required>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                <?= form_open_multipart('users/ubahfoto'); ?>
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <input type="file" name="fotopelanggan" class="dropify" data-max-file-size="1mb" data-default-file="<?= base_url('images/pelanggan/') . $user['fotopelanggan'] ?>" />
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <?= form_open_multipart('users/ubahpass'); ?>
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="new-password" name="password" placeholder="Enter you new password" required>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing1" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Transaction Inv</th>
                                                        <th>Service</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($countorder as $tr) { ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td>#INV-<?= $tr['id'] ?></td>
                                                            <td><?= $tr['fitur'] ?></td>
                                                            <td><?= $tr['waktu_order'] ?></td>
                                                            <td class="text-success">
                                                                <?= $duit ?>
                                                                <?= number_format($tr['biaya_akhir'] ,0, ".", ".") ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($tr['status'] == '2') { ?>
                                                                    <label class="badge badge-primary"><?= $tr['status_transaksi']; ?></label>
                                                                <?php } ?>
                                                                <?php if ($tr['status'] == '3') { ?>
                                                                    <label class="badge badge-success"><?= $tr['status_transaksi']; ?></label>
                                                                <?php } ?>
                                                                <?php if ($tr['status'] == '5') { ?>
                                                                    <label class="badge badge-danger"><?= $tr['status_transaksi']; ?></label>
                                                                <?php } ?>
                                                                <?php if ($tr['status'] == '4') { ?>
                                                                    <label class="badge badge-info"><?= $tr['status_transaksi']; ?></label>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?= base_url(); ?>dashboard/detail/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-primary">View</a>
                                                            </td>
                                                        <?php $i++;
                                                    } ?>
                                                        </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing2" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Id</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($wallet as $wl) { ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= $wl['id']; ?></td>
                                                            <td><?= $wl['type']; ?></td>
                                                            <td><?= $wl['waktu']; ?></td>

                                                            <?php if ($wl['type'] == 'topup' or $wl['type'] == 'Order+') { ?>
                                                                <td class="text-success">
                                                                    <?= $duit ?>
                                                                    <?= number_format($wl['jumlah'] ,0, ".", ".") ?>
                                                                </td>

                                                            <?php } else { ?>
                                                                <td class="text-danger">
                                                                    <?= $duit ?>
                                                                    <?= number_format($wl['jumlah'] ,0, ".", ".") ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<script type="text/javascript">
    $(function() {
        var code = "<?= $user['countrycode'] ?>"; // Assigning value from model.
        $('#txtPhone').val(code);
        $('#txtPhone').intlTelInput({
            autoHideDialCode: true,
            autoPlaceholder: "ON",
            dropdownContainer: document.body,
            formatOnDisplay: true,
            hiddenInput: "full_number",
            initialCountry: "auto",
            nationalMode: true,
            placeholderNumberType: "MOBILE",
            preferredCountries: ['US'],
            separateDialCode: false
        });
        console.log(code)
    });
</script>