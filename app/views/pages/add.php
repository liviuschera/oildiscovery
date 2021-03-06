<?php require APPROOT . '/views/includes/header_admin.php'; ?>
<?php require APPROOT . '/views/includes/navbar_admin.php'; ?>

<main class="admin__main">
   <!-- ~~~ ADD NEW MENU AND CONTENT FORM start ~~~ -->
   <form action="<?php echo URLROOT; ?>/pages/add" class="form u-div-center u-txt-align-center" method="post" enctype="multipart/form-data">
      <h2 class="h-2">Add Menu Item</h2>
      <p class="paragraph">Please fill out all the fields.</p>

      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <!-- Nav-bar START -->
      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <!-- Nav-bar TITLE -->
      <div class="form__group">
         <input type="text" class="form__input <?php echo !empty($data['titleError'])
                                                   ? 'form__invalid'
                                                   : ''; ?>" value="<?php echo $data['menutitle']; ?>" placeholder="Menu Title" name="menutitle" id="menutitle" />
         <span class="form__failed-feedback"><?php echo $data['menutitleError']; ?></span>
      </div>

      <div class="form__row">

         <!-- Menu ACTIVE -->
         <div class="form__group">
            <div class="form__checkbox">
               <input type="checkbox" name="menuactive" id="menuactive" value="y" <?php echo $data['menuactive'] === 'y'
                                                                                       ? ' checked'
                                                                                       : ''; ?> />
               <label for="menuactive"><span></span>Active Menu</label>
            </div>
         </div>

         <!-- Menu ORDER -->
         <div class="form__group">
            <label for="oder">Order:</label>
            <input type="number" name="order" id="order" value="<?php echo $data['order']; ?>" <?php echo !empty($data['orderError'])
                                                                                                   ? 'form__invalid'
                                                                                                   : ''; ?> />
            <span class="form__failed-feedback"><?php echo $data['orderError']; ?></span>
         </div>
      </div>

      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
      <!-- Nav-bar END -->
      <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->


      <!-- Post TITLE -->
      <div class="form__group">
         <input type="text" class="form__input <?php echo !empty($data['titleError'])
                                                   ? 'form__invalid'
                                                   : ''; ?>" value="<?php echo $data['title']; ?>" placeholder="Page Heading" name="title" id="title" />
         <span class="form__failed-feedback"><?php echo $data['titleError']; ?></span>
      </div>
      <div class="form__row">

         <!-- Post ACTIVE -->
         <div class="form__group">
            <div class="form__checkbox">
               <input type="checkbox" name="active" id="active" value="y" <?php echo $data['active'] === 'y'
                                                                              ? 'checked'
                                                                              : ''; ?> />
               <label for="active"><span></span>Active Content</label>
            </div>
         </div>

         <!-- Post PRIV -->
         <div class="form__group">
            <select id="priv" name="priv" class="form__select">
               <?php
               $privArray = [
                  '0' => 'User',
                  '1' => 'Admin',
                  '2' => 'Owner'
               ]; // Set an array contining user privilege levels // display the values in the form
               foreach ($privArray as $key => $value) {
                  echo "<option value={$key}";
                  if ((string)$data['priv'] === (string)$key) {
                     echo " selected";
                  }
                  echo ">{$value}</option>";
               }
               ?>
            </select>
            <label for="priv">Privilege:</label>
         </div>
      </div>

      <!-- Post IMAGE -->
      <div class="form__group u-mb-small">
         <input class="form__input" type="file" name="imgFile" id="imgFile" value="<?php echo $data['imgName']; ?>">
         <span class="form__failed-feedback"><?php echo $data['imgError']; ?></span>
      </div>

      <!-- Post CONTENT -->
      <div class="form__group">
         <textarea rows="7" class="form__textarea  <?php echo !empty($data['contentError'])
                                                      ? 'form__invalid'
                                                      : ''; ?>" placeholder="Post Content" name="content" id="content"><?php echo $data['content']; ?></textarea>
         <span class="form__failed-feedback"><?php echo $data['contentError']; ?></span>
      </div>

      <div class="form__row">
         <!-- Back Button -->
         <button class="button" formaction="<?php echo URLROOT; ?>/posts" type="submit">
            &laquo; Back
         </button>

         <!-- Post SUBMIT Button -->
         <input class="button" type="submit" value="Submit">
      </div>

      <script>
         CKEDITOR.replace('content');
      </script>
   </form>
   <!-- ~~~ ADD NEW MENU AND CONTENT FORM end ~~~ -->

</main>

<?php require APPROOT . '/views/includes/footer_admin.php';
