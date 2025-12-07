<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Restart Alat</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Restart Alat</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('plc/restart') ?>">
                            <input type="hidden" name="plc" value="1">
                            <button type="submit" class="btn btn-warning">
                                🔁 Restart Alat
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>