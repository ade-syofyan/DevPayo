<!-- partial -->
<div class="content-wrapper">
    <div class="row justify-content-md-center">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <h4 class="card-title">Add Promo Code</h4>
                    <?= form_open_multipart('promocode/addpromocode'); ?>

                    <div class="form-group">
                        <input type="file" class="dropify" name="image_promo" data-max-file-size="3mb" required />
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Promo Title</label>
                        <input type="text" class="form-control" id="nama_promo" name="nama_promo" placeholder="promo title" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Kode Promo</label>
                        <input type="text" class="form-control" id="kode_promo" name="kode_promo" placeholder="enter promo code" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Tipe Promo</label>
                        <select class="js-example-basic-single" onchange="admSelectCheck(this);"  name="type_promo" style="width:100%">
                            <option id="persen" value="persen">Persentase</option>
                            <option id="fix" value="fix">Fix</option>
                        </select>
                    </div>
                    <div id="persencheck" class="form-group" style="display:block;">
                        <label>Persentase Jumlah Promo</label>
                        <input id="persencheckrequired" type="text" class="form-control" id="nominal_promo" name="nominal_promo_persen" placeholder="enter promo amount" required>
                    </div>
                    <div id="fixcheck" class="form-group" style="display:none;">
                        <label>Perbaiki Jumlah Promo</label>
                        <input id="fixcheckrequired" type="text"  class="form-control" id="nominal_promo" name="nominal_promo" placeholder="enter promo amount">
                    </div>
                    
                    <div class="form-group">
                        <label for="birthdate">Exp On</label>
                        <input type="date" class="form-control" id="expired" name="expired" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Service</label>
                        <select class="js-example-basic-single" name="fitur" style="width:100%">
                        <?php foreach ($fitur as $ft) { ?>
                                <option value="<?= $ft['id_fitur'] ?>"><?= $ft['fitur'] ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="gender">status</label>
                        <select class="js-example-basic-single" name="status" style="width:100%">
                            <option value="1">Active</option>
                            <option value="0">Nonactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a class="btn btn-danger text-white" href="<?= base_url(); ?>promocode">Cancel</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function admSelectCheck(nameSelect) {
        console.log(nameSelect);
        if (nameSelect) {
            serviceValue = document.getElementById("persen").value;
            linkValue = document.getElementById("fix").value;
            if (serviceValue == nameSelect.value) {
                document.getElementById("persencheckrequired").required = true;
                document.getElementById("fixcheckrequired").required = false;
                document.getElementById("persencheck").style.display = "block";
                document.getElementById("fixcheck").style.display = "none";
            } else if (linkValue == nameSelect.value) {
                document.getElementById("fixcheckrequired").required = true;
                document.getElementById("persencheckrequired").required = false;
                document.getElementById("fixcheck").style.display = "block";
                document.getElementById("persencheck").style.display = "none";
            }
        } else {
            document.getElementById("persencheck").style.display = "block";
        }
    }
</script>