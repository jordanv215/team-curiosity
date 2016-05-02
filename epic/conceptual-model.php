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
			The images page will contain an option to view the featured images. It will be searchable by sol, Earth date, and camera. The articles page will be searchable by source and keywords.</p><br>
			<h2>Entities</h2>
			<h3>loginSource</h3>
			<ul>
				<li>loginSourceId</li>
				<li>loginSourceApiKey</li>
				<li>loginSourceProvider</li>
			</ul>
			<h3>user</h3>
			<ul>
				<li>userId</li>
				<li>userEmail</li>
				<li>userLoginId</li>
				<li>userName</li>
			</ul>
			<h3>image</h3>
			<ul>
				<li>imageId</li>
				<li>imageCamera</li>
				<li>imageDescription</li>
				<li>imageEarthDate</li>
				<li>imagePath</li>
				<li>imageSol</li>
				<li>imageTitle</li>
				<li>imageType</li>
				<li>imageUrl</li>
			</ul>
			<h3>newsArticle</h3>
			<ul>
				<li>newsArticleId</li>
				<li>newsArticleDate</li>
				<li>newsArticleSynopsis</li>
				<li>newsArticleUrl</li>
			</ul>
			<h3>commentImage</h3>
			<ul>
				<li>commentImageId</li>
				<li>commentImageContent</li>
				<li>commentImageDateTime</li>
				<li>commentImageImageId</li>
				<li>commentImageUserId</li>
			</ul>
			<h3>favoriteImage</h3>
			<ul>
				<li>favoriteImageImageId</li>
				<li>favoriteImageUserId</li>
				<li>favoriteImageDateTime</li>
			</ul>
			<h3>favoriteNewsArticle</h3>
			<ul>
				<li>favoriteNewsArticleNewsArticleId</li>
				<li>favoriteNewsArticleUserId</li>
				<li>favoriteNewsArticleDateTime</li>
			</ul>
			<h3>commentNewsArticle</h3>
			<ul>
				<li>commentNewsArticleId</li>
				<li>commentNewsArticleContent</li>
				<li>commentNewsArticleDateTime</li>
				<li>commentNewsArticleNewsArticleId</li>
				<li>commentNewsArticleUserId</li>
			</ul><br>
			<h2>Relations</h2>
			<h3>loginSource</h3>
			<ul>
				<li>authenticates user</li>
			</ul>
			<h3>User</h3>
			<ul>
				<li>user may favorite image - leads to favoriteImage</li>
				<li>user may favorite article - leads to favoriteNewsArticle</li>
				<li>user may comment on article - leads to commentNewsArticle</li>
				<li>user may comment on image - leads to commentImage</li>
			</ul>
			<h3>Image</h3>
			<ul>
				<li>image may be favorited - leads to favoriteImage</li>
				<li>image may be commented on - leads to commentImage</li>
			</ul>
			<h3>News</h3>
			<ul>
				<li>article may be favorited - leads to favoriteNewsArticle</li>
				<li>article may be commented on - leads to commentNewsArticle</li>
			</ul>
		</main>
	</body>
</html>