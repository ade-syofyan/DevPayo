<style>
    .toggle.ios,
    .toggle-on.ios,
    .toggle-off.ios {
        border-radius: 20px;
    }

    .toggle.ios .toggle-handle {
        border-radius: 20px;
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h4 class="card-title">App Settings</h4>
                        </div>
                        <!-- toogle switch  -->
                        <div class="col-md-3">
                            <input data-id="<?= $appsettings['id'] ?>" class="toggle-class" type="checkbox" name="app_maintenance" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-style="ios" data-toogle="toogle" data-on="Running" data-off="Maintenence" <?= $appsettings['app_maintenance'] ? 'checked' : '' ?>>
                        </div>
                    </div>
                    <?php if ($this->session->flashdata('send') or $this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('send'); ?>
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="tab-minimal tab-minimal-success">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#app-2-1" role="tab" aria-controls="app-2-1" aria-selected="true">
                                    <i class="mdi mdi-cellphone-android"></i>App</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#email-2-2" role="tab" aria-controls="email-2-2" aria-selected="false">
                                    <i class="mdi mdi-email-outline"></i>Email</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#smtp-2-3" role="tab" aria-controls="smtp-2-3" aria-selected="false">
                                    <i class="mdi mdi-message-text-outline"></i>SMTP</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-4" data-toggle="tab" href="#stripe-2-4" role="tab" aria-controls="stripe-2-4" aria-selected="false">
                                    <i class="mdi mdi-credit-card"></i>Stripe</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-5" data-toggle="tab" href="#paypal-2-5" role="tab" aria-controls="paypal-2-5" aria-selected="false">
                                    <i class="icon-paypal menu-icon"></i>PayPal</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-6" data-toggle="tab" href="#payumoney-2-6" role="tab" aria-controls="#payumoney-2-6" aria-selected="false">
                                    <i class="icon-credit-card menu-icon"></i>Pay U Money</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-7" data-toggle="tab" href="#banktransfer-2-7" role="tab" aria-controls="banktransfer-2-7" aria-selected="false">
                                    <i class="icon-credit-card menu-icon"></i>Bank Transfer</a>
                            </li>
                        </ul>

                        <div class="tab-content col-12 justify-content-center">
                            <div class="tab-pane fade show active" id="app-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">App Settings</h4>
                                            <br>
                                            <?= form_open_multipart('appsettings/ubahapp'); ?>
                                            <div class="form-group">
                                                <label for="appemail">App Email</label>
                                                <input type="email" class="form-control" id="appemail" name="app_email" value="<?= $appsettings['app_email']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="appname">App Name</label>
                                                <input type="text" class="form-control" id="appname" name="app_name" value="<?= $appsettings['app_name']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="appcontact">App Contact</label>
                                                <input type="text" class="form-control" id="appcontact" name="app_contact" value="<?= $appsettings['app_contact']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="appwebsite">App Website</label>
                                                <input type="text" class="form-control" id="appwebsite" name="app_website" value="<?= $appsettings['app_website']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="privacypolicy">Privacy Policy</label>
                                                <textarea type="text" class="form-control" id="summernoteExample1" name="app_privacy_policy" required><?= $appsettings['app_privacy_policy']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="privacypolicy">Buku Panduan</label>
                                                <textarea type="text" class="form-control" id="summernoteExample2" name="app_book_guide" required><?= $appsettings['app_book_guide']; ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="aboutus">About Us</label>
                                                <textarea type="text" class="form-control" id="summernoteExample3" name="app_aboutus" required><?= $appsettings['app_aboutus']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="appaddress">App Address</label>
                                                <textarea type="text" class="form-control" id="summernoteExample4" name="app_address" required><?= $appsettings['app_address']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="googlelink">Google Link</label>
                                                <input type="text" class="form-control" id="googlelink" name="app_linkgoogle" value="<?= $appsettings['app_linkgoogle']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="appcurrency">App Currency</label>
                                                <input type="text" class="form-control" id="appcurrency" name="app_currency" value="<?= $appsettings['app_currency']; ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="email-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Email Template For Forgot Password</h4>
                                            <br>
                                            <?= form_open_multipart('appsettings/ubahemail'); ?>
                                            <div class="form-group">
                                                <label for="emailsubject">Email Subject</label>
                                                <textarea type="email" class="form-control" id="emailsubject" name="email_subject" required><?= $appsettings['email_subject']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="emailtext1">Email Text 1</label>
                                                <textarea type="email" class="form-control" id="summernoteExample5" name="email_text1" required><?= $appsettings['email_text1']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="emailtext2">Email Text 2</label>
                                                <textarea type="email" class="form-control" id="summernoteExample6" name="email_text2" required><?= $appsettings['email_text2']; ?></textarea>
                                            </div>

                                            <h4 class="card-title">Email Template For Confirm Driver</h4>

                                            <div class="form-group">
                                                <label for="emailsubject1">Email Subject</label>
                                                <textarea type="email" class="form-control" id="emailsubject1" name="email_subject_confirm" required><?= $appsettings['email_subject_confirm']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="emailtext1">Email Text 1</label>
                                                <textarea type="email" class="form-control" id="summernoteExample7" name="email_text3" required><?= $appsettings['email_text3']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="emailtext2">Email Text 2</label>
                                                <textarea type="email" class="form-control" id="summernoteExample8" name="email_text4" required><?= $appsettings['email_text4']; ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="smtp-2-3" role="tabpanel" aria-labelledby="tab-2-3">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">SMTP Settings</h4>
                                            <br>
                                            <?php if (demo == TRUE) { ?>
                                                <?= form_open_multipart('appsettings/ubahsmtp'); ?>
                                                <div class="form-group">
                                                    <label for="smtphost">SMTP Host</label>
                                                    <input type="text" class="form-control" id="smtphost" name="smtp_host" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpport">SMTP Port</label>
                                                    <input type="text" class="form-control" id="smtpport" name="smtp_port" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpusername">SMTP User Name</label>
                                                    <input type="text" class="form-control" id="smtpusername" name="smtp_username" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtppassword">SMTP Password</label>
                                                    <input type="password" class="form-control" id="smtppassword" name="smtp_password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpform">SMTP Form</label>
                                                    <input type="text" class="form-control" id="smtpfrom" name="smtp_from" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtp_secure">SMTP Secure</label>
                                                    <select class="form-control border-primary" name="smtp_secure" id="smtp_secure">
                                                        <option value="tls" <?php if ($appsettings['smtp_secure'] == 'tls') { ?>selected<?php } ?>>TLS</option>
                                                        <option value="ssl" <?php if ($appsettings['smtp_secure'] == 'ssl') { ?>selected<?php } ?>>SSL</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                                <?= form_close(); ?>
                                            <?php } else { ?>
                                                <?= form_open_multipart('appsettings/ubahsmtp'); ?>
                                                <div class="form-group">
                                                    <label for="smtphost">SMTP Host</label>
                                                    <input type="text" value="<?= $appsettings['smtp_host']; ?>" class="form-control" id="smtphost" name="smtp_host" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpport">SMTP Port</label>
                                                    <input type="text" class="form-control" id="smtpport" name="smtp_port" value="<?= $appsettings['smtp_port']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpusername">SMTP User Name</label>
                                                    <input type="text" class="form-control" id="smtpusername" name="smtp_username" value="<?= $appsettings['smtp_username']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtppassword">SMTP Password</label>
                                                    <input type="password" class="form-control" id="smtppassword" name="smtp_password" value="<?= $appsettings['smtp_password']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtpform">SMTP Form</label>
                                                    <input type="text" class="form-control" id="smtpfrom" name="smtp_from" value="<?= $appsettings['smtp_from']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="smtp_secure">SMTP Secure</label>
                                                    <select class="form-control border-primary" name="smtp_secure" id="smtp_secure">
                                                        <option value="tls" <?php if ($appsettings['smtp_secure'] == 'tls') { ?>selected<?php } ?>>TLS</option>
                                                        <option value="ssl" <?php if ($appsettings['smtp_secure'] == 'ssl') { ?>selected<?php } ?>>SSL</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                                <?= form_close(); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="stripe-2-4" role="tabpanel" aria-labelledby="tab-2-4">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Stripe Settings</h4>
                                            <br>
                                            <?= form_open_multipart('appsettings/ubahstripe'); ?>
                                            <div class="form-group">
                                                <label for="stripesecretkey">Stripe Secret Key</label>
                                                <input type="text" class="form-control" id="stripesecretkey" name="stripe_secret_key" value="<?= $appsettings['stripe_secret_key']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stripepublishedkey">Stripe Published Key</label>
                                                <input type="text" class="form-control" id="stripepublishedkey" name="stripe_published_key" value="<?= $appsettings['stripe_published_key']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="stripe_status">Stripe Mode</label>
                                                <select name="stripe_status" id="stripe_status" class="js-example-basic-single" style="width:100%">
                                                    <option value="1" <?php if ($appsettings['stripe_status'] == '1') { ?>selected<?php } ?>>Development Mode</option>
                                                    <option value="2" <?php if ($appsettings['stripe_status'] == '2') { ?>selected<?php } ?>>Published</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="stripe_active">Stripe Status</label>
                                                <select name="stripe_active" id="stripe_active" class="js-example-basic-single" style="width:100%">
                                                    <option value="1" <?php if ($appsettings['stripe_active'] == '1') { ?>selected<?php } ?>>Active</option>
                                                    <option value="0" <?php if ($appsettings['stripe_active'] == '0') { ?>selected<?php } ?>>NonActive</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="paypal-2-5" role="tabpanel" aria-labelledby="tab-2-5">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">PayPal Settings</h4>
                                            <br>
                                            <?= form_open_multipart('appsettings/ubahpaypal'); ?>
                                            <div class="form-group">
                                                <label for="paypalkey">PayPal Key</label>
                                                <input type="text" class="form-control" id="paypalkey" name="paypal_key" value="<?= $appsettings['paypal_key'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="paypalcurrency">PayPal Currency</label>
                                                <input type="text" class="form-control" id="paypalcurrency" name="app_currency_text" value="<?= $appsettings['app_currency_text'] ?>" required>
                                                <a Paypal href="https://developer.paypal.com/docs/api/reference/currency-codes/">
                                                    <p>Paypal Currency</p>
                                                </a>
                                            </div>
                                            <div class="form-group">
                                                <label for="paypal_mode">PayPal Mode</label>
                                                <select name="paypal_mode" id="paypal_mode" class="js-example-basic-single" style="width:100%">
                                                    <option value="1" <?php if ($appsettings['paypal_mode'] == '1') { ?>selected<?php } ?>>Development Mode</option>
                                                    <option value="2" <?php if ($appsettings['paypal_mode'] == '2') { ?>selected<?php } ?>>Published</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="paypal_active">PayPal Status</label>
                                                <select name="paypal_active" id="paypal_active" class="js-example-basic-single" style="width:100%">
                                                    <option value="1" <?php if ($appsettings['paypal_active'] == '1') { ?>selected<?php } ?>>Active</option>
                                                    <option value="0" <?php if ($appsettings['paypal_active'] == '0') { ?>selected<?php } ?>>NonActive</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="payumoney-2-6" role="tabpanel" aria-labelledby="tab-2-6">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Pay U Money Settings</h4>
                                            <br>
                                            <?= form_open_multipart('appsettings/ubahpayumoney'); ?>
                                            <div class="form-group">
                                                <label for="payu_key">Pay U Money Key</label>
                                                <input type="text" class="form-control" id="payu_key" name="payu_key" value="<?= $payusettings['payu_key']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="payu_id">Pay U Money Id</label>
                                                <input type="text" class="form-control" id="payu_id" name="payu_id" value="<?= $payusettings['payu_id']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="payu_salt">Pay U Money Salt</label>
                                                <input type="text" class="form-control" id="payu_salt" name="payu_salt" value="<?= $payusettings['payu_salt']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="payu_debug">Pay U Money Debug</label>
                                                <select name="payu_debug" id="payu_debug" class="js-example-basic-single" style="width:100%">
                                                    <option value="0" <?php if ($payusettings['payu_debug'] == '0') { ?>selected<?php } ?>>Development Mode</option>
                                                    <option value="1" <?php if ($payusettings['payu_debug'] == '1') { ?>selected<?php } ?>>Published</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="active">Stripe Status</label>
                                                <select name="active" id="active" class="js-example-basic-single" style="width:100%">
                                                    <option value="1" <?php if ($payusettings['active'] == '1') { ?>selected<?php } ?>>Active</option>
                                                    <option value="0" <?php if ($payusettings['active'] == '0') { ?>selected<?php } ?>>NonActive</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="banktransfer-2-7" role="tabpanel" aria-labelledby="tab-2-7">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Bank Transfer Settings</h4>
                                            <div>
                                                <a class="btn btn-info" href="<?= base_url(); ?>appsettings/addbank"><i class="mdi mdi-plus-circle-outline"></i>Add Bank</a>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table id="order-listing7" class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Image</th>
                                                                    <th>Bank Name</th>
                                                                    <th>Account Number</th>
                                                                    <th>Status</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 1;
                                                                foreach ($transfer as $trf) { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><img src="<?= base_url('images/bank/') . $trf['image_bank']; ?>"></td>
                                                                        <td><?= $trf['nama_bank'] ?></td>
                                                                        <td><?= $trf['rekening_bank'] ?></td>
                                                                        <td><?php if ($trf['status_bank'] == 1) { ?>
                                                                                <label class="badge badge-primary">Active</label>
                                                                            <?php } else if ($trf['status_bank'] == 0) { ?>
                                                                                <label class="badge badge-danger">Non Active</label>
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?= base_url(); ?>appsettings/editbank/<?= $trf['id_bank'] ?>">
                                                                                <button class="btn btn-outline-primary">Edit</button>
                                                                            </a>
                                                                            <a href="<?= base_url(); ?>appsettings/hapusbank/<?= $trf['id_bank'] ?>" onclick="return confirm ('are you sure?')">
                                                                                <button class="btn btn-outline-danger">Delete</button>
                                                                            </a>
                                                                        </td>
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
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.toggle-class').change(function() {
            var app_maintenance = $(this).prop('checked') == true ? 1 : 0;
            var app_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "<?= base_url('Appsettings/changeStatus') ?>",
                data: {
                    'app_maintenance': app_maintenance,
                    'id': app_id
                },
                success: function(data) {
                    console.log('Success')
                }
            })
        })
    })
</script>