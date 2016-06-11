<header ng-controller="navController">
	<bootstrap-breakpoint></bootstrap-breakpoint>
	<nav class="navbar navbar-inverse">
		<div>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" ng-click="!navCollapsed">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home"><img id="logo" src="image/icon-take2.png"> </a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar" uib-collapse="navCollapsed">
				<ul class="nav navbar-nav">
					<li class="active"><a href="home">Home</a></li>
					<li><a href="images">Images</a></li>
					<li><a href="news">News</a></li>
					<li><a href="about">About</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> Login</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-search"></span> Search</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>
