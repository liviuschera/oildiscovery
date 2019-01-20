<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['postID']; ?>"
   class="form u-div-center"
   method="post"
>
   <h3 class="heading-tertiary">Edit Post</h3>
   <p class="paragraph">Please fill out all the fields.</p>
   <pre><?php echo var_dump($data); ?></pre>

   
   <!-- Post TITLE -->
      <div class="form__group">
         <input
            type="text"
            class="form__input <?php echo !empty($data['titleError'])
                ? 'form__invalid'
                : ''; ?>"
            value="<?php echo $data['title']; ?>"
            placeholder="Title"
            name="title"
            id="title"

         />
         <span class="form__failed-feedback"><?php echo $data[
             'titleError'
         ]; ?></span>
      </div>
      <div class="form__row">

      <!-- Post ACTIVE -->
      <div class="form__group">
         <div class="form__checkbox">
            <input type="checkbox" name="active" id="active" value="y"
            <?php echo $data['active'] === 'y' ? 'checked' : ''; ?>/>
            <label for="active"><span></span>Active Post</label>
         </div>
      </div>
         
   <!-- Post PRIV -->
   <div class="form__group">
      <select id="priv" name="priv" class="form__select">
         <?php
         // Set an array contining user privilege levels
         $privArray = ['0' => 'User', '1' => 'Admin', '2' => 'Owner'];
         // display the values in the form
         foreach ($privArray as $key => $value) {
             echo "<option value={$key}";
             if ((string) $data['priv'] === (string) $key) {
                 echo " selected";
             }
             echo ">{$value}</option>";
         }
         ?>
      </select>
      <label for="priv">Privilege:</label>
   </div>
   </div>

   <!-- Post CONTENT -->
   <div class="form__group">
      <textarea
         rows="7"
         class="form__textarea  <?php echo !empty($data['contentError'])
             ? 'form__invalid'
             : ''; ?>"
         placeholder="Post Content"
         name="content"
         id="content"
      ><?php echo $data['content']; ?></textarea>
      <span class="form__failed-feedback"><?php echo $data[
          'contentError'
      ]; ?></span>
   </div>

      
   <div class="form__row">
      <!-- Back Button -->
      <button
         class="button"
         formaction="<?php echo URLROOT; ?>/posts"
         type="submit"
      >
       &laquo; Back
      </button>

   <!-- Post SUBMIT Button -->
      <input
         class="button"
         formaction="<?php echo URLROOT; ?>/posts/edit/<?php echo $data[
    'postID'
]; ?>"
         type="submit"
         value="Submit"
      >
         <!-- Edit Post -->
      <!-- </button> -->

      
   </div>

</form>
<!-- ~~~ REGISTRATION FORM end ~~~ -->