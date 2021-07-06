<!-- partial -->
<div class="content-wrapper">
  <div class="row ">
    <div class="col-md-8 offset-md-2 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata()) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $this->session->flashdata('demo'); ?>
            </div>
          <?php endif; ?>
          <h4 class="card-title">News form</h4>
          <?= form_open_multipart('news/ubah/' . $news['id_berita']); ?>
          <div class="form-group">
            <input type="hidden" class="form-control" name="id_berita" id="newstitle" value="<?= $news['id_berita'] ?>">
            <div class="form-group">
              <label>News Image</label>
              <input type="file" class="dropify" name="foto_berita" data-max-file-size="3mb" data-default-file="<?= base_url('images/berita/') . $news['foto_berita'] ?>" />
            </div>
            <div class="form-group">
              <label for="newstitle">Title</label>
              <input type="text" class="form-control" name="title" id="newstitle" value="<?= $news['title'] ?>" required>
            </div>
            <div class="form-group">
              <label for="newscategory">News Category</label>
              <select class="js-example-basic-single" style="width:100%" name="id_kategori">
                <?php foreach ($knews as $nw) { ?>


                  <option value="<?= $nw['id_kategori_news'] ?>" <?php if ($nw['id_kategori_news'] == $news['id_kategori']) { ?>selected<?php } ?>> <?= $nw['kategori'] ?></option>

                <?php } ?>

              </select>
            </div>
            <div class="form-group">
              <label for="newscategory">News Status</label>
              <select class="js-example-basic-single" style="width:100%" name="status_berita">

                <option value="1" <?php if ($news['status_berita'] == '1') { ?>selected<?php } ?>>Active</option>
                <option value="2" <?php if ($news['status_berita'] == '2') { ?>selected<?php } ?>>NonActive</option>

              </select>
            </div>
            <div class="form-group">
              <label for="newscontent">News Content</label>
              <textarea type="text" class="form-control" id="summernoteExample1" placeholder="Location" name="content" required><?= $news['content'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-success mr-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of content wrapper -->