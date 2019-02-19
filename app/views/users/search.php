<?php require APPROOT . '/views/includes/header_admin.php'; ?> 
<?php require APPROOT . '/views/includes/navbar_admin.php'; ?> 
     
   <main class="admin__main">
   <?php flash('user_message'); ?>
      <!-- Check if user is at least admin. -->
      <?php if (hasPrivLevel(0)): ?>

      <form class="form form--search u-div-center u-mt-big u-mb-big" action="<?php echo URLROOT; ?>/users/search" method="post">
         <input class="form__input" type="text" name="search" value="" placeholder="Search users">
      </form>
<?php var_dump($data); ?>
<?php echo "row count: " . $_SESSION['row_count_users'] ??
    "row count not set"; ?>
     
     <?php echo showUserTable($data); ?>

      <?php endif; ?>
   </main>
   
<?php require APPROOT . '/views/includes/footer_admin.php'; ?> 