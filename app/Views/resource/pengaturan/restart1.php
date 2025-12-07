<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Restart Kontaktor</h5>
              </div>
            </div>
          </div>
        </div>
      </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Restart Kontaktor</h5>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('esp/restart') ?>">
                            <input type="hidden" name="esp" value="1">
                            <button type="submit" class="btn btn-warning">
                                🔁 Restart Kontaktor
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
