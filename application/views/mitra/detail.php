<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places">
</script>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=<?= google_maps_api ?>&sensor=false&libraries=places'></script>
<script src="<?= base_url(); ?>asset/js/locationpicker.jquery.js"></script>


<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-4 side-left d-flex align-items-stretch">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <div class="row">
                                <h4 class="col-auto mr-auto card-title">Owners Info</h4>
                                <a class="col-auto btn btn-danger text-white" href="<?= base_url(); ?>mitra">
                                    <i class="mdi mdi-keyboard-backspace text-white"></i>Back</a>
                            </div>
                            <p class="name"><?= $mitra['nama_mitra'] ?></p>
                            <h4 class="text-center text-primary">
                                <i class="mdi mdi-wallet mr-1 text-primary "></i>Wallet</h4>
                            <p class="text-center"><?= $currency['app_currency'] ?>
                                <?= number_format($mitra['saldo'] ,0, ".", ".") ?></p>
                            <div class="info-links">
                                <i class="mdi mdi-account-box-outline text-gray mr-2">type Of IDcard :
                                </i>
                                <p><?= $mitra['jenis_identitas_mitra'] ?></p>
                                <i class="mdi mdi-numeric text-gray"> Number Of IDcard :
                                </i>
                                <p><?= $mitra['nomor_identitas_mitra'] ?></p>
                                <i class="mdi mdi-home-outline text-gray"> Address :
                                </i>
                                <p><?= $mitra['alamat_mitra'] ?></p>
                                <i class="mdi mdi-email-outline text-gray"> Email :
                                </i>
                                <p><?= $mitra['email_mitra'] ?></p>
                                <i class="mdi mdi-phone text-gray"> Phone
                                </i>
                                <p><?= $mitra['telepon_mitra'] ?></p>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body overview">
                            <h4 class="col-auto mr-auto card-title">Merchant Info</h4>
                            <ul class="achivements">
                                <li>
                                    <p class="text-success">Service</p>
                                    <p><?= $mitra['fitur'] ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Category</p>
                                    <p><?= $mitra['nama_kategori'] ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Order</p>
                                    <p><?= $countorder ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Status</p>
                                    <p>
                                        <?php if ($mitra['status_mitra'] == 3) {
                                            echo 'Banned';
                                        } elseif ($mitra['status_mitra'] == 0) {
                                            echo 'New Reg';
                                        } else {
                                            if ($mitra['status_merchant'] == 1) {
                                                echo 'Active';
                                            }
                                            if ($mitra['status_merchant'] == 0) {
                                                echo 'NonActive';
                                            }
                                        } ?>
                                    </p>
                                </li>
                            </ul>
                            <div class="card-body avatar">
                                <p class="name"><?= $mitra['nama_merchant'] ?></p>
                                <img src="<?= base_url('images/merchant/') . $mitra['foto_merchant'] ?>">
                                <div class="info-links">
                                    <i class="mdi mdi-store text-gray"> Address</i>
                                    <p><?= $mitra['alamat_merchant'] ?></p>
                                    <i class="mdi mdi-phone text-gray"> Phone</i>
                                    <p><?= $mitra['telepon_mitra'] ?></p>
                                    <i class="mdi mdi-update text-gray"> Open</i>
                                    <p><?= $mitra['jam_buka'] ?></p>
                                    <i class="mdi mdi-update text-gray"> Close</i>
                                    <p><?= $mitra['jam_tutup'] ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">

                <div class="card-body">
                    <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus') or $this->session->flashdata('gagal')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                            <?php echo $this->session->flashdata('hapus'); ?>
                            <?php echo $this->session->flashdata('gagal'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('tambah') or $this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('tambah'); ?>
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Detail Merchant</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="mitra-tab" data-toggle="tab" href="#mitra" role="tab" aria-controls="mitra">Owners</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="merchant-tab" data-toggle="tab" href="#merchant" role="tab" aria-controls="merchant">Merchant</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="item-tab" data-toggle="tab" href="#item" role="tab" aria-controls="item" aria-expanded="true">Menus</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="transactionhistory-tab" data-toggle="tab" href="#transactionhistory" role="tab" aria-controls="transactionhistory">Transaction History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet">Wallet</a>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <!-- tab mulai -->
                        <div class="tab-content" id="myTabContent">
                            <!-- tab item aktif mulai -->
                            <div class="tab-pane fade " id="item" role="tabpanel" aria-labelledby="item">
                                <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">


                                    <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab2" role="tablist">
                                        <li class="nav-item ">
                                            <a class="nav-link active" id="kategori-tab" data-toggle="tab" href="#kategori" role="tab" aria-controls="kategori">Category Menus</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="add-tab" data-toggle="tab" href="#add" role="tab" aria-controls="add" aria-expanded="true">Add menus</a>
                                        </li>
                                        <?php foreach ($itemk as $itk) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="<?= $itk['nama_kategori_item'] ?>-tab" data-toggle="tab" href="#<?= $itk['nama_kategori_item'] ?>" role="tab" aria-controls="<?= $itk['nama_kategori_item'] ?>"><?= $itk['nama_kategori_item'] ?></a>
                                            </li>
                                        <?php } ?>

                                </div>
                                <div class="wrapper">
                                    <hr>
                                    <div class="tab-content" id="myTab2Content">
                                        <div class="tab-pane show active" id="kategori" role="tabpanel" aria-labelledby="kategori">
                                            <button id="tomboltambah" class="btn btn-info">
                                                <i class="mdi mdi-plus-circle-outline"></i>Add Category
                                            </button>
                                            <br>
                                            <br>

                                            <div id="tambahcategory"></div>
                                            <br>
                                            <div id="editcategory" style="display:none;">
                                                <?= form_open_multipart('mitra/ubahcategoryitem'); ?>
                                                <input type="hidden" class="form-control" name="id_mitra" value="<?= $mitra['id_mitra'] ?>">
                                                <input type="hidden" id="foridkat" class="form-control" name="id_kategori_item" value="">
                                                <h4 class="card-title">Edit Menus Category</h4>
                                                <div class="form-group">
                                                    <label for="nama">Category Name</label>
                                                    <input type="text" class="form-control" id="fornamkat" name="nama_kategori_item" value"" required>
                                                </div>
                                                <div class="row">
                                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                                    <?= form_close(); ?>
                                                    <span onclick="kembalikan()" class="btn btn-secondary mr-2">cancel</span>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <h4 id="jumlah" style=display:none;><?= count($itemk) ?></h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive">

                                                        <table id="order-listing4" class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Category Name</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 1;
                                                                foreach ($itemk as $itkate) { ?>
                                                                    <h4 id="idkat<?= $i ?>" style=display:none;><?= $itkate['id_kategori_item'] ?></h4>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td id="namkat<?= $i ?>"><?= $itkate['nama_kategori_item'] ?></td>
                                                                        <td>
                                                                            <button class="btn btn-outline-primary" onclick="tombedit(<?= $i ?>);">Edit</button>
                                                                            <a href="<?= base_url(); ?>mitra/hapuscategoryitem/<?= $itkate['id_kategori_item']; ?>" onclick="return confirm ('are you sure?')">
                                                                                <button class="btn btn-outline-danger">Delete</button></a>
                                                                        </td>
                                                                    <?php $i++;
                                                                } ?>
                                                                    </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="add" role="tabpanel" aria-labelledby="add">
                                            <?= form_open_multipart('mitra/tambahitem'); ?>
                                            <input type="hidden" class="form-control" name="id_merchant" value="<?= $mitra['id_merchant'] ?>">
                                            <input type="hidden" class="form-control" name="id_mitra" value="<?= $mitra['id_mitra'] ?>">
                                            <div class="form-group">
                                                <label for="name">Menus Name</label>
                                                <input type="text" class="form-control" id="name" name="nama_item" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" class="dropify" name="foto_item" data-max-file-size="3mb" required />
                                            </div>
                                            <div class="form-group">
                                                <label>Category Menus</label>
                                                <select class="js-example-basic-single" style="width:100%" name="kategori_item">
                                                    <?php foreach ($itemk as $itk) { ?>
                                                        <option value="<?= $itk['id_kategori_item'] ?>"><?= $itk['nama_kategori_item'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="desk">Description</label>
                                                <input type="text" class="form-control" id="desk" name="deskripsi_item">
                                            </div>
                                            <div class="form-group">
                                                <label for="Hargaitem">Price(<?= $currency['app_currency'] ?>)</label>
                                                <input type="text"  class="form-control" id="Hargaitem" name="harga_item" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label>Is Promo</label>
                                                        <select id="getname" onchange="admSelectCheck(this);" class="js-example-basic-single" style="width:100%" name="status_promo">
                                                            <option id="yes" value="1">Yes</option>
                                                            <option id="no" value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div id="yescheck" style="display:block;" class="form-group">
                                                        <label for="yes">Promo Price(<?= $currency['app_currency'] ?>)</label>
                                                        <input type="text"  class="form-control" id="yes" name="harga_promo">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label>Status Menus</label>
                                                <select class="js-example-basic-single" style="width:100%" name="status_item">
                                                    <option value="1">Active</option>
                                                    <option value="0">NonActive</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
                                        </div>
                                        <?php $index = 5;
                                        foreach ($itemk as $itk) { ?>
                                            <div class="tab-pane fade" id="<?= $itk['nama_kategori_item'] ?>" role="tabpanel" aria-labelledby="<?= $itk['nama_kategori_item'] ?>">

                                                <div class="table-responsive">
                                                    <table id="order-listing<?= $index ?>" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Menus Pic</th>
                                                                <th>Menus Name</th>
                                                                <th>Price</th>
                                                                <th>Promo Price</th>
                                                                <th>status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($item as $it) {
                                                                if ($itk['id_kategori_item'] == $it['kategori_item']) { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><img src="<?= base_url('images/itemmerchant/') . $it['foto_item']; ?>"></td>
                                                                        <td id="namaitem<?= $i ?>"><?= $it['nama_item'] ?></td>
                                                                        <?php if ($it['status_promo'] == 0) { ?>
                                                                            <td><?= $currency['app_currency'] ?><?= number_format($it['harga_item'] ,0, ".", ".") ?></td>
                                                                        <?php } else { ?>
                                                                            <td style="text-decoration: line-through;"><?= $currency['app_currency'] ?><?= number_format($it['harga_item'] ,0, ".", ".") ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($it['status_promo'] == 1) { ?>
                                                                            <td class="text-success"><?= $currency['app_currency'] ?><?= number_format($it['harga_promo'] ,0, ".", ".") ?></td>
                                                                        <?php } else { ?>
                                                                            <td><label class="badge badge-danger">Not Promo</label></td>
                                                                        <?php } ?>
                                                                        <?php if ($it['status_item'] == 1) { ?>
                                                                            <td><label class="badge badge-primary">Active</label></td>
                                                                        <?php } else { ?>
                                                                            <td><label class="badge badge-danger">Non Active</label></td>
                                                                        <?php } ?>
                                                                        <td>

                                                                            <a class="btn btn-outline-primary text-red mr-2" href=" <?= base_url(); ?>mitra/edititem/<?= $it['id_item'] ?>">
                                                                                Edit</a>
                                                                            <a class="btn btn-outline-danger text-red mr-2" onclick="return confirm ('Are You Sure Want To Delete This Item?')" href=" <?= base_url(); ?>mitra/hapusitem/<?= $it['id_item'] ?>">
                                                                                Delete</a>
                                                                        </td>
                                                                <?php }
                                                                $i++;
                                                            } ?>
                                                                    </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- End -->
                                            </div>
                                        <?php $index++;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="merchant" role="tabpanel" aria-labelledby="merchant">
                                <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                                    <h4 class="card-title mb-0">Merchant</h4>
                                    <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-expanded="true">Merchant Detail</a>
                                        </li>

                                </div>
                                <div class="wrapper">
                                    <hr>
                                    <div class="tab-content" id="myTab3Content">
                                        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail">
                                            <?= form_open_multipart('mitra/ubahmerchant/' . $mitra['id_mitra']); ?>
                                            <input type="hidden" name="id_merchant" value='<?= $mitra['id_merchant'] ?>'>


                                            <div class="form-group">
                                                <input type="file" class="dropify" name="foto_merchant" data-max-file-size="3mb" data-default-file="<?= base_url('images/merchant/') . $mitra['foto_merchant'] ?>" />
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <label class=mt-2 for="name">Merchant Name</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="name" name="nama_merchant" value="<?= $mitra['nama_merchant'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <label class=mt-2 for="ftr">Service</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <select class=" js-example-basic-single fiturService" style="width:100%" name="id_fitur">
                                                        <?php foreach ($fitur as $ftr) { ?>
                                                            <option id="<?= $ftr['fitur'] ?>" value="<?= $ftr['id_fitur'] ?>" <?php if ($mitra['id_fitur'] == $ftr['id_fitur']) { ?>selected<?php } ?>><?= $ftr['fitur'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <label class=mt-2 for="ftr">Category Service</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <select class="js-example-basic-single" style="width:100%" name="category_merchant">
                                                        <?php foreach ($merchantk as $mck) { ?>
                                                            <option value="<?= $mck['id_kategori_merchant'] ?>" <?php if ($mck['id_kategori_merchant'] == $mitra['category_merchant']) { ?>selected<?php } ?>><?= $mck['nama_kategori'] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="alamat_merchant" id="us3-address" />
                                            </div>
                                            <div class="form-group">
                                                <div id="us3" style="width: 100%; height: 400px;"></div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col">
                                                    <label>Latitude</label>
                                                    <input type="text" name="latitude_merchant" id="us3-lat" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label>Longitude</label>
                                                    <input type="text" name="longitude_merchant" id="us3-lon" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <label class=mt-2 for="op">Open</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="time" class="form-control" id="op" name="jam_buka" value="<?= $mitra['jam_buka'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-3">
                                                    <label class=mt-2 for="cl">Close</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="time" class="form-control" id="cl" name="jam_tutup" value="<?= $mitra['jam_tutup'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-10">
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="submit" class="btn btn-success ">Update</button>
                                                </div>
                                            </div>


                                            <?= form_close(); ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane show active" id="mitra" role="tabpanel" aria-labelledby="mitra">
                                <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
                                    <h4 class="card-title mb-0">Owners</h4>
                                    <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab4" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="mitdeta-tab" data-toggle="tab" href="#mitdeta" role="tab" aria-controls="mitdeta" aria-expanded="true">Detail</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="mitfil-tab" data-toggle="tab" href="#mitfil" role="tab" aria-controls="mitfil">files</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="mitpass-tab" data-toggle="tab" href="#mitpass" role="tab" aria-controls="mitpass">Password</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="mitdeta" role="tabpanel" aria-labelledby="mitdeta">
                                        <?= form_open_multipart('mitra/editmitradetail'); ?>
                                        <input type="hidden" class="form-control" name="id_mitra" value="<?= $mitra['id_mitra'] ?>">
                                        <input type="hidden" class="form-control" name="id_merchant" value="<?= $mitra['id_merchant'] ?>">
                                        <div class="form-group">
                                            <label for="name">Mitra Name</label>
                                            <input type="text" class="form-control" id="name" name="nama_mitra" value="<?= $mitra['nama_mitra'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class=mt-2 for="ftr">Partner</label>
                                            <select id="pilih" class=" js-example-basic-single" style="width:100%" name="partner">

                                                <option id="partner" value="1" <?php if ($mitra['partner'] == 1) { ?>selected<?php } ?>>Partner</option>
                                                <option id="non" value="0" <?php if ($mitra['partner'] == 0) { ?>selected<?php } ?>>non Partner</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="alamat_mitra" value="<?= $mitra['alamat_mitra'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email_mitra" value="<?= $mitra['email_mitra'] ?>" required>
                                        </div>
                                        <label class="text-small">Phone Number</label>
                                        <div class="row">
                                            <div class="form-group col-2">
                                                <input type="tel" id="txtPhone1" class="form-control" name="country_code_mitra" value="<?= $mitra['country_code_mitra'] ?>" required>
                                            </div>
                                            <div class=" form-group col-10">
                                                <input type="text" class="form-control" name="phone_mitra" value="<?= $mitra['phone_mitra'] ?>"" required>
                                            </div>
                                        </div>
                                        <button type=" submit" class="btn btn-success mr-2">Update
                                                </button>
                                                <?= form_close(); ?>
                                            </div>
                                            <div class=" tab-pane" id="mitfil" role="tabpanel" aria-labelledby="mitfil">
                                                <?= form_open_multipart('mitra/editmitrafile'); ?>
                                                <input type="hidden" class="form-control" name="id_mitra" value="<?= $mitra['id_mitra'] ?>">
                                                <div class="form-group">
                                                    <label for="ic">Type of Id Card</label>
                                                    <input type="text" class="form-control" id="ic" name="jenis_identitas_mitra" value="<?= $mitra['jenis_identitas_mitra'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nc">Number of Id Card</label>
                                                    <input type="text" class="form-control" id="nc" name="nomor_identitas_mitra" value="<?= $mitra['nomor_identitas_mitra'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="file" class="dropify" name="foto_ktp" data-max-file-size="3mb" data-default-file="<?= base_url('images/fotoberkas/ktp/') . $mitra['foto_ktp'] ?>" />
                                                </div>
                                                <button type=" submit" class="btn btn-success mr-2">Update</button>
                                                <?= form_close(); ?>
                                            </div>
                                            <div class="tab-pane" id="mitpass" role="tabpanel" aria-labelledby="mitpass">
                                                <?= form_open_multipart('mitra/editmitrapass'); ?>
                                                <input type="hidden" class="form-control" name="id_mitra" value="<?= $mitra['id_mitra'] ?>">
                                                <div class="form-group">
                                                    <label for="ic">Type of Id Card</label>
                                                    <input type="password" class="form-control" id="ic" name="password" placeholder="Enter Your New Password" required>
                                                </div>
                                                <button type=" submit" class="btn btn-success mr-2">Update</button>
                                                <?= form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="transactionhistory" role="tabpanel" aria-labelledby="transactionhistory">
                                        <div class="table-responsive">
                                            <table id="order-listing2" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Transaction Inv</th>
                                                        <th>Date</th>
                                                        <th>Customer_name</th>
                                                        <th>Item Amount</th>
                                                        <th>Total Amount</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($transaksi as $tr) { ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td>INV-<?= $tr['id_transaksi'] ?></td>
                                                            <td><?= $tr['waktu_order'] ?></td>
                                                            <td><?= $tr['fullnama'] ?></td>
                                                            <td><?= $tr['jumlah_item'] ?></td>
                                                            <td>
                                                                <?= $currency['app_currency'] ?>
                                                                <?= number_format($tr['total_biaya'] ,0, ".", ".") ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?= base_url(); ?>dashboard/detail/<?= $tr['id_transaksi'] ?>" class="btn btn-outline-primary">View</a>
                                                            </td>
                                                        <?php $i++;
                                                    } ?>
                                                        </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                                        <div class="table-responsive">
                                            <table id="order-listing3" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Id</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($wallet as $wl) { ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><?= $wl['id']; ?></td>
                                                            <td><?= $wl['type']; ?></td>
                                                            <td><?= $wl['waktu']; ?></td>

                                                            <?php if ($wl['type'] == 'topup' or $wl['type'] == 'Order+') { ?>
                                                                <td class="text-success">
                                                                    <?= $currency['app_currency'] ?>
                                                                    <?= number_format($wl['jumlah'] ,0, ".", ".") ?>
                                                                </td>

                                                            <?php } else { ?>
                                                                <td class="text-danger">
                                                                    <?= $currency['app_currency'] ?>
                                                                    <?= number_format($wl['jumlah'] ,0, ".", ".") ?>
                                                                </td>
                                                            <?php } ?>



                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#us3').locationpicker({
        location: {
            latitude: <?= $mitra["latitude_merchant"] ?>,
            longitude: <?= $mitra["longitude_merchant"] ?>
        },
        radius: 300,
        inputBinding: {
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lon'),
            radiusInput: $('#us3-radius'),
            locationNameInput: $('#us3-address')
        },
        enableAutocomplete: true,
        onchanged: function(currentLocation, radius, isMarkerDropped) {}
    });
</script>

<script type="text/javascript">
    $(function() {
        var code = "<?= $mitra['country_code_merchant'] ?>"; // Assigning value from model.
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

<script type="text/javascript">
    $(function() {
        var code = "<?= $mitra['country_code_mitra'] ?>"; // Assigning value from model.
        $('#txtPhone1').val(code);
        $('#txtPhone1').intlTelInput({
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


<script>
    function admSelectCheck(nameSelect) {
        if (nameSelect) {
            yesValue = document.getElementById("yes").value;
            noValue = document.getElementById("no").value;
            if (yesValue == nameSelect.value) {

                document.getElementById("yescheck").required = true;
                document.getElementById("yescheck").style.display = "block";
            } else if (noValue == nameSelect.value) {

                document.getElementById("yescheck").required = false;
                document.getElementById("yescheck").style.display = "none";
            }
        } else {
            document.getElementById("yescheck").style.display = "block";
            document.getElementById("yescheck").required = true;
        }
    }

    function addform() {
        return `<?= form_open_multipart('mitra/tambahcategoryitem'); ?>
                <input type="hidden" id="valmit" class="form-control" name="id_merchant" value="<?= $mitra['id_mitra'] ?>">
                <input type="hidden" id="valmer" class="form-control" name="id_mitra" value="<?= $mitra['id_merchant'] ?>">
                <h4 class="card-title">Add Item Category</h4>
                <div class="form-group">
                    <label for="nama">Category Name</label>
                    <input type="text" class="form-control" id="nama" name="nama_kategori_item" placeholder="enter item category" required>
                </div>
                <div class="row">
                        <button id="kirimid" type="submit" class="btn btn-success mr-2">Submit</button>
                    <?= form_close(); ?>
                        <button id="andhe" class="btn btn-secondary mr-2">cancel</button>
                </div>`
    }
    const tomboltambah = document.getElementById('tomboltambah');
    tomboltambah.addEventListener('click', function() {
        const getformadd = document.getElementById('tambahcategory');
        getformadd.innerHTML = addform();
        const tombolback = document.getElementById('andhe');
        tombolback.addEventListener('click', function() {
            getformadd.innerHTML = backform();
        })
    })

    function backform() {
        return ``
    }

    const jumlah = document.getElementById("jumlah").innerHTML

    for (let i = 0; i < 20; i++) {

        function tombedit(i) {

            const namkat = document.getElementById(`namkat${i}`).innerHTML
            const idkat = document.getElementById(`idkat${i}`).innerHTML
            document.getElementById('editcategory').style = "display:block;";
            document.getElementById('fornamkat').value = namkat;
            document.getElementById('foridkat').value = idkat;
        }
    }

    function kembalikan() {
        document.getElementById('editcategory').style = "display:none;";
    }
</script>