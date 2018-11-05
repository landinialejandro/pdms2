<?php
	include(dirname(__FILE__)."/header.php");

	// validate project name
	if (!isset($_REQUEST['axp']) || !preg_match('/^[a-f0-9]{32}$/i', $_REQUEST['axp'])){
		echo "<br>".$mpi->error_message('Project file not found.', 'index.php');
		exit;
	}
	
	$axp_md5 = $_REQUEST['axp'];
	$projectFile = '';
	$xmlFile = $mpi->get_xml_file($axp_md5 , $projectFile);
//-----------------------------------------------------------------------------------------
?>

<style>
	.item{
		cursor:pointer;
	}
</style>


<div class="page-header">
	<h1><img src="vcard.png" style="height: 1em;"> Membership Profile Image for AppGini</h1>
	<h1>
		<a href="./index.php">Projects</a> > <?php echo substr( $projectFile , 0 , strrpos( $projectFile , ".")); ?>
		<a href="output-folder.php?axp=<?php echo $axp_md5; ?>" class="pull-right btn btn-success  col-md-3 col-xs-12"><span class="glyphicon glyphicon-play"></span>  Enable MPI</a>
	</h1>

</div>

<div class="row">
	<?php
		echo $mpi->show_tables(array(
			'axp' => $xmlFile,
			'click_handler' => 'mpi',
			'classes' => 'col-md-3 col-xs-12'
		)); 
	?>
    <div id="coment" class="col-md-9 col-xs-12">
        Start only clicking by Enbale MPI
    </div>
</div>

<h4 id="bottom-links"><a href="./index.php"> &lt; Or open another project</a></h4>

<?php
	$xmlFile = json_encode($xmlFile);
?>



<script>	

	$j( document ).ready( function(){

		// sort divs by id in $fields section
		$j.fn.sortDivs = function sortDivs() {
		    $j("> div", this[0]).sort(custom_sort).appendTo(this[0]);
		    function custom_sort(a, b){ return (parseInt($j(b).data("sort")) < parseInt($j(a).data("sort"))) ? 1 : -1; }
		}

		//add resize event
		$j(window).resize(function() {
  			$j("#tables-list").height( $j(window).height() - $j("#tables-list").offset().top -  $j("#bottom-links").height() - 70);
		});
		
		$j(window).resize();




	});

        function mpi(){
            return;
        }

	var xmlFile = <?php echo $xmlFile; ?>;
	
	//sava fields' data types
	var tableData = [];



</script>



<?php include(dirname(__FILE__) . "/footer.php"); ?>