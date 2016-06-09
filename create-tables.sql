DROP TABLE IF EXISTS FavoriteNewsArticle;
DROP TABLE IF EXISTS CommentNewsArticle;
DROP TABLE IF EXISTS FavoriteImage;
DROP TABLE IF EXISTS CommentImage;
DROP TABLE IF EXISTS NewsArticle;
DROP TABLE IF EXISTS Image;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS LoginSource;

CREATE TABLE LoginSource (
	loginSourceId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	loginSourceProvider VARCHAR(128) NOT NULL,
	PRIMARY KEY(loginSourceId)
);

CREATE TABLE User (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userEmail VARCHAR(128),
	userLoginId INT UNSIGNED NOT NULL,
	userProviderKey VARCHAR(96) NOT NULL,
	userName VARCHAR(128) NOT NULL,
	INDEX(userName),
	UNIQUE(userEmail),
	INDEX (userLoginId),
	FOREIGN KEY (userLoginId) REFERENCES LoginSource(loginSourceId),
	PRIMARY KEY(userId)
);

CREATE TABLE Image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageCamera VARCHAR(64) NOT NULL,
	imageDescription VARCHAR(5000),
	imageEarthDate DATETIME NOT NULL,
	imagePath VARCHAR(256) NOT NULL,
	imageSol SMALLINT UNSIGNED,
	imageTitle VARCHAR(128) NOT NULL,
	imageType VARCHAR(10) NOT NULL,
	imageUrl VARCHAR(256) NOT NULL,
	INDEX(imageCamera),
	INDEX(imageEarthDate),
	INDEX(imageSol),
	UNIQUE(imagePath),
	UNIQUE(imageUrl),
	PRIMARY KEY(imageId)
);

CREATE TABLE NewsArticle (
	newsArticleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	newsArticleTitle VARCHAR(128) NOT NULL,
	newsArticleDate DATETIME NOT NULL,
	newsArticleSynopsis VARCHAR(256) NOT NULL,
	newsArticleUrl VARCHAR(256) NOT NULL,
	INDEX(newsArticleDate),
	INDEX(newsArticleSynopsis),
	UNIQUE(newsArticleUrl),
	PRIMARY KEY(newsArticleId)
);

CREATE TABLE CommentImage (
	commentImageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentImageContent VARCHAR(1024) NOT NULL,
	commentImageDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	commentImageImageId INT UNSIGNED NOT NULL,
	commentImageUserId INT UNSIGNED NOT NULL,
	INDEX(commentImageImageId),
	INDEX(commentImageUserId),
	FOREIGN KEY(commentImageImageId) REFERENCES Image(imageId),
	FOREIGN KEY(commentImageUserId) REFERENCES User(userId),
	PRIMARY KEY(commentImageId)
);

CREATE TABLE FavoriteImage (
	favoriteImageImageId INT UNSIGNED NOT NULL,
	favoriteImageUserId INT UNSIGNED NOT NULL,
	favoriteImageDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX(favoriteImageImageId),
	INDEX(favoriteImageUserId),
	FOREIGN KEY(favoriteImageImageId) REFERENCES Image(imageId),
	FOREIGN KEY(favoriteImageUserId) REFERENCES User(userId),
	PRIMARY KEY(favoriteImageImageId, favoriteImageUserId)
);

CREATE TABLE CommentNewsArticle (
	commentNewsArticleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentNewsArticleContent VARCHAR(1024) NOT NULL,
	commentNewsArticleDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	commentNewsArticleNewsArticleId INT UNSIGNED NOT NULL,
	commentNewsArticleUserId INT UNSIGNED NOT NULL,
	INDEX(commentNewsArticleNewsArticleId),
	INDEX(commentNewsArticleUserId),
	FOREIGN KEY(commentNewsArticleNewsArticleId) REFERENCES NewsArticle(newsArticleId),
	FOREIGN KEY(commentNewsArticleUserId) REFERENCES User(userId),
	PRIMARY KEY(commentNewsArticleId)
);

CREATE TABLE FavoriteNewsArticle (
	favoriteNewsArticleNewsArticleId INT UNSIGNED NOT NULL,
	favoriteNewsArticleUserId INT UNSIGNED NOT NULL,
	favoriteNewsArticleDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX(favoriteNewsArticleNewsArticleId),
	INDEX(favoriteNewsArticleUserId),
	FOREIGN KEY(favoriteNewsArticleNewsArticleId) REFERENCES NewsArticle(newsArticleId),
	FOREIGN KEY(favoriteNewsArticleUserId) REFERENCES User(userId),
	PRIMARY KEY(favoriteNewsArticleNewsArticleId, favoriteNewsArticleUserId)
);