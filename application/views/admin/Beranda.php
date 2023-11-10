<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Dashboard</h6>
            </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <h6 class="text-sm font-weight-bolder mb-0">Sistem Muatan dan Pengiriman</h6>
            <div class="col-6 d-flex text-end">
                <a href="<?= site_url('admin/logout'); ?>" class="btn gradient-dark mb-0">|  Logout
                <i class="material-icons">arrow_forward</i>
                </a>
            </div>     
            </div>
        </div>
    </nav>
</br>
<div class="content">
    <div class="container-fluid">
        <div class="row pb-3">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">add_task</i>
                        </div>
                        <p class="card-category">Package Processed</p>
                        <h3 class="card-title counter"> <?= $processed ?> </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">add_task</i> Package Processed
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">exit_to_app</i>
                        </div>
                        <p class="card-category">Package Completed</p>
                        <h3 class="card-title counter"><?= $completed ?>  </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">exit_to_app</i> Package Completed
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">done_all</i>
                        </div>
                        <p class="card-category">Package Received</p>
                        <h3 class="card-title counter"><?= $receive ?> </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">local_offer</i> Package Received
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">info_outline</i>
                        </div>
                        <p class="card-category">Package Returned</p>
                        <h3 class="card-title counter"> <?= $return ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i>Package Returned
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD FOR DATA BARANG MASUK & BARANG KELUAR -->
        <div class="row pb-3">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">fit_screen</i>
                        </div>
                        <p class="card-category">Total Package</p>
                        <h3 class="card-title counter"> <?= $package ?> </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">fit_screen</i> Total Package
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">widgets</i>
                        </div>
                        <p class="card-category">Total Products</p>
                        <h3 class="card-title counter"> <?= $product ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">widgets</i> Total Products
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">local_shipping</i>
                        </div>
                        <p class="card-category">Total Truck</p>
                        <h3 class="card-title counter"> <?= $truck ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">local_shipping</i> Total Truck
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">manage_accounts</i>
                        </div>
                        <p class="card-category">Total Driver</p>
                        <h3 class="card-title counter"> <?= $driver ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">manage_accounts</i>Total Driver
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>