<?php include_once '_inc/server.php' ?>
<?php include_once '_inc/header_2.php'; ?>

    <!-- Page Content -->
    <div class="container" id="main_content">

      <div class="row">
      <?php 
    	// Select from the database all available preferred shops corresponding to the logged user
    	$select_pref_shops_query = "SELECT * FROM users_shops where email_user='". $_SESSION['email'] ."' ";
    	$result = mysqli_query($db, $select_pref_shops_query);
    	
    	// Loop on each result and print details about the shops
    	while($line = mysqli_fetch_array($result)) {
    	    // New query on the shops table to extract shop details
    	    $select_pref_shops = "SELECT * FROM shops WHERE id=". $line['id_shop'] ." LIMIT 1";
    	    $result_pref_shops = mysqli_query($db, $select_pref_shops);
    	    $line_pref_shops = mysqli_fetch_assoc($result_pref_shops);
	  ?>
	
            <div class="col-lg-3 col-md-6 mb-4 ">
              <div class="card h-100">
                
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $line_pref_shops['name']; ?>
                  </h4>
                    <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                </div>
                <div class="card-footer">
                    <div class="container-login100-form-btn">
                        <a class="shop-remove-btn shop-btn" href="preferred_shops.php?deleteshopfrompreferred=<?php echo $line_pref_shops['id'] ?>">
                            remove
                        </a>
                    </div>
                </div>
              </div>
            </div>

	  <?php 
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
