<?php if(!isset($Translation)){ @header('Location: index.php'); exit; } ?>
<?php include_once("{$currDir}/header.php"); ?>


    <!-- Main content -->
    

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
                <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-aqua">
                            <div class="inner">
                              <h3>
                                  <?php 
                                      $sql_from = get_sql_from('orders');
                                      $count_records = ($sql_from ? sqlValue("select count(1) from " . $sql_from) : 0);
                                      echo number_format($count_records);
                                  ?>
                              </h3>

                              <p>New Orders</p>
                            </div>
                            <div class="icon">
                              <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="orders_view.php" class="small-box-footer">
                              More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                          </div>
                        </div>
    

<?php include_once("$currDir/footer.php"); ?>