<div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Histori Data (API)</h5>
              </div>
            </div>
          </div>
        </div>
      </div>

            <?php if (isset($sensor_data['error'])): ?>
    <div class="alert alert-danger"><?= esc($sensor_data['error']) ?></div>
<?php else: ?>
    <div class="dt-responsive table-responsive">
      <table id="add-row-table" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Suhu</th>
                <th>Kelembapan</th>
                <th>CO2</th>
                <th>Tegangan</th>
                <th>Arus</th>
                <th>Power</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sensor_data as $row): ?>
                <tr>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><?= esc($row['waktu']) ?></td>
                    <td><?= esc($row['suhu']) ?></td>
                    <td><?= esc($row['kelembapan']) ?></td>
                    <td><?= esc($row['co2']) ?></td>
                    <td><?= esc($row['tegangan']) ?></td>
                    <td><?= esc($row['arus']) ?></td>
                    <td><?= esc($row['power']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
</div>
</div>
