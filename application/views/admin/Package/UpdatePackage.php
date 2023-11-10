<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Package</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Add Package Data</h6>
            </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <h6 class="text-sm font-weight-bolder mb-0"></h6>
            </div>
        </div>
    </nav>
</br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>

<div class="d-flex justify-content-center">
    <div class="col-lg-10 col-md-12">
        <div class="card">
        <div class="card-header card-header-primary">
            <div class="row">
                <div class="col-7 align-items-center pl-4">
                    <h4 class="mb-0">Create Package Data</h4>
                    <span class="text-sm mb-0 text-end">Form to create a new package data</span>
                </div>
            </div>
            <div class="d-flex pt-4" method="post">
                <div class="col-8">
                    <div class="card border-0 d-flex p-4 pt-0 mb-2 bg-gray-100">
                    <form class="pt-4" action="<?= site_url('admin/updatePackage'); ?>" method="post">
                        <div class="row d-flex">
                            <div class="col-6">
                            <span>Customer Name</span></br>
                            <div class="input-group input-group-dynamic mb-4">
                                <label class="form-label"></label>
                                <input type="text" name="customer_name" value="<?= $detail['customer_name']?>" class="form-control">
                            </div>
                            </div>
                            <div class="col-5 pl-3">
                            <span>Phone Number</span></br>
                            <div class="input-group input-group-dynamic mb-4">
                                <label class="form-label"></label>
                                <input type="number" name="phone" value="<?= $detail['phone']?>" class="form-control">
                            </div>
                            </div>
                        </div>

                        <div class="row d-flex">
                            <div class="col-6">
                            <span>Date</span></br>
                            <div class="input-group input-group-dynamic mb-4">
                                <label class="form-label"></label>
                                <input type="date" name="date" value="<?= $detail['date']?>" class="form-control">
                            </div>
                            </div>
                            <div class="col-5 pl-3">
                                <span>Route Point</span></br>
                                <span>
                                <select name="id_kota" data-style="btn btn-link" data-live-search="true" style="width: 100%;" required>
                                    <option disabled selected>Pilih Kota</option>
                                    <?php if (!empty($kota)) : $i = 1; foreach ($kota as $value) : ?>
                                        <option value="<?= $value->id_kota; ?>" <?= $detail['id_kota'] === $value->id_kota ? 'selected' : ''; ?>><?= $value->kota; ?></option> 
                                    <?php endforeach; endif; ?>
                                </select>
                                </span>
                            </div>
                        </div>

                        <span>Address</span></br>
                        <div class="input-group input-group-dynamic mb-4">
                            <label class="form-label"></label>
                            <input type="hidden" name="id_package" value="<?= $detail['id_package']; ?>">
                            <textarea type="textarea" name="address" value="<?= $detail['address']?>" class="form-control"><?= $detail['address']?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2">
                        <span>Create and save this data?</span></br>
                    </div>
                    <div class="d-flex">
                        <div class="pt-2 pl-2">
                            <a class="btn btn-outline-dark btn-sm mb-0" href="">Back</a>
                        </div>
                        <div class="pt-2 pl-2">
                            <button class="btn btn-dark btn-sm mb-0" type="submit">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
<div>

<script type="text/javascript">
$(document).ready(function() {
  $("select").select2();
});
</script>