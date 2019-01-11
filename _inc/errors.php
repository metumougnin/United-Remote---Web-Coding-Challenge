<?php  if (count($errors) > 0) : ?>
  <div class="error registration_errors">
  	Please correct the following errors
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>