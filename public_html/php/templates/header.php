<header>
	<nav class="navbar navbar-inverse">
		<div class="container ng-1">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">REDROVR</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href data-toggle="modal" data-target="#about-modal">About</a></li>
					<li><a>Images</a></li>
					<li><a>News</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Search
							<span class="caret"></span></a>
						<div class="dropdown-menu">
							search here
						</div>
				</ul>
			</div>
		</div>
	</nav>
</header>

<?php require_once("about-modal.php");?>