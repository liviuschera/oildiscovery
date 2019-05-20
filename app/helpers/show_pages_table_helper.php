<?php

function showPagesTable($data)
{
    if (!empty($data)): ?>

<table class="table table--users u-mt-big">
   <thead>
      <tr>
         <th>Menu Id</th>
         <th>Page Id</th>
         <th>Nav Link</th>
         <th>Nav Title</th>
         <th>Nav Order</th>
         <th>Nav Active</th>
         <th>Nav Created</th>
         <th>Nav Modified</th>
         <th>Page Title</th>
         <th>Page Active</th>
         <th>Page Modified</th>
         <th colspan="1"></th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($data['page'] as $row): ?>
      <tr>
         <td>
            <?php echo $row->navID; ?>
         </td>
         <td class="tooltip">
            <span class="tooltip__img">
               <img src="<?php echo URLROOT .
                        BLOG_IMG_DIR .
                        $row->imgName; ?>" alt="Photo of <?php echo $row->navTitle; ?>">

            </span>
            <?php echo $row->navPageID; ?>
         </td>
         <td>
            <?php echo $row->navLink; ?>
         </td>
         <td>
            <?php echo $row->navTitle; ?>
         </td>
         <td>
            <?php echo $row->navOrder; ?>
         </td>
         <td>
            <?php echo $row->navActive == "y" ? "Yes" : "No"; ?>
         </td>
         <td>
            <?php echo formatDate($row->navCreatedAt, 'd-M-Y, H:i'); ?>
         </td>

         <td>
            <?php echo isset($row->navModifiedAt)
                    ? formatDate($row->navModifiedAt, 'd-M-Y, H:i')
                    : "Never"; ?>
         </td>
         <td>
            <?php echo $row->title; ?>
         </td>
         <td>
            <?php echo $row->postActive == "y" ? "Yes" : "No"; ?>
         </td>
         <td>
            <?php echo isset($row->postModified)
                    ? formatDate($row->postModified, 'd-M-Y, H:i')
                    : "Never"; ?>
         </td>

         <td><a class="button button--thin button--success"
               href="<?php echo URLROOT; ?>/pages/edit/<?php echo $row->navPageID; ?>">Edit</a>
         </td>

      </tr>
      <?php endforeach; ?>
   </tbody>
</table>
<?php // echo paginate($_SESSION['row_count_users']); ?>
<?php endif; ?>
<?php
}