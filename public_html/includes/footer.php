<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>RT 01</h5>
                <p>Portal informasi dan layanan untuk warga RT 01 Kelurahan Contoh. Melayani dengan sepenuh hati untuk kemajuan bersama.</p>
                <div class="social-links mt-3">
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Link Cepat</h5>
                <ul>
                    <li><a href="/index.php"><i class="bi bi-house-door"></i> Beranda</a></li>
                    <li><a href="/pages/residents.php"><i class="bi bi-people"></i> Data Warga</a></li>
                    <li><a href="/pages/finance.php"><i class="bi bi-cash-stack"></i> Keuangan</a></li>
                    <li><a href="/pages/activities.php"><i class="bi bi-calendar-event"></i> Kegiatan</a></li>
                    <li><a href="/pages/announcements.php"><i class="bi bi-megaphone"></i> Pengumuman</a></li>
                    <li><a href="/pages/about.php"><i class="bi bi-info-circle"></i> Tentang Kami</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Kontak Kami</h5>
                <ul>
                    <li><i class="bi bi-geo-alt"></i> Jl. Contoh No. 123, Kelurahan Contoh</li>
                    <li><i class="bi bi-telephone"></i> (021) 1234567</li>
                    <li><i class="bi bi-envelope"></i> rt01@example.com</li>
                    <li><i class="bi bi-clock"></i> Senin - Jumat: 08.00 - 16.00</li>
                    <li><i class="bi bi-clock"></i> Sabtu: 08.00 - 12.00</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> RT 01. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-card, .feature-card, .announcement-card, .activity-card').forEach(el => {
        observer.observe(el);
    });
</script>
</body>
</html>