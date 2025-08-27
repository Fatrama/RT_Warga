<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/index.php">RT 01</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/residents.php">Data Warga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/finance.php">Keuangan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/activities.php">Kegiatan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/announcements.php">Pengumuman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pages/about.php">Tentang</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard.php">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/process/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/pages/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>