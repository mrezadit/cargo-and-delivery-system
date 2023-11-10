<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Shipment</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Shipping</h6>
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

<div class="d-flex justify-content-center">
<div class="col-md-12 pl-5 pr-5">

    <div class="row mb-3">
          <div class="card">
          <div class="card-body p-3">
            <div class="card-header pb-2 p-2">
            <div class="row">
                <div class="col-10 align-items-center">
                    <span class="font-weight-bolder mb-0"><b>Shipping Process</b> - Scheduled on <?= date('d-m-Y',strtotime ($capacity['schedule']));?></span>
                </div>
                <div class="col-2 text-end d-flex">
                <div class="pr-3">
                <a href="<?= site_url('admin/completeShipping/'.$capacity['id_capacity'].''); ?>" class="badge btn-dark mb-0">Complete <i class="material-icons text-sm">open_in_new</i></a>
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
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Address</th>
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
                            <span class="text-sm font-weight-bold"><?= $value->kota; ?> - <?= $value->address; ?></span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->t_kg ?> kg</span> </br>
                        </td>
                        <td class="pl-4">
                        <?php if ( $value->pstatus == 2) :?>
                        <a href="<?= site_url('admin/receiveShipping/'.$value->id_capacity.'/'.$value->id_package.''); ?>" rel="tooltip" title="detail"  class="badge btn-info btn-sm mb-0">
                        Received</a>
                        <a href="<?= site_url('admin/returnShipping/'.$value->id_capacity.'/'.$value->id_package.''); ?>" rel="tooltip" title="detail"  class="badge btn-warning btn-sm mb-0">
                        Return</a>
                        <?php elseif ( $value->pstatus == 3) : ?>
                        <span class="text-xs font-weight-bold text-warning">Returned</span>
                        <?php elseif ( $value->pstatus == 4) : ?>
                        <span class="text-xs font-weight-bold text-success">Received</span>
                        </td>
                        <?php endif ;?> 
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                    </table>
                </div>
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
$(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya
    
    $("#date").change(function(){ // Ketika user mengganti atau memilih data provinsi
    
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?php echo base_url("index.php/admin/listKota"); ?>", // Isi dengan url/path file php yang dituju
            data: {date : $("#date").val()}, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response){ 
                $("#kota").html(response.list_kota).show();
            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });

    $("#kota").change(function(){ // Ketika user mengganti atau memilih data provinsi
		
        $.ajax({
            type: "POST", // Method pengiriman data bisa dengan GET atau POST
            url: "<?php echo base_url("index.php/admin/listPackage"); ?>", // Isi dengan url/path file php yang dituju
            data: {id_kota : $("#kota").val()}, // data yang akan dikirim ke file yang dituju
            dataType: "json",
            beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response){ 
                $("#package").html(response.list_package).show();
            },
            error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
            }
        });
    });
});

</script>