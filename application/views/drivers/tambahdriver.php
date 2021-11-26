<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="row ">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Driver</h4>
                    <?php if (validation_errors() or $this->session->flashdata()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors() ?>
                            <?php echo $this->session->flashdata('invalid'); ?>
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <?= form_open_multipart('driver/tambah'); ?>
                    <br>
                    <h6 class="card-title">Informasi Driver</h6>
                    <div class="form-group">
                        <label>Foto Driver</label>
                        <input type="file" name="foto" class="dropify" data-max-file-size="3mb" required />
                    </div>
                    <div class="form-group">
                        <label for="nama_driver">Nama Driver</label>
                        <input type="text" class="form-control" id="nama_driver" name="nama_driver" <?php if ($_POST != NULL) { ?> value="<?= $_POST['nama_driver']; ?>" <?php } ?> placeholder="masukan nama lengkap driver" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <select class="js-example-basic-single" style="width:100%" name="gender">
                            <option value="2" <?php
                                                if ($_POST != NULL) {
                                                    if ($_POST['gender'] == '2') {
                                                ?>selected<?php }
                                                    } ?>>Laki-Laki</option>
                            <option value="1" <?php
                                                if ($_POST != NULL) {
                                                    if ($_POST['gender'] == '1') {
                                                ?>selected<?php }
                                                    } ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" <?php if ($_POST != NULL) { ?> value="<?= $_POST['tgl_lahir']; ?>" <?php } ?> placeholder="masukan tanggal lahir driver " required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" <?php if ($_POST != NULL) { ?> value="<?= $_POST['email']; ?>" <?php } ?> placeholder="masukkan alamat email " required>
                    </div>

                    <label class="text-small">Nomer Telpon</label>
                    <div class="row">

                        <div class="form-group col-2">
                            <input type="tel" id="txtPhone" class="form-control" name="countrycode" <?php if ($_POST != NULL) { ?> value="<?= $_POST['countrycode']; ?>" <?php } ?> required>
                        </div>
                        <div class=" form-group col-10">
                            <input type="text" class="form-control" id="phone" name="phone" <?php if ($_POST != NULL) { ?> value="<?= $_POST['phone']; ?>" <?php } ?> placeholder="masukkan nomer telpon driver" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat sesuai KTP</label>
                        <textarea name="alamat_driver" rows="6" class="form-control" required><?php if ($_POST != NULL) {
                                                                                                    echo $_POST['alamat_driver']; ?>" <?php } ?></textarea>
                    </div>
                    <br>

                    <h6 class="card-title">Jenis Mitra & Data Kendaraan</h6>

                    <div class="form-group">
                        <label for="Job Service">Jenis Mitra</label>
                        <select class="js-example-basic-single" name="job" style="width:100%">
                            <?php foreach ($driverjob as $drj) { ?>
                                <option value="<?= $drj['id'] ?>"><?= $drj['driver_job'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="brand">Merek Kendaraan</label>
                        <input type="text" class="form-control" name="merek" id="brand" <?php if ($_POST != NULL) { ?> value="<?= $_POST['merek']; ?>" <?php } ?> placeholder="masukan merk kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="variantvehicle">Tipe Kendaraan</label>
                        <input type="text" class="form-control" name="tipe" id="variantvehicle" <?php if ($_POST != NULL) { ?> value="<?= $_POST['tipe']; ?>" <?php } ?> placeholder="masukan tipe kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="vehiclecolor">Warna Kendaraan</label>
                        <input type="text" class="form-control" name="warna" id="vehiclecolor" <?php if ($_POST != NULL) { ?> value="<?= $_POST['warna']; ?>" <?php } ?> placeholder="masukan warna kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicleregistration">Nomor Polisi Kendaraan</label>
                        <input type="text" class="form-control" name="nomor_kendaraan" id="vehicleregistration" <?php if ($_POST != NULL) { ?> value="<?= $_POST['nomor_kendaraan']; ?>" <?php } ?> placeholder="masukan nomor polisi kendaraan" required>
                    </div>
                    <br>

                    <h6 class="card-title">Dokumen Identitas</h6>

                    <div class="form-group">
                        <label for="idcard">Nomor KTP Driver</label>
                        <input type="text" class="form-control" name="no_ktp" <?php if ($_POST != NULL) { ?> value="<?= $_POST['no_ktp']; ?>" <?php } ?> placeholder="masukkan nomor KTP/ paspor driver" required>
                    </div>

                    <div>
                        <label>Foto KTP Driver</label>
                        <input type="file" class="dropify" name="foto_ktp" data-max-file-size="3mb" required />
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="idcard">Nomer SIM</label>
                        <input type="text" class="form-control" name="id_sim" <?php if ($_POST != NULL) { ?> value="<?= $_POST['id_sim']; ?>" <?php } ?> placeholder="masukan nomor sim driver " required>
                    </div>
                    <div>
                        <label>Foto SIM</label>
                        <input type="file" class="dropify" name="foto_sim" data-max-file-size="3mb" required />
                    </div>
                    <br>



                    <button type="submit" class="btn btn-success mr-2">Daftar</button>
                    <button class="btn btn-light">Batal</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var code = "+62"; // Assigning value from model.
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
<!-- end of content wrapper -->