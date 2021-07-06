<!-- partial -->
<!-- $subject, $emailuser, $content, $host,$port,$username,$password,$from,$appname,$secure -->
<div class="content-wrapper">
  <div class="row ">
    <div class="col-md-8 offset-md-2 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <?php if ($this->session->flashdata('send')) : ?>
            <div class="alert alert-success" role="alert">
              <?php echo $this->session->flashdata('send'); ?>
            </div>
          <?php endif; ?>
          <?php if ($this->session->flashdata('demo')) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $this->session->flashdata('demo'); ?>
            </div>
          <?php endif; ?>
          <h4 class="card-title">Send Email</h4>
          <?= form_open_multipart('sendemail/send'); ?>

          <div class="form-group">
            <label for="newscategory">Send To</label>
            <select id="getFname" onchange="admSelectCheck(this);" class="js-example-basic-single" style="width:100%" name="sendto">
              <option id="users" value="users">Users</option>
              <option id="pengendara" value="drivers">Drivers</option>
              <option id="merchant" value="merchant">Merchant</option>
              <option id="other" value="other">Others</option>
            </select>
          </div>
          <div id="usercheck" style="display:block;" class="form-group">
            <label for="newscategory">Users</label>
            <select class="js-example-basic-single" style="width:100%" name="emailpelanggan">
              <?php foreach ($user as $us) { ?>
                <option value="<?= $us['email'] ?>"><?= $us['fullnama'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div id="drivercheck" style="display:none;" class="form-group">
            <label for="newscategory">Drivers</label>
            <select class="js-example-basic-single" style="width:100%" name="emaildriver">
              <?php foreach ($driver as $dr) { ?>
                <option value="<?= $dr['email'] ?>"><?= $dr['nama_driver'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div id="merchantcheck" style="display:none;" class="form-group">
            <label for="newscategory">Merchant</label>
            <select class="js-example-basic-single" style="width:100%" name="emailmitra">
              <?php foreach ($mitra as $mt) { ?>
                <option value="<?= $mt['email_mitra'] ?>"><?= $mt['nama_mitra'] ?></option>
              <?php } ?>
            </select>
          </div>

          <div id="othercheck" style="display:none;" class="form-group">
            <label for="newstitle">Others</label>
            <input type="email" class="form-control" id="linktes" placeholder="enter email Address" name="emailothers">
          </div>

          <div class="form-group">
            <label for="newstitle">title</label>
            <input type="text" class="form-control" id="newstitle" placeholder="enter email Address" name="subject" required>
          </div>
          <div class="form-group">
            <label for="newscontent">Email Content</label>
            <textarea type="text" class="form-control" id="summernoteExample1" placeholder="Location" name="content" required></textarea>
          </div>
          <button type="submit" class="btn btn-success">Send<i class="mdi mdi-send ml-1"></i></button>

          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end of content wrapper -->
<script>
  function admSelectCheck(nameSelect) {

    if (nameSelect) {
      userValue = document.getElementById("users").value;
      driverValue = document.getElementById("pengendara").value;
      console.log(nameSelect.value, driverValue)
      merchantValue = document.getElementById("merchant").value;
      bothValue = document.getElementById("other").value;

      if (userValue == nameSelect.value) {
        console.log(nameSelect.value, userValue)
        document.getElementById("linktes").required = false;
        document.getElementById("usercheck").style.display = "block";
        document.getElementById("merchantcheck").style.display = "none";
        document.getElementById("drivercheck").style.display = "none";
        document.getElementById("othercheck").style.display = "none";
      }
      if (nameSelect.value == driverValue) {
        console.log(nameSelect.value, driverValue)
        document.getElementById("linktes").required = false;
        document.getElementById("drivercheck").style.display = "block";
        document.getElementById("merchantcheck").style.display = "none";
        document.getElementById("usercheck").style.display = "none";
        document.getElementById("othercheck").style.display = "none";
      }
      if (merchantValue == nameSelect.value) {
        console.log(nameSelect.value, merchantValue)
        document.getElementById("linktes").required = false;
        document.getElementById("merchantcheck").style.display = "block";
        document.getElementById("drivercheck").style.display = "none";
        document.getElementById("usercheck").style.display = "none";
        document.getElementById("othercheck").style.display = "none";
      }
      if (bothValue == nameSelect.value) {
        console.log(nameSelect.value, bothValue)
        document.getElementById("linktes").required = true;
        document.getElementById("drivercheck").style.display = "none";
        document.getElementById("usercheck").style.display = "none";
        document.getElementById("merchantcheck").style.display = "none";
        document.getElementById("othercheck").style.display = "block";
      }
    } else {
      document.getElementById("usercheck").style.display = "block";
    }
  }
</script>