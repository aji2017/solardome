<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Pengaturan Ketentuan</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Suhu -->
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">Suhu</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('set/suhu') ?>">
                                <div class="form-group">
                                    <label for="suhu">Suhu: <span id="suhu_value"><?= esc($suhu) ?></span></label>
                                    <input type="range" class="form-control-range" id="suhu" name="suhu" min="0" max="100" value="<?= esc($suhu) ?>" oninput="document.getElementById('suhu_value').innerText = this.value">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Kelembapan -->
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">Kelembapan</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('set/kelembapan') ?>">
                                <div class="form-group">
                                    <label for="kelembapan">Kelembapan: <span id="kelembapan_value"><?= esc($kelembapan) ?></span></label>
                                    <input type="range" class="form-control-range" id="kelembapan" name="kelembapan" min="0" max="100" value="<?= esc($kelembapan) ?>" oninput="document.getElementById('kelembapan_value').innerText = this.value">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- CO2 -->
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">CO2 (Sensor Bau)</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('set/co2') ?>">
                                <div class="form-group">
                                    <label for="co2">CO2: <span id="co2_value"><?= esc($co2) ?></span></label>
                                    <input type="range" class="form-control-range" id="co2" name="co2" min="0" max="4400" value="<?= esc($co2) ?>" oninput="document.getElementById('co2_value').innerText = this.value">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
