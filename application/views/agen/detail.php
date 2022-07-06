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
                                <h4 class="col-auto mr-auto card-title">Info Agen</h4>
                                <a class="col-auto btn btn-danger text-white" href="<?= base_url(); ?>agent">
                                    <i class="mdi mdi-keyboard-backspace text-white"></i>Back</a>
                            </div>

                            <img src="<?= base_url('images/agent/') . $agent['image'] ?>">
                            <p class="name"><?= $agent['nama_lengkap'] ?></p>
                            <h4 class="text-center text-primary">
                                <i class="mdi mdi-wallet mr-1 text-primary "></i>Wallet
                            </h4>
                            <!-- <p class="text-center"><?= $currency['app_currency'] ?>
                                <?= number_format($agent['saldo'], 0, ".", ".") ?>
                            </p> -->

                            <a class="d-block text-center text-dark" href="#">id card :
                                <?= $agent['nik'] ?></a>
                            <a class="d-block text-center text-dark" href="#"><?= $agent['email'] ?></a>
                            <a class="d-block text-center text-dark" href="#">0<?= $agent['phone'] ?></a>

                        </div>
                    </div>
                </div>
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body overview">
                            <ul class="achivements">
                                <li>
                                    <p class="text-success">Status</p>
                                    <?php
                                    if ($agent['status'] == 'A') {
                                        $status = 'Aktif';
                                    } else {
                                        $status = 'Non Aktif';
                                    }
                                    ?>
                                    <p><?= $status ?></p>
                                </li>
                            </ul>
                            <?php if ($agent['status'] == 'A') { ?>
                                <a class="d-block text-center" href=" <?= base_url(); ?>agent/changestatus/<?= $agent['id'] ?>"> <button class="btn btn-outline-primary mr-2">Change Status</button>
                                </a>
                            <?php } ?>

                            <div class="wrapper about-user">
                                <h4 class="card-title mt-4 mb-3">Address</h4>
                                <p><?= $agent['alamat'] . ' ' . strtolower('Kel. ' . $agent['village_name'] . ', ' . 'Kec. ' . $agent['district_name'] . ', ' . $agent['regency_name'] . ', ' . $agent['province_name']) ?></p>
                            </div>
                            <!-- <div class="info-links">
                                <i class="mdi mdi-update text-gray">Update On
                                </i>
                                <p><?= $agent['update_at'] ?></p>
                                <i class="mdi mdi-account-check text-gray">Created On:
                                </i>
                                <p><?= $agent['created_at'] ?></p>
                                <i class="mdi mdi-calendar text-gray">Date Of Birth:
                                </i>
                                <p><?= $agent['tgl_lahir'] ?></p>
                            </div> -->
                            <br>
                            <!-- <div class="row">
                                <span class="col-4 text-center">Job Type<p class=" text-danger text-center"><?= $agent['driver_job'] ?></p>
                                </span>
                                <span class="col-4 text-center">Vehicle<p class=" text-danger text-center"><?= $agent['merek'] ?>
                                        <?= $agent['tipe'] ?>
                                        <?= $agent['warna'] ?></p>
                                </span>
                                <span class="col-4 text-center">No.Vechile<p class=" text-danger text-center"><?= $agent['nomor_kendaraan'] ?></p>
                                </span>
                            </div> -->
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
                        <h4 class="card-title mb-0">Agent Detail</h4>
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
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="komisi-tab" data-toggle="tab" href="#komisi" role="tab" aria-controls="komisi">Komisi</a>
                            </li> -->
                        </ul>
                    </div>
                    <div class="wrapper">

                        <hr>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('agent/ubahinfo'); ?>
                                <input type="hidden" name="id" value="<?= $agent['id'] ?>">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $agent['nama_lengkap'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Pengguna</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $agent['user_name'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $agent['email'] ?>" placeholder="Change email address" required>
                                </div>
                                <label class="text-small">No Hp</label>
                                <div class="row">
                                    <div class="form-group col-2">
                                        <input type="tel" id="txtPhone" class="form-control" name="countrycode" value="<?= $agent['countryCode'] ?>" required>
                                    </div>
                                    <div class=" form-group col-10">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $agent['phone'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="province">Provinsi</label>
                                    <select id="province" class="js-example-basic-single" style="width:100%" name="province">
                                        <option value="0">Pilih Provinsi</option>
                                        <?php foreach ($prov as $pv) : ?>
                                            <option value="<?= $pv['id'] ?>" <?= $pv['id'] == $agent['province_id'] ? 'selected' : '' ?>><?= $pv['name'] ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="regency">Kota / Kabupaten</label>
                                    <select id="regency" class="js-example-basic-single regency" style="width:100%" name="regency">
                                        <option value="0">Pilih Kota / Kabupaten</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="district">Kecamatan</label>
                                    <select id="district" class="js-example-basic-single district" style="width:100%" name="district">
                                        <option value="0">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="village">Kelurahan / Desa</label>
                                    <select id="village" class="js-example-basic-single village" style="width:100%" name="village">
                                        <option value="0">Pilih Kelurahan / Desa</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="alamat" class="form-control" id="alamat" name="alamat" value="<?= $agent['alamat'] ?>" placeholder="Change address" required>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                <?= form_open_multipart('agent/ubahfoto'); ?>
                                <input type="hidden" name="id" value="<?= $agent['id'] ?>">
                                <input type="file" name="image" class="dropify" data-max-file-size="1mb" data-default-file="<?= base_url('images/agent/') . $agent['image'] ?>" />
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <?= form_open_multipart('agent/ubahpassword'); ?>
                                <input type="hidden" name="id" value="<?= $agent['id'] ?>">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="new-password" name="password" placeholder="Enter you new password" required>
                                </div>
                                <div class="form-group mt-5">
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                <?= form_close(); ?>
                            </div>

                            <!-- <div class="tab-pane fade" id="komisi" role="tabpanel" aria-labelledby="komisi-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing2" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Date</th>
                                                        <th>No Rekening</th>
                                                        <th>Jumlah</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <pre>
                                                        <?php print_r($komisi) ?>
                                                    </pre>
                                                    <?php $i = 1;
                                                    foreach ($komisi as $km) { ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= $km['waktu'] ?></td>
                                                            <td><?= $km['no_rekening'] ?></td>
                                                            <td class="text-success">
                                                                <?= $duit ?>
                                                                <?= number_format($km['jumlah'], 0, ".", ".") ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($km['status'] == 'P') { ?>
                                                                    <label class="badge badge-primary">Paid</label>
                                                                <?php } else { ?>
                                                                    <label class="badge badge-success">Unpaid</label>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div> -->
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
        var code = "<?= $agent['countryCode'] ?>"; // Assigning value from model.
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


<script>
    $(document).ready(function() {
        $('#province').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_regency",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.regency').html(html);
                    // <option value="{{ $b->ref_bank_id }}" {{ $b->ref_bank_id == $edit->ref_bank_id ? 'selected' : '' }}>
                    //                             {{ $b->ref_bank_name }}
                    //                         </option>

                }
            });
        });

        $('#regency').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_district",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.district').html(html);

                }
            });
        });

        $('#district').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_village",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.village').html(html);

                }
            });
        });
    });
</script>