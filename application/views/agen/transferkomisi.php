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
                    <h4 class="card-title">Transfer Komisi</h4>
                    <?= form_open_multipart('agent/transferkomisi'); ?>

                    <div id="pelanggancheck" style="display:block;" class="form-group">
                        <label for="agent">Agent</label>
                        <select class="js-example-basic-single" style="width:100%" onchange="tes(this)" name="agent" id="agent">
                            <option value="">Choose Agent</option>
                            <?php foreach ($data as $ag) : ?>
                                <option value="<?= $ag['id'] ?>"><?= $ag['nama_lengkap'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="agent">B</label>
                        <select class="js-example-basic-single" style="width:100%" onchange="tes(this)" name="agent" id="agent">
                            <option value="">Choose Agent</option>
                            <?php foreach ($data as $ag) : ?>
                                <option value="<?= $ag['id'] ?>"><?= $ag['nama_lengkap'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="nilai">Total Nilai Transaksi</label>
                        <input type="text" class="form-control" id="nilai" name="nilai" placeholder="0" disabled>
                    </div>
                    <div class="form-group">
                        <label for="fee">Fee Agent</label>
                        <input type="text" class="form-control" id="fee" name="fee" placeholder="0" disabled>
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
    function tes(id) {
        var idagent = id.value;
        // alert(idagent);
        axios.post("<?php echo base_url(); ?>index.php/Agent/get_komisi/" + idagent).then(function(res) {
            console.log(res)
            var data = res.data;
            var nilai = $('#nilai').val(rupiah(data.total));
            var total = data.total * 2 / 100;
            $('#fee').val(rupiah(total));
        })
    }
</script>