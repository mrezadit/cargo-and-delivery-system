<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Package</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Product Volume</h6>
            </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <h6 class="text-sm font-weight-bolder mb-0">Sistem Muatan dan Pengiriman</h6>
            </div>
        </div>
    </nav>
</br>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-8 pl-4">
          <div class="card">
          <div class="card-body p-3">
            <div class="card-header pb-2 p-2">
            <div class="row">
                <div class="col-8 align-items-center">
                    <span class="text-lg mb-0"><b>Package Information</b><br><p class="text-sm mb-2" >Date transaction <?= date("d-m-Y", strtotime($package['date'])); ?> </p></span>
                </div>
                <div class="col-3 text-end d-flex">
                <div class="pl-5 pr-3">
                <a href="<?= site_url('admin/package/'.$package['id_package'].'/update'); ?>" rel="tooltip" title="detail"  class="badge btn-info btn-sm mb-0">Update</a>
                </div>
                <div class="pr-3">
                <a href="<?= site_url('admin/deletepackage/'.$package['id_package']); ?>" rel="tooltip" title="detail"  class="badge btn-danger btn-sm mb-0">Delete</a>
                </div>
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md mb-md-0 mb-4">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="pl-4 d-flex flex-column">
                        <span class="mb-3 text-sm">Receipt No : <b><br><?= $package['no_package']?>  </b></span>
                        <span class="mb-3 text-sm">Customers : <b><br><?= $package['customer_name']?>  </b></span>
                    </div>
                    <div class="pl-4 d-flex flex-column">
                        <span class="mb-3 text-sm">Phone : <b><br><?= $package['phone']?>  </b></span>
                        <span class="mb-3 text-sm">Kota : <b><br><?= $package['kota']?>  </b></span>
                    </div>
                    <div class="pl-4 d-flex flex-column">
                        <span class="mb-3 text-sm">Total Berat : <b><br><?= $package['t_kg']?> kg</b></span>
                        <span class="mb-3 text-sm">Total Volume : <b> <br><?= substr($package['t_kgv'], 0, 5)?> m&sup3</b></span>
                    </div>
                    <span class="pl-4 mb-3 text-sm">Address : <b> <br> <?= $package['address']?>  </b></span>
                    </li>
                    
                </ul>
                </div>
            </div>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive p-0">
                    <table id="table-data" class="table align-items-center justify-content-center mb-0">
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Name</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Qty</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Berat</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Volume</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pl-3">
                    <?php if (!empty($v_package)) : $i = 1; foreach (array_reverse($v_package) as $value) : ?>
                        <tr>
                        <td>
                        <div class="d-flex pl-3">
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?= $i++; ?> </h6>
                            </div>
                        </div>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"> <?= $value->product_name; ?> </span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->qty; ?> Pcs</span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->t_berat; ?> Kg</span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= substr($value->t_volume, 0, 6); ?> m&sup3</span> </br>
                        </td>
                        <td class="pl-4">
                        <a href="<?= site_url('admin/deletevproduct/'.$value->id_vpackage.'/'.$value->id_package.''); ?>" rel="tooltip" title="delete" class="text-sm font-weight-bold text-danger">
                        <i class="material-icons text-sm">cancel</i> Delete</a>
                        </td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                    </table>
                </div>
                </div>
          </div>
        </div>
        <div class="col-md-4 pr-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
            <form action="<?= site_url('admin/addVolume'); ?>" method="post">
                <div class="row">
                    <div class="col-7 pl-4 align-items-center">
                    <h6 class="mb-0">Product Volume</h6>
                        <span class="text-sm mb-0">Set package volume</span>
                    </div>
                    <div class="col-3 text-end">
                        <button class="btn btn-info btn-sm mb-0">Add Volume</button>
                    </div>
                </div>
                </div>
                <div class="col-12 pt-3 pb-3">
                    <div class="card border-0 p-4 pt-0 bg-gray-100">
                        <span class="pt-3">Product</span>
                            <select name="id_product" data-style="btn btn-link" data-live-search="true" required>
                                <option disabled selected>Pilih Product</option>
                                <?php if (!empty($product)) : $i = 1; foreach ($product as $value) : ?>
                                    <option value="<?= $value->id_product; ?>"><?= $value->product_name; ?></option> 
                                <?php endforeach; endif; ?>
                            </select>  
                            <span class="pt-3">Qty</span>
                            <div class="input-group input-group-dynamic w-50">
                                <label class="form-label"></label>
                                <input type="hidden" name="id_package" value="<?= $package['id_package']?>">
                                <input type="number" name="qty" class="form-control" required>
                                <p class="text-end pt-2"></p>
                            </div>
                    </div>
                </div>
            </form>
            </div>
          </div>
      </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $("select").select2();
});
</script>