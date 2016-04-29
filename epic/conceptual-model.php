<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Conceptual Model</title>
	</head>
	<body>
		<header>
			<h1>Conceptual Model</h1>
		</header>
		<main>
			<p>This app will initially load a splash page containing a highlight feed of the most recent images and article headlines. A bar across the page will display essential weather info, clickable to show the full set of current data. The main page will also contain a simplified menu offering direct access to images and articles.<br>
			The images page will contain an option to view the featured images. It will be searchable by sol, Earth date, and camera. The articles page will be searchable by source and keywords.</p>
			<h2>User</h2>
			<ul>
				<li>social media login</li>
				<li>userID</li>
			</ul>
			<h2>Images</h2>
			<ul>
				<li>title of image</li>
				<li>Image ID</li>
				<li>image description</li>
				<li>camera used</li>
				<li>Earth date picture was taken on</li>
				<li>sol (Mars day) date picture was taken on</li>
			</ul>
			<h2>News</h2>
			<ul>
				<li>article ID</li>
				<li>source</li>
				<li>article date</li>
			</ul>
			<h1>Relations</h1>
			<h2>User</h2>
			<ul>
				<li>user may favorite image - leads to favoriteImage</li>
				<li>user may favorite article - leads to favoriteArticle</li>
				<li>user may comment on article - leads to commentArticle</li>
				<li>user may comment on image - leads to commentImage</li>
			</ul>
			<h2>Image</h2>
			<ul>
				<li>image may be favorited - leads to favoriteImage</li>
				<li>image may be commented on - leads to commentImage</li>
			</ul>
			<h2>News</h2>
			<ul>
				<li>article may be favorited - leads to favoriteArticle</li>
				<li>article may be commented on - leads to commentArticle</li>
			</ul>
			<h2>Weak Entities</h2>
			<h3>commentImage</h3>
			<ul>
					<li>imageId</li>
					<li>userId</li>
					<li>dateTime</li>
			</ul>

		</main>
	</body>
</html>