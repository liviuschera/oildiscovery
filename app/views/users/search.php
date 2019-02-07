<?php require APPROOT . '../views/includes/header_admin.php'; ?> 
<?php require APPROOT . '../views/includes/navbar_admin.php'; ?> 
     
   <main class="admin__main">
      <!-- Check if user is at least admin. -->
      <?php if (hasPrivLevel(0)): ?>

      <form class="form form--search u-div-center u-mt-big u-mb-big" action="<?php echo URLROOT; ?>/users/search" method="post">
         <input class="form__input" type="text" name="search" value="" placeholder="Search users">
      </form>
<?php var_dump($data); ?>
<?php echo "row count: " . $_SESSION['row_count'] ?? "row count not set"; ?>
      <?php if (!empty($data)): ?>
      <table class="table u-div-center table--users u-mt-big">
         <thead>
            <tr>
                <th>Id</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Modified At</th>
                <th>Priv</th>
                <th>Active</th>
                <th colspan="2"></th>
            </tr>
         </thead>
         <tbody>
         <?php foreach ($data as $row): ?>
            <tr>
               <td><?php echo $row->id; ?></td>
               <td><?php echo $row->lastName; ?></td>
               <td><?php echo $row->firstName; ?></td>
               <td><?php echo $row->email; ?></td>
               <td><?php echo $row->phone; ?></td>
               <td><?php echo formatDate($row->createdAt, 'd-M-Y, H:i'); ?></td>
               <!-- <td><?php echo $row->modified; ?></td> -->
               <td><?php echo isset($row->modified)
                   ? formatDate($row->modified, 'd-M-Y, H:i')
                   : "Never"; ?></td>               
               <td><?php echo $row->priv; ?></td>
               <td><?php echo $row->active == "y" ? "Yes" : "No"; ?></td>
            </tr>
<?php endforeach; ?>
         </tbody>
      </table>
      <?php echo paginate($_SESSION['row_count']); ?>
      <?php endif; ?>

      <?php endif; ?>
   </main>
   
<?php require APPROOT . '../views/includes/footer_admin.php'; ?> 