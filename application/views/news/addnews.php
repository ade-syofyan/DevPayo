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
          <?= form_open_multipart('news/tambah'); ?>

          <div class="form-group">
            <label>News Image</label>
            <input type="file" class="dropify" name="foto_berita" id="foto_berita" data-max-file-size="3mb" required />
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="enter news title" required>
          </div>
          <div class="form-group">
            <label for="id_kategori">News Category</label>
            <select class="js-example-basic-single" style="width:100%" name="id_kategori" id = "id_kategori" >
              <?php foreach ($news as $nw) { ?>
                <option value="<?= $nw['id_kategori_news'] ?>"><?= $nw['kategori'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="status_berita">News Status</label>
            <select class="js-example-basic-single" style="width:100%" name="status_berita" id="status_berita">
              <option value="1">Active</option>
              <option value="0">NonActive</option>
            </select>
          </div>
          <div class="form-group">
            <label for="newscontent">News Content</label>
            <textarea name="content" type="text" class="form-control" id="summernoteExample1" placeholder="Location" required></textarea>
          </div>
          <button type="submit" class="btn btn-success mr-2">Submit</button>
          <button class="btn btn-light">Cancel</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of content wrapper -->


