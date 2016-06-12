<header ng-controller="navController">
	<bootstrap-breakpoint></bootstrap-breakpoint>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" ng-click="!navCollapsed">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home"><img id="logo" src="image/icon-border.png"> </a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar" uib-collapse="navCollapsed">
				<ul class="nav navbar-nav">
					<li class="active"><a href="home">Home</a></li>
					<li><a href="images">Images</a></li>
					<li><a href="news">News</a></li>
					<li><a href="about">About</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-search"></span> Search</a>
						<ul class="dropdown-menu">
							<li class="text-center">Search by date</li>
							<li><input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close">
          						<span class="input-group-btn">
										<button type="button" class="btn btn-default" ng-click="open1()"><i class="glyphicon glyphicon-calendar"></i></button>
									</span></li>
							<li><input type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="popup2.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close">
									<span class="input-group-btn">
										<button type="button" class="btn btn-default" ng-click="open2()"><i class="glyphicon glyphicon-calendar"></i></button>
									</span></li>
							<li class="text-center"><button type="button" class="btn btn-sm btn-info" ng-click="search()">Search</button></li>
						</ul>
			</div>
		</div>
	</nav>
</header>

