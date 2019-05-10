<?php

function showUserTable($data)
{
    if (!empty($data)): ?>

<table class="table table--users u-mt-big">
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
         <td>
            <?php echo $row->id; ?>
         </td>
         <td class="tooltip">
            <span class="tooltip__img">
               <img src="<?php echo URLROOT .
                        USER_IMG_DIR .
                        $row->imgName; ?>" alt="Photo of <?php echo $row->firstName .
    ' ' .
    $row->lastName; ?>">

            </span>
            <?php echo $row->lastName; ?>
         </td>
         <td>
            <?php echo $row->firstName; ?>
         </td>
         <td>
            <?php echo $row->email; ?>
         </td>
         <td>
            <?php echo $row->phone; ?>
         </td>
         <td>
            <?php echo formatDate($row->createdAt, 'd-M-Y, H:i'); ?>
         </td>
         <!-- <td><?php echo $row->modified; ?>
            </td> -->
         <td>
            <?php echo isset($row->modified)
                    ? formatDate($row->modified, 'd-M-Y, H:i')
                    : "Never"; ?>
         </td>
         <td>
            <?php echo $row->priv; ?>
         </td>
         <td>
            <?php echo $row->active == "y" ? "Yes" : "No"; ?>
         </td>

         <td><a class="button button--thin button--success"
               href="<?php echo URLROOT; ?>/users/edit/<?php echo $row->id; ?>">Edit</a>
         </td>
         <td>
            <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $row->id; ?>" method="POST">
               <input type="submit" value="Delete" class="button button--thin button--danger">
            </form>
         </td>
      </tr>
      <?php endforeach; ?>
   </tbody>
</table>
<?php echo paginate($_SESSION['row_count_users']); ?>
<?php endif; ?>
<?php
}