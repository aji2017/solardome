<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">On/Off Alat</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Sistem Alat</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('alat/aturalat') ?>">
                                <label class="switch">
                                    <input type="checkbox" name="alat" value="1"
                                           onchange="this.form.submit()" <?= ($status['alat'] === 'false' ? 'checked' : '') ?>>
                                    <span class="slider"></span>
                                </label>
                                <span class="ml-2">ON / OFF</span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
