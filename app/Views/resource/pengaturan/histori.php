<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Histori Data</h2>
                    </div>
                </div>
            </div>

            <?php if (isset($sensor_data['error'])): ?>
    <div class="alert alert-danger"><?= esc($sensor_data['error']) ?></div>
<?php else: ?>
    <table class="table table-bordered">
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

    <!-- Pagination Manual -->
    <?php if (isset($pager) && $pager['totalPages'] > 1): ?>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pager['totalPages']; $i++): ?>
                    <li class="page-item <?= ($i === $pager['currentPage']) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>
