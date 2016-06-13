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
				<!--script>
					$('.navbar li').click(function(e) {
						$('.navbar li.active').removeClass('active');
						var $this = $(this);
						if (!$this.hasClass('active')) {
							$this.addClass('active');
						}
						e.preventDefault();
					});
				</script-->
				<ul class="nav navbar-nav menu">
					<li><a href="home">Home</a></li>
					<li><a href="images">Images</a></li>
					<li><a href="news">News</a></li>
					<li><a href="about">About</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-search"></span>&nbsp;Search</a>

						<div class="dropdown-menu">
							<div class="nav-search-container">
								<form>
									<div class="form-group">
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup ng-model="dt" is-open="popup2.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" ng-click="open2()"><i class="glyphicon glyphicon-calendar"></i></button>
							</span>
										</div>
									</div>

									<div class="form-group">
										<button type="button" class="btn btn-sm btn-info" ng-click="search()">Search</button>
									</div>
								</form>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>

