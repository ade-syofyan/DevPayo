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
                    <h4 class="card-title">Update Promo Slider</h4>
                    <?= form_open_multipart('promoslider/ubah/' . $id); ?>
                    <input type="hidden" name="id" value='<?= $id ?>'>
                    <div class="form-group">
                        <div class="form-group">
                            <input type="hidden" name=" id " value=<?= $id ?>>
                            <input type="file" class="dropify" name="foto" data-max-file-size="3mb" data-default-file="<?= base_url('images/promo/') . $foto ?>" />
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Exp On</label>
                            <input type="date" class="form-control" id="birthdate" name="tanggal_berakhir" value="<?= $tanggal_berakhir ?>">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="getFname" onchange="admSelectCheck(this);" class="js-example-basic-single" style="width:100%" name="type_promosi">
                                <option id="service" value="service" <?php if ($type_promosi == 'service') { ?>selected<?php } ?>>Service</option>
                                <option id="link" value="link" <?php if ($type_promosi == 'link') { ?>selected<?php } ?>>Link</option>
                            </select>
                        </div>

                        <?php if ($type_promosi == 'service') {  ?>
                            <div id="servicecheck" style="display:block;" class="form-group">
                                <label for="fitur_promosi">Service</label>
                                <select class="js-example-basic-single" style="width:100%" name="fitur_promosi">

                                    <?php foreach ($fitur as $ftr) { ?>
                                        <option value="<?= $ftr['id_fitur'] ?>" <?php if ($fitur_promosi == $ftr['id_fitur']) { ?>selected<?php } ?>><?= $ftr['fitur'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="linkcheck" style="display:none;" class="form-group">
                                <label for="link">Link</label>
                                <input type="text" class="form-control" id="linktes" name="link_promosi" placeholder="enter link">
                            </div>
                        <?php } else { ?>
                            <div id="servicecheck" style="display:none;" class="form-group">
                                <label for="fitur_promosi">Service</label>
                                <select class="js-example-basic-single" style="width:100%" name="fitur_promosi">
                                    <?php foreach ($fitur as $ftr) { ?>
                                        <option value="<?= $ftr['id_fitur'] ?>" <?php if ($fitur_promosi == $ftr['id_fitur']) { ?>selected<?php } ?>><?= $ftr['fitur'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div id="linkcheck" style="display:block;" class="form-group">
                                <label for="link">Link</label>
                                <input type="text" class="form-control" id="linktes" name="link_promosi" value="<?= $link_promosi ?>" required>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="gender">status</label>
                            <select class="js-example-basic-single" name="is_show" style="width:100%">
                                <option value="1">Active</option>
                                <option value="0">Nonactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-light" href="<?= base_url(); ?>promoslider/index">Cancel</a>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function admSelectCheck(nameSelect) {
        console.log(nameSelect);
        if (nameSelect) {
            serviceValue = document.getElementById("service").value;
            linkValue = document.getElementById("link").value;
            if (serviceValue == nameSelect.value) {
                document.getElementById("linktes").required = false;
                document.getElementById("servicecheck").style.display = "block";
                document.getElementById("linkcheck").style.display = "none";
            } else if (linkValue == nameSelect.value) {
                document.getElementById("linktes").required = true;
                document.getElementById("linkcheck").style.display = "block";
                document.getElementById("servicecheck").style.display = "none";
            }
        } else {
            <?php if ($type_promosi == 'service') {  ?>
                document.getElementById("linkcheck").style.display = "none";
                document.getElementById("servicecheck").style.display = "block";
            <?php } else { ?>
                document.getElementById("linkcheck").style.display = "block";
                document.getElementById("servicecheck").style.display = "none";
            <?php } ?>
        }
    }
</script>