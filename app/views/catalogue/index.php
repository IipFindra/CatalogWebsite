<?php
// app/views/catalogue/index.php
$title = 'Katalog Produk - PenaPedia';
?>

<!-- Catalog Hero -->
<section class="catalog-hero">
    <div class="container">
        <h1>Katalog Produk</h1>
        <p>Jelajahi koleksi produk premium kami yang dibuat dengan kualitas dan gaya</p>
    </div>
</section>

<!-- Category Filter -->
<section class="category-filter">
    <div class="container">
        <div class="filter-buttons">
            <?php foreach ($categories as $index => $cat): ?>
            <button class="filter-btn <?= $index === 0 ? 'active' : '' ?>" data-category="<?= htmlspecialchars($cat) ?>">
                <?= htmlspecialchars($cat === 'All' ? 'Semua' : $cat) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="products-section">
    <div class="container">
        <?php if (empty($items)): ?>
            <div class="empty-state" style="text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 16px; margin: 2rem 0;">
                <h2 style="color: #1a1a1a; margin-bottom: 1rem;">Produk Tidak Ditemukan</h2>
                <p style="color: #666; margin-bottom: 2rem;">Saat ini belum ada produk di database.</p>
                <div style="background: #f8fafa; padding: 1.5rem; border-radius: 8px; text-align: left; max-width: 600px; margin: 0 auto;">
                    <h3 style="color: #1a1a1a; margin-bottom: 0.5rem;">Informasi Debug:</h3>
                    <p><strong>Jumlah Item:</strong> <?= count($items) ?></p>
                    <p><strong>Jumlah Kategori:</strong> <?= count($categories ?? []) ?></p>
                    <hr style="margin: 1rem 0;">
                    <p>Cek: <a href="/test_db.php" style="color: #14B8A6;">Tes Koneksi Database</a></p>
                </div>
            </div>
        <?php else: ?>
            
            <div class="products-grid">
                <?php foreach ($items as $item): ?>
                <div class="product-card" data-category="<?= htmlspecialchars($item['category']) ?>">
                    <div class="product-image">
                        <img src="<?= htmlspecialchars($item['image']) ?>">
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?= strtoupper(htmlspecialchars($item['category'])) ?></span>
                        <h3 class="product-title"><?= htmlspecialchars($item['title']) ?></h3>
                        <div class="product-footer">
                            <span class="product-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                            <button class="btn-add" onclick="openProductModal(
                                <?= $item['id'] ?>, 
                                '<?= addslashes($item['title']) ?>', 
                                '<?= addslashes($item['category']) ?>',
                                <?= $item['price'] ?>,
                                '<?= addslashes($item['image']) ?>'
                            )">
                                <i class="bi bi-cart-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Simple category filter
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const category = this.dataset.category;
        document.querySelectorAll('.product-card').forEach(card => {
            // Check for 'All' or 'Semua' depending on what's in dataset
            if (category === 'All' || category === 'Semua' || card.dataset.category === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
