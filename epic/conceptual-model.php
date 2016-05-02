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
				<li>loginSourceProvider</li>
				<li>loginSourceApiKey</li>
				<li>loginSourceUserId</li>
				<li>loginSourceUserName</li>
				<li>loginSourceUserEmail</li>
			</ul>
			<h3>user</h3>
			<ul>
				<li>userLoginId</li>
				<li>userName</li>
				<li>userEmail</li>
			</ul>
			<h3>image</h3>
			<ul>
				<li>imageTitle</li>
				<li>imageId</li>
				<li>imageDescription</li>
				<li>imageCamera</li>
				<li>imageEarthDate</li>
				<li>imageSol</li>
			</ul>
			<h3>newsArticle</h3>
			<ul>
				<li>newsArticleId</li>
				<li>newsArticleUrl</li>
				<li>newsArticleDate</li>
				<li>newsArticleSynopsis</li>
			</ul><br>
			<h2>Weak Entities</h2>
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
			</ul><br>
			<h2>Relations</h2>
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