<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Shipping</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Shipping</h6>
            </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <h6 class="text-sm font-weight-bolder mb-0"></h6>
            </div>
            
        </div>
    </nav>
</br>
<div class="container-fluid py-4 pt-0">
    <div class="card-header p-0 w-75 position-fixed mt-n4 mx-2 z-index-2">
        <div class="shadow-dark border-radius-lg d-flex px-5 pt-4 pb-3">
            <div class="col-8 d-flex align-items-center"> 
                <i class="material-icons pr-3">task</i>
                <h6 class="mb-0">Shipping</h6>
            </div>
        </div>
    </div>
</div>
<div class="container py-4 pl-5 pr-5">
    <div class="row">
        <div class="card">
            <div class="card-body pt-4 p-3">
            <div class="table-responsive p-0">
                <table id="table-data" class="table align-items-center justify-content-center mb-0">
                <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Schedule</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Truck</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Driver</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Berat</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Volume</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pl-3">
                    <?php if (!empty($capacity)) : $i = 1; foreach (array_reverse($capacity) as $value) : ?>
                        <tr>
                        <td>
                        <div class="d-flex pl-3">
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?= $i++; ?></h6>
                            </div>
                        </div>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= date('d-m-Y',strtotime ($value->schedule)); ?></span>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->truck; ?></span>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->driver; ?></span>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->b_capacity; ?> kg / <?= $value->bmax; ?> kg</span>
                        </td>
                        <td class="pl-4"> 
                            <span class="text-sm font-weight-bold"><?= substr($value->r_capacity, 0, 4); ?> m&sup3 / <?= $value->capacity; ?> m&sup3</span>
                        </td>
                        <td class="pl-4">
                        <?php if ( $value->cstatus == 2) :?>
                            <a href="<?= site_url('driver/shipping/'.$value->id_capacity.'/view'); ?>" rel="tooltip" title="detail" class="badge btn-dark btn-sm">
                            Shipment</a>
                        <?php else : ?>
                            <span class="text-xs font-weight-bold text-success">Processed</span>
                        </td>
                        <?php endif ;?> 
                        </td>
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