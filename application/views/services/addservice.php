<!-- partial -->
<div class="content-wrapper">
    <div class="row ">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <?php if ($this->session->flashdata()) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $this->session->flashdata('demo'); ?>
                            </div>
                        <?php endif; ?>
                        Add Service</h4>
                    <?= form_open_multipart('services/addservice'); ?>
                    <div class="form-group">
                        <input type="file" class="dropify" name="icon" data-max-file-size="3mb" required />
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Name</label>
                        <input type="text" class="form-control" id="newstitle" name="fitur" required>
                    </div>
                    <div class="form-group">
                        <label for="newscategory">Service Type</label>
                        <select class="js-example-basic-single" name="home" style="width:100%">
                            <option value="1" >Passenger Transportation</option>
                            <option value="2" >Shipment</option>
                            <option value="3" >Rental</option>
                            <option value="4" >Purchasing Service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Price</label>
                        <input type="text"  class="form-control" id="newstitle" name="biaya"  required>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Discount (%)</label>
                        <input type="text" class="form-control" id="newstitle" name="nilai" placeholder="ex 10%">
                    </div>
                    <div class="form-group">
                        <label for="newscategory">Unit</label>
                        <select class="js-example-basic-single" name="keterangan_biaya" style="width:100%">
                            <!-- <option value="KM">Kilometers</option> -->
                            <option value="KM" >Kilometers</option>
                            <option value="Hr" >An Hour</option>
                            <!-- <option value="Hr">An Hour</option> -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Commission (%)</label>
                        <input type="text" class="form-control" id="newstitle" name="komisi" placeholder="ex 10%" required>
                    </div>
                    <div class="form-group">
                        <label for="newscategory">vechile</label>
                        <select class="js-example-basic-single" name="driver_job" style="width:100%">
                            <?php foreach ($driverjob as $drj) { ?>
                                <option value="<?= $drj['id'] ?>"><?= $drj['driver_job'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Minimum Price</label>
                        <input type="text"  class="form-control" id="newstitle" name="biaya_minimum" required>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Driver Radius</label>
                        <input type="text" class="form-control" id="newstitle" name="jarak_minimum" required>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Max Distance Order</label>
                        <input type="text" class="form-control" id="newstitle" name="maks_distance" required>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Minimum Saldo</label>
                        <input type="text"  class="form-control" id="newstitle" name="wallet_minimum" required>
                    </div>
                    <div class="form-group">
                        <label for="newstitle">Description</label>
                        <input type="text" class="form-control" id="newstitle" name="keterangan" required>
                    </div>

                    <div class="form-group">
                        <label for="newscategory">Status</label>
                        <select class="js-example-basic-single" name="active" style="width:100%">
                            <option value="0" >Nonactive</option>
                            <option value="1" >Active</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a href="<?= base_url() ?>services" class="btn btn-danger">Cancel</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of content wrapper -->