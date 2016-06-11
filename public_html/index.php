<!-- head utils contains the entire <head> tag -->
<?php require_once("php/templates/head-utils.php");?>

<body class="sfooter">
	<div class="sfooter-content">
			<div>
				<main>
					<div>
						
						<!-- angular view directive -->
						<div ng-view></div>
						
					</div>
				</main>
			</div>

	</div><!-- sfooter content -->
	
	<!-- footer gets inserted -->
	<?php require_once("php/templates/footer.php");?>
	
</body>
</html>