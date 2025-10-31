    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo h($site['title']); ?></h3>
                    <p><?php echo h($site['description']); ?></p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>
                        <strong>Telefoon:</strong> <a href="tel:<?php echo h($site['contact']['phone']); ?>"><?php echo h($site['contact']['phone']); ?></a><br>
                        <strong>E-mail:</strong> <a href="mailto:<?php echo h($site['contact']['email']); ?>"><?php echo h($site['contact']['email']); ?></a>
                    </p>
                </div>
                <div class="footer-section">
                    <h3>Adres</h3>
                    <p>
                        <?php echo h($site['contact']['address']); ?><br>
                        <?php echo h($site['contact']['zipcode']); ?> <?php echo h($site['contact']['city']); ?>
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo h($site['title']); ?>. Alle rechten voorbehouden.</p>
                <?php if (isAdmin()): ?>
                    <p class="admin-link">
                        <a href="/admin/">Admin Panel</a> | 
                        <a href="/admin/logout.php">Uitloggen</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    <script src="/assets/js/main.js"></script>
</body>
</html>
