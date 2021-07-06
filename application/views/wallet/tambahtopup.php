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
                    <h4 class="card-title">Manual Top Up</h4>
                    <?= form_open_multipart('wallet/tambahtopup'); ?>



                    <div class="form-group">
                        <label for="type">User Type</label>
                        <select id="getFname" onchange="admSelectCheck(this);" class="js-example-basic-single" style="width:100%" name="type_user">
                            <option id="pelanggan" value="pelanggan">USER</option>
                            <option id="driver" value="driver">DRIVER</option>
                            <option id="mitra" value="mitra">MERCHANT</option>
                        </select>
                    </div>

                    <div id="pelanggancheck" style="display:block;" class="form-group">
                        <label for="id_Pelanggan">Users</label>
                        <select class="js-example-basic-single" style="width:100%" name="id_pelanggan">
                            <?php foreach ($saldo as $sl) {
                                if (substr($sl['id_user'], 0, 1) == 'P') { ?>
                                    <option value="<?= $sl['id_user'] ?>"><?= $sl['fullnama'] ?> (<?= $currency['duit'] ?><?= number_format($sl['saldo'] ,0, ".", ".") ?>)</option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div id="drivercheck" style="display:none;" class="form-group">
                        <label for="id_driver">Drivers</label>
                        <select class="js-example-basic-single" style="width:100%" name="id_driver">
                            <?php foreach ($saldo as $sl) {
                                if (substr($sl['id_user'], 0, 1) == 'D') { ?>
                                    <option value="<?= $sl['id_user'] ?>"><?= $sl['nama_driver'] ?> (<?= $currency['duit'] ?><?= number_format($sl['saldo'] ,0, ".", ".") ?>)
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div id="mitracheck" style="display:none;" class="form-group">
                        <label for="id_mitra">Owners</label>
                        <select class="js-example-basic-single" style="width:100%" name="id_mitra">
                            <?php foreach ($saldo as $sl) {
                                if (substr($sl['id_user'], 0, 1) == 'M') { ?>
                                    <option value="<?= $sl['id_user'] ?>"><?= $sl['nama_mitra'] ?> (<?= $currency['duit'] ?><?= number_format($sl['saldo'] ,0, ".", ".") ?>)
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="saldo">Amount</label>
                        <input type="text"  class="form-control" id="saldo" name="saldo" placeholder="enter Amount" value="">
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a class="btn btn-danger text-white" href="<?= base_url(); ?>wallet">Cancel</a>
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
            pelangganValue = document.getElementById("pelanggan").value;
            driverValue = document.getElementById("driver").value;
            mitraValue = document.getElementById("mitra").value;
            console.log(mitraValue);
            if (pelangganValue == nameSelect.value) {
                document.getElementById("pelanggancheck").style.display = "block";
                document.getElementById("drivercheck").style.display = "none";
                document.getElementById("mitracheck").style.display = "none";

            } else if (driverValue == nameSelect.value) {
                document.getElementById("drivercheck").style.display = "block";
                document.getElementById("pelanggancheck").style.display = "none";
                document.getElementById("mitracheck").style.display = "none";
            } else if (mitraValue == nameSelect.value) {
                document.getElementById("mitracheck").style.display = "block";
                document.getElementById("drivercheck").style.display = "none";
                document.getElementById("pelanggancheck").style.display = "none";

            } else {
                document.getElementById("pelanggancheck").style.display = "block";
            }
        }
    }
</script>