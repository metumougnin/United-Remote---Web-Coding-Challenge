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
    	        
    	        // 
    	        if ($line_pref_shops['id_shop'] == $line['id']) {
    	            $flag_pref = 1;
    	        }
    	    }
    	    
    	    if ($flag_pref == 1) {
    	        continue;
    	    }
    	    
    	    // Query to select current user disliked shops
    	    $select_disliked_shops = "SELECT * FROM users_disliked_shops WHERE email_user='". $_SESSION['email'] ."' ";
    	    $result_disliked_shops = mysqli_query($db, $select_disliked_shops);
    	    $flag_disliked = 0;
    	  
    	    while($line_disliked_shops = mysqli_fetch_assoc($result_disliked_shops)) {
    	    
        	    // Don't display this shop if the user disliked it
    	        if ($line_disliked_shops['id_shop'] == $line['id']) {
    	            /*
    	            echo time();
    	            echo "\n";
    	            echo strtotime($line_disliked_shops['end_at']);
    	            */
    	            
    	            // Delete the entry from the disliked shops if the countdown (2hrs) is over
    	            //if(/*time()*/ strtotime(date('Y-m-d H:i:s', strtotime('2 hour'))) >= strtotime($line_disliked_shops['end_at'])) {
    	            if(time() >= strtotime($line_disliked_shops['end_at'])) {
    	                $query = "DELETE FROM users_disliked_shops WHERE email_user='". $_SESSION['email'] ."' and id_shop=". $line_disliked_shops['id_shop'] ."";
    	                mysqli_query($db, $query);
    	                
    	            } else {
    	                $flag_disliked = 1;
    	            }
        	    }  
    	    }
    	    
    	    
    	    if ($flag_pref == 0 && $flag_disliked == 0) {
    	        
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
                        <a class="shop-dislike-btn shop-btn" href="nearby_shops.php?dislikeshop=<?php echo $line['id'] ?>">
                            Dislike
                        </a>
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
    <!--  
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Metu Mougnin - United Remote 2018</p>
      </div>
    </footer>
    -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
