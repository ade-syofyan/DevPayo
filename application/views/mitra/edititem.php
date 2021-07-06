<div class="content-wrapper">
    <div class="row ">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">


                    <?= form_open_multipart('mitra/ubahitem/' . $item['id_item']); ?>
                    <input type="hidden" class="form-control" name="id_merchant" value="<?= $item['id_merchant'] ?>">

                    <div class="form-group">
                        <label for="name">Menus Name</label>
                        <input type="text" class="form-control" id="name" name="nama_item" value="<?= $item['nama_item'] ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="file" class="dropify" name="foto_item" data-max-file-size="3mb" data-default-file="<?= base_url('images/itemmerchant/') . $item['foto_item'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Category Menus</label>
                        <select class="js-example-basic-single" style="width:100%" name="kategori_item">
                            <?php foreach ($itemk as $itk) { ?>
                                <option value="<?= $itk['id_kategori_item'] ?>" <?php if ($itk['id_kategori_item'] == $item['kategori_item']) { ?>selected<?php } ?>><?= $itk['nama_kategori_item'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="desk">Description</label>
                        <input type="text" class="form-control" id="desk" name="deskripsi_item" value="<?= $item['deskripsi_item'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="Hargaitem">Price(<?= $currency['app_currency'] ?>)</label>
                        <input type="text"  class="form-control" id="Hargaitem" name="harga_item" value="<?= $item['harga_item'] ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Is Promo</label>
                                <select id="getname" onchange="admSelectCheck(this);" class="js-example-basic-single" style="width:100%" name="status_promo">
                                    <option id="yes" value="1" <?php if ($item['status_promo'] == '1') { ?>selected<?php } ?>>Yes</option>
                                    <option id="no" value="0" <?php if ($item['status_promo'] == '0') { ?>selected<?php } ?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div id="yescheck" <?php if ($item['status_promo'] == 1) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> class="form-group">
                                <label for="promo">Promo Price(<?= $currency['app_currency'] ?>)</label>
                                <input id="reqcheck" type="text" class="form-control" id="promo" name="harga_promo"  value="<?= $item['harga_promo'] ?>" required="false;">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Status Menus</label>
                        <select class="js-example-basic-single" style="width:100%" name="status_item">
                            <option value="1" <?php if ($item['status_item'] == 1) { ?>selected<?php } ?>>Active</option>
                            <option value="0" <?php if ($item['status_item'] == 0) { ?>selected<?php } ?>>NonActive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function admSelectCheck(nameSelect) {
        if (nameSelect) {
            yesValue = document.getElementById("yes").value;
            noValue = document.getElementById("no").value;

            if (yesValue == nameSelect.value) {
                document.getElementById("reqcheck").required = true;
                document.getElementById("yescheck").style.display = "block";
            } else if (noValue == nameSelect.value) {

                document.getElementById("reqcheck").required = false;
                document.getElementById("yescheck").style.display = "none";
            }
        }
    }
</script>