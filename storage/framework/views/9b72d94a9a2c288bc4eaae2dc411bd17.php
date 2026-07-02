

<?php $__env->startSection('title', 'Daftar Anggota'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active"><i class="bi bi-people"></i> Anggota</li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 fw-bold text-dark">
                <i class="bi bi-people"></i> Daftar Anggota
            </h1>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex gap-2">
                <a href="<?php echo e(route('anggota.export')); ?>" class="btn btn-success">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export Excel
                </a>
                <a href="<?php echo e(route('anggota.create')); ?>" class="btn btn-custom btn-custom-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Anggota
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon text-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-number"><?php echo e($totalAnggota); ?></div>
                <div class="stat-label">Total Anggota</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--success-color);">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number"><?php echo e($anggotaAktif); ?></div>
                <div class="stat-label">Anggota Aktif</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--warning-color);">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-number"><?php echo e($anggotaNonaktif); ?></div>
                <div class="stat-label">Anggota Nonaktif</div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="color: var(--info-color);">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="stat-number"><?php echo e($totalAnggota > 0 ? round(($anggotaAktif / $totalAnggota) * 100, 0) : 0); ?>%</div>
                <div class="stat-label">Aktif (%)</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="filter-section">
        <form method="GET" action="/anggota" class="row g-3">
            <div class="col-md-4">
                <label for="keyword" class="filter-label">Keyword</label>
                <input type="text" class="form-control search-input" id="keyword" name="keyword" 
                       placeholder="Cari nama, email, atau telepon..." value="<?php echo e(request('keyword', request('search'))); ?>">
            </div>

            <div class="col-md-2">
                <label for="jenis_kelamin" class="filter-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki" <?php echo e(request('jenis_kelamin') === 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo e(request('jenis_kelamin') === 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="status" class="filter-label">Status Anggota</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="Aktif" <?php echo e(request('status') === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                    <option value="Nonaktif" <?php echo e(request('status') === 'Nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="pekerjaan" class="filter-label">Pekerjaan</label>
                <select class="form-select" id="pekerjaan" name="pekerjaan">
                    <option value="">Semua Pekerjaan</option>
                    <option value="Mahasiswa" <?php echo e(request('pekerjaan') === 'Mahasiswa' ? 'selected' : ''); ?>>Mahasiswa</option>
                    <option value="Pegawai" <?php echo e(request('pekerjaan') === 'Pegawai' ? 'selected' : ''); ?>>Pegawai</option>
                    <option value="Wiraswasta" <?php echo e(request('pekerjaan') === 'Wiraswasta' ? 'selected' : ''); ?>>Wiraswasta</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-custom btn-custom-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
                <a href="/anggota" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="card">
        <div class="card-body p-0">
            <?php if($anggota->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Kode Anggota</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Pekerjaan</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark"><?php echo e($item->kode_anggota); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e($item->nama); ?></strong><br>
                                        <small class="text-muted">Umur: <?php echo e($item->umur); ?> tahun</small>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo e($item->email); ?>"><?php echo e($item->email); ?></a>
                                    </td>
                                    <td><?php echo e($item->telepon); ?></td>
                                    <td><?php echo e($item->pekerjaan ?? '-'); ?></td>
                                    <td>
                                        <?php if($item->jenis_kelamin === 'Laki-laki'): ?>
                                            <span class="badge bg-info">♂️ Laki-laki</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">♀️ Perempuan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($item->status === 'Aktif'): ?>
                                            <span class="badge bg-success">✓ Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">✗ Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo e($item->created_at->format('d M Y')); ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary btn-sm" title="Detail" disabled>
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <a href="/anggota/<?php echo e($item->id); ?>/edit" class="btn btn-outline-secondary btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-light">
                    <nav>
                        <ul class="pagination justify-content-center mb-0">
                            <!-- Previous Link -->
                            <?php if($anggota->onFirstPage()): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">← Sebelumnya</span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($anggota->previousPageUrl()); ?>">← Sebelumnya</a>
                                </li>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php $__currentLoopData = $anggota->getUrlRange(1, $anggota->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $anggota->currentPage()): ?>
                                    <li class="page-item active">
                                        <span class="page-link"><?php echo e($page); ?></span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <!-- Next Link -->
                            <?php if($anggota->hasMorePages()): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo e($anggota->nextPageUrl()); ?>">Selanjutnya →</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Selanjutnya →</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5 class="empty-state-title">Anggota Tidak Ditemukan</h5>
                    <p class="empty-state-text">Tidak ada anggota yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="/anggota" class="btn btn-custom btn-custom-primary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Filter
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Perpustakaan laravel praktikum\resources\views/perpustakaan/anggota/index.blade.php ENDPATH**/ ?>