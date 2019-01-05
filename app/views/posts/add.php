<?php require APPROOT .
    '../views/includes/header.php'; ?> <?php require APPROOT .
     '../views/includes/navbar.php'; ?>

<!-- ~~~ REGISTRATION FORM start ~~~ -->

<form
   action="<?php echo URLROOT; ?>/users/register"
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
            <input
               type="checkbox"
               name="active"
               id="active"
               <?php echo $data['active'] === 'y' ? 'checked' : ''; ?>
            />
            <label for="active"><span></span>Activate Post</label>
         </div>
      </div>
         
   
   <!-- Post PRIV -->
   <div class="form__group">
      <select name="priv" class="form__select">
         <option value="0">User</option>
         <option value="1">Admin</option>
         <option value="2">Owner</option>
      </select>
      <label for="priv">Privilege:</label>
   </div>
   </div>

      

   <!-- Post CONTENT -->
   <textarea
      name="message"
      id="textarea"
      rows="7"
      class="form__textarea  <?php echo !empty($data['contentError'])
          ? 'form__invalid'
          : ''; ?>"
      value="<?php echo $data['content']; ?>"
      placeholder="Post Content"
      name="content"
      id="content"
   ></textarea>
      

   <!-- Post SUBMIT Button -->
      <button
         class="button"
         formaction="<?php echo URLROOT; ?>/users/add"
         type="submit"
      >
         Add Post
      </button>

</form>
<!-- ~~~ REGISTRATION FORM end ~~~ -->
