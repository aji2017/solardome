<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10"><?= esc($nama_page) ?></h5>
              </div>
            </div>
          </div>
        </div>
      </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Status Terakhir ESP</h5>
                        <div class="card-body">
                            <?php if (!empty($status) && is_array($status)) : ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th class="text-center">Jenis</th>
                                                <th class="text-center">Hasil/Data Informasi Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($status as $key => $value) : ?>
                                                <tr>
                                                    <td><?= esc(ucwords(str_replace('_', ' ', $key))) ?></td>
                                                    <td><?= esc(is_array($value) ? json_encode($value) : $value) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p class="text-danger">Status tidak tersedia atau kosong.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
