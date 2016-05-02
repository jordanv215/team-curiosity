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
			<h2>loginSource</h2>
			<ul>
				<li>loginSourceProvider</li>
				<li>loginSourceApiKey</li>
				<li>loginSourceUserId</li>
				<li>loginSourceUserName</li>
				<li>loginSourceUserEmail</li>
			</ul>
			<h2>user</h2>
			<ul>
				<li>userLoginId</li>
				<li>userName</li>
				<li>userEmail</li>
			</ul>
			<h2>image</h2>
			<ul>
				<li>imageTitle</li>
				<li>imageId</li>
				<li>imageDescription</li>
				<li>imageCamera</li>
				<li>imageEarthDate</li>
				<li>imageSol</li>
			</ul>
			<h2>newsArticle</h2>
			<ul>
				<li>newsArticleId</li>
				<li>newsArticleUrl</li>
				<li>newsArticleDate</li>
				<li>newsArticleSynopsis</li>
			</ul>
			<h1>Weak Entities</h1>
			<h3>commentImage</h3>
			<ul>
				<li>commentImageId</li>
				<li>commentUserId</li>
				<li>commentImageCommentId</li>
				<li>commentDateTime</li>
				<li>commentContent</li>
			</ul>
			<h3>favoriteImage</h3>
			<ul>
				<li>favoriteImageId</li>
				<li>favoriteUserId</li>
				<li>favoriteDateTime</li>
			</ul>
			<h3>favoriteNewsArticle</h3>
			<ul>
				<li>favoriteNewsArticleId</li>
				<li>favoriteUserId</li>
				<li>favoriteDateTime</li>
			</ul>
			<h3>commentNewsArticle</h3>
			<ul>
				<li>commentNewsArticleId</li>
				<li>commentNewsArticleUserId</li>
				<li>commentNewsArticleCommentId</li>
				<li>commentNewsArticleDateTime</li>
				<li>commentNewsArticleContent</li>
			</ul>
			<h1>Relations</h1>
			<h2>User</h2>
			<ul>
				<li>user may favorite image - leads to favoriteImage</li>
				<li>user may favorite article - leads to favoriteNewsArticle</li>
				<li>user may comment on article - leads to commentNewsArticle</li>
				<li>user may comment on image - leads to commentImage</li>
			</ul>
			<h2>Image</h2>
			<ul>
				<li>image may be favorited - leads to favoriteImage</li>
				<li>image may be commented on - leads to commentImage</li>
			</ul>
			<h2>News</h2>
			<ul>
				<li>article may be favorited - leads to favoriteNewsArticle</li>
				<li>article may be commented on - leads to commentNewsArticle</li>
			</ul>
		</main>
	</body>
</html>