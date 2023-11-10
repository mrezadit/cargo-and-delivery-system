<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Capacity</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Add Capacity</h6>
            </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <h6 class="text-sm font-weight-bolder mb-0">Sistem Muatan dan Pengiriman</h6>
            </div>
        </div>
    </nav>
</br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-8">
          <div class="card">
          <div class="card-body p-3">
            <div class="card-header pb-2 p-2">
            <div class="row">
                <div class="col-6 align-items-center">
                    <span class="font-weight-bolder mb-0"><h5>Cargo Information</h5>Scheduled on <?= date('d-m-Y',strtotime ($capacity['schedule']));?></span>
                </div>
                <div class="col-3 text-end d-flex">
                <div class="pl-5 pr-3">
                <a href="<?= site_url('admin/capacity/'.$capacity['id_capacity'].'/update'); ?>" rel="tooltip" title="detail"  class="badge btn-info btn-sm mb-0">Update</a>
                </div>
                <div class="pr-3">
                <a href="<?= site_url('admin/deleteCapacity/'.$capacity['id_capacity'].''); ?>" rel="tooltip" title="detail"  class="badge btn-danger btn-sm mb-0">Delete</a>
                </div>
                <div class="pr-3">
                <a href="<?= site_url('admin/processCapacity/'.$capacity['id_capacity'].''); ?>" class="badge btn-dark mb-0">PROCESS <i class="material-icons text-sm">open_in_new</i></a>
                </div>
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md mb-md-0 mb-4">

                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <span class="mb-3 text-sm">Truck : <b><?= $capacity['truck']?>  </b></span>
                        <span class="mb-3 text-sm">Driver : <b><?= $capacity['driver']?>  </b></span>
                    </div>
                    <div class="pl-3 d-flex flex-column">
                        <span class="mb-3 text-sm">No Plat : <b><?= $capacity['no_plate']?>  </b></span>
                        <span class="mb-3 text-sm">Phone : <b><?= $capacity['phone']?>  </b></span>
                    </div>
                    <div class="pl-3 d-flex flex-column">
                        <span class="mb-3 text-sm">Berat : <b> <?= $capacity['b_capacity']?> kg / <?= $capacity['bmax']?> kg</b></span>
                        <span class="mb-3 text-sm">Volume : <b> <?= substr($capacity['r_capacity'], 0, 4)?> m&sup3 / <?= $capacity['capacity']?> m&sup3</b></span>
                    </div>
                    <div class="pl-5 d-flex flex-column">
                        <?php if ( $capacity['b_capacity'] >= $capacity['bmax'] || $capacity['r_capacity'] >= $capacity['capacity'] ) : ?>
                            <span class="mb-3 text-sm text-danger"><b> WARNING ! </b></br> Muatan melebihi</br>kapasitas</span>
                        <?php else : ?>
                    </div>
                    <?php endif ;?> 
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
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Package</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Route Point</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Berat</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Volume</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pl-3">
                    <?php if (!empty($package)) : $i = 1; foreach (array_reverse($package) as $value) : ?>
                        <tr>
                        <td>
                        <div class="d-flex pl-3">
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?= $i++; ?> </h6>
                            </div>
                        </div>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"> <?= $value->no_package; ?> - <?= $value->customer_name; ?> </span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->kota; ?></span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->t_kg; ?> kg</span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= substr($value->t_kgv, 0, 4); ?> m&sup3</span> </br>
                        </td>
                        <td class="pl-4">
                        <a href="<?= site_url('admin/deletevcapacity/'.$value->id_capacity.'/'.$value->id_package.''); ?>" rel="tooltip" title="delete" class="text-sm font-weight-bold text-danger">
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
                <div class="card-header pb-0 px-2">
                <form action="<?= site_url('admin/addCapacitys/'); ?>" method="post">
                    <div class="row">
                        <div class="col-7 pl-4 align-items-center">
                        <h6 class="mb-0">Route and Load</h6>
                            <span class="text-sm mb-0">Load by All Route Point</span>
                        </div>
                        <div class="col-3 text-end">
                            <button class="badge btn-info btn-sm mb-0">Add Volume</button>
                        </div>
                    </div>
                    </div> 
                    <div class="col-12 pt-3 pb-3">
                        <div class="card border-0 p-4 pt-0 bg-gray-100">
                        <span class="pt-3">Date</span>
                        <select name="date" id="date" data-style="btn btn-link" data-live-search="true">
                                    <option disabled selected>Pilih</option>
                                    <?php if (!empty($package2)) : $i = 1; foreach ($package2 as $value) : ?>
                                        <option value="<?= $value->date; ?>"><?= $value->date; ?></option> 
                                    <?php endforeach; endif; ?>
                        </select> 
                        <span class="pt-4">Route Point</span>
                        <select name="id_kota" id="kota" style="width: 200px;">
                            <option value="">Pilih</option>
                        </select>
                        
                        <div class="input-group input-group-dynamic w-50">
                            <label class="form-label"></label>
                            <input type="hidden" name="id_capacity" value="<?= $capacity['id_capacity']?>">
                            <p class="text-end pt-2"></p>
                        </div>
                    </div>
                </form>
                </div>
                <div class="card-header pb-0 px-2">
                <form action="<?= site_url('admin/addCapacity/'); ?>" method="post">
                    <div class="row">
                        <div class="col-7 pl-4 align-items-center">
                        <h6 class="mb-0">Package</h6>
                            <span class="text-sm mb-0">Load by Package</span>
                        </div>
                        <div class="col-3 text-end">
                            <button class="badge btn-info btn-sm mb-0">Add Package</button>
                        </div>
                    </div>
                    </div> 
                    <div class="col-12 pt-3 pb-3">
                        <div class="card border-0 p-4 pt-0 bg-gray-100">
                        <span class="pt-4">Select Package</span>
                        <select name="id_package" id="package" style="width: 200px;">
                            <option value="">Pilih</option>
                        </select>
                        <div class="input-group input-group-dynamic w-50">
                            <label class="form-label"></label>
                            <input type="hidden" name="id_capacity" value="<?= $capacity['id_capacity']?>">
                            <p class="text-end pt-2"></p>
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

<script src="<?php echo base_url("js/jquery.min.js"); ?>" type="text/javascript"></script>
	
<script>
$(document).ready(function(){ 
    $("#date").change(function(){ 

        $.ajax({
            type: "POST", 
            url: "<?php echo base_url("index.php/admin/listKota"); ?>",
            data: {date : $("#date").val()}, 
            dataType: "json",
            beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response){ 
                $("#kota").html(response.list_kota).show();
            },
            error: function (xhr, ajaxOptions, thrownError) { 
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#kota").change(function(){ 
		
        $.ajax({
            type: "POST", 
            url: "<?php echo base_url("index.php/admin/listPackage"); ?>", 
            data: {date : $("#date").val(), id_kota : $("#kota").val()}, 
            dataType: "json",
            beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response){ 
                $("#package").html(response.list_package).show();
            },
            error: function (xhr, ajaxOptions, thrownError) { 
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
            }
        });
    });
});

</script>