<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/post/add"
   class="form u-div-center"
   method="post"
>
   <h3 class="heading-tertiary">Add Post</h3>
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
         <span class="form__invalid-feedback"><?php echo $data[
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
      <?php $privArray = ['0' => 'User', '1' => 'Admin', '2' => 'Owner'];
// Set an array contining user privilege levels
?>
      <select id="priv" name="priv" class="form__select">
         <?php foreach ($privArray as $key => $value) {
             echo "<option value={$key}";
             if ((string) $data['priv'] === (string) $key) {
                 echo " selected";
             }
             echo ">{$value}</option>";
         } ?>
         <!-- <option value="1">Admin</option>
         <option value="2">Owner</option> -->
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
      <span class="form__invalid-feedback"><?php echo $data[
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
      <button
         class="button"
         formaction="<?php echo URLROOT; ?>/posts/add"
         type="submit"
      >
         Add Post
      </button>

      
   </div>

</form>
<!-- ~~~ REGISTRATION FORM end ~~~ -->
