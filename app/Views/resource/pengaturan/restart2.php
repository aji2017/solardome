<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Restart Alat</h5>
              </div>
            </div>
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