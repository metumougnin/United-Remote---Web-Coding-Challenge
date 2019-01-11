<?php include_once '_inc/server.php' ?>
<?php include_once '_inc/header_2.php'; ?>

    <!-- Page Content -->
    <div class="container" id="main_content">
	<div class="row">
	
	<?php 
    	// Select all available shops in the database
    	$select_all_shops_query = "SELECT * FROM shops";
    	$result = mysqli_query($db, $select_all_shops_query);
    	
    	
    	// Loop on each result and print details about the shops
    	while($line = mysqli_fetch_array($result)) {
    	    // New query on the shops table to extract shop details
    	    $select_pref_shops = "SELECT * FROM users_shops WHERE email_user='". $_SESSION['email'] ."' ";
    	    $result_pref_shops = mysqli_query($db, $select_pref_shops);
    	    $flag_pref = 0;
    	  
    	    while($line_pref_shops = mysqli_fetch_assoc($result_pref_shops)) {
    	    
        	    // Don't display this shop if it's in the current user preferred shops
        	    //if ($line_pref_shops['id_shop'] != $line['id']) {
        	    //    continue;
    	        if ($line_pref_shops['id_shop'] == $line['id']) {
        	        $flag_pref = 1;
        	        //break;
        	    }  
    	    }
    	    
    	    if ($flag_pref == 0) {
    	        
	?>
	
	<div class="col-lg-3 col-md-6 mb-4 ">
              <div class="card h-100">
                
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $line['name']; ?>
                  </h4>
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                </div>
                <div class="card-footer">
                    <div class="container-login100-form-btn">
                        <button class="shop-dislike-btn shop-btn">
                            Dislike
                        </button>
                        <a class="shop-like-btn shop-btn" href="nearby_shops.php?addshoptopreferred=<?php echo $line['id'] ?>">
                            Like
                        </a>
                    </div>
                </div>
              </div>
            </div>
            
    <?php 
       
    	    }
    	}
	?>

		</div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Metu Mougnin - United Remote 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
