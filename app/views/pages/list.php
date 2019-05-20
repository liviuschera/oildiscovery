<?php require APPROOT . '/views/includes/header_admin.php'; ?>
<?php require APPROOT . '/views/includes/navbar_admin.php'; ?>

<main class="admin__main">
   <?php flash('pages_message'); ?>
   <!-- Check if user is at least admin. -->
   <?php if (hasPrivLevel(1)): ?>

   <?php echo showPagesTable($data); ?>

   <?php endif; ?>
</main>

<?php require APPROOT . '/views/includes/footer_admin.php';