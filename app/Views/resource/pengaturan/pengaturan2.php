<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Pengaturan Kipas ON/OFF</h5>
              </div>
            </div>
          </div>
        </div>
      </div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Kontrol Kipas</h5>
            <div class="card-body">
                <form method="post" action="<?= base_url('kontrol/atur') ?>">
                    <div class="form-group">
                        <label class="d-block">Kipas Exhaust</label>
                        <label class="switch">
                            <input type="checkbox" name="exhaust_status" value="1"
                                <?= ($status['rly1'] === 'false' ? 'checked' : '') ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ml-2">ON / OFF</span>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Kipas Sirkulasi</label>
                        <label class="switch">
                            <input type="checkbox" name="sirkulasi_status" value="1"
                                <?= ($status['rly2'] === 'false' ? 'checked' : '') ?>>
                            <span class="slider"></span>
                        </label>
                        <span class="ml-2">ON / OFF</span>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>