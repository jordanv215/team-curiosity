DROP TABLE IF EXISTS favoriteNewsArticle;
DROP TABLE IF EXISTS commentNewsArticle;
DROP TABLE IF EXISTS favoriteImage;
DROP TABLE IF EXISTS commentImage;
DROP TABLE IF EXISTS newsArticle;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS loginSource;

CREATE TABLE loginSource (
	loginSourceId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	loginSourceApiKey VARCHAR(256) NOT NULL,
	loginSourceProvider VARCHAR(128) NOT NULL,
	PRIMARY KEY(loginSourceId)
);

CREATE TABLE user (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userEmail VARCHAR(128) NOT NULL,
	userLoginId INT UNSIGNED NOT NULL,
	userName VARCHAR(128) NOT NULL,
	INDEX(userName),
	UNIQUE(userEmail),
	INDEX (userLoginId),
	FOREIGN KEY (userLoginId) REFERENCES loginSource(loginSourceId),
	PRIMARY KEY(userId)
);

CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageCamera VARCHAR(64) NOT NULL,
	imageDescription VARCHAR(5000),
	imageEarthDate DATETIME NOT NULL,
	imagePath VARCHAR(256) NOT NULL,
	imageSol SMALLINT UNSIGNED NOT NULL,
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

CREATE TABLE newsArticle (
	newsArticleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	newsArticleDate DATETIME NOT NULL,
	newsArticleSynopsis VARCHAR(256) NOT NULL,
	newsArticleUrl VARCHAR(256) NOT NULL,
	INDEX(newsArticleDate),
	INDEX(newsArticleSynopsis),
	UNIQUE(newsArticleUrl),
	PRIMARY KEY(newsArticleId)
);

CREATE TABLE commentImage (
	commentImageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentImageContent VARCHAR(1024) NOT NULL,
	commentImageDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	commentImageImageId INT UNSIGNED NOT NULL,
	commentImageUserId INT UNSIGNED NOT NULL,
	INDEX(commentImageImageId),
	INDEX(commentImageUserId),
	FOREIGN KEY(commentImageImageId) REFERENCES image(imageId),
	FOREIGN KEY(commentImageUserId) REFERENCES user(userId),
	PRIMARY KEY(commentImageId)
);

CREATE TABLE favoriteImage (
	favoriteImageImageId INT UNSIGNED NOT NULL,
	favoriteImageUserId INT UNSIGNED NOT NULL,
	favoriteImageDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX(favoriteImageImageId),
	INDEX(favoriteImageUserId),
	FOREIGN KEY(favoriteImageImageId) REFERENCES image(imageId),
	FOREIGN KEY(favoriteImageUserId) REFERENCES user(userId),
	PRIMARY KEY(favoriteImageImageId, favoriteImageUserId)
);

CREATE TABLE commentNewsArticle (
	commentNewsArticleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentNewsArticleContent VARCHAR(1024) NOT NULL,
	commentNewsArticleDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	commentNewsArticleNewsArticleId INT UNSIGNED NOT NULL,
	commentNewsArticleUserId INT UNSIGNED NOT NULL,
	INDEX(commentNewsArticleNewsArticleId),
	INDEX(commentNewsArticleUserId),
	FOREIGN KEY(commentNewsArticleNewsArticleId) REFERENCES newsArticle(newsArticleId),
	FOREIGN KEY(commentNewsArticleUserId) REFERENCES user(userId),
	PRIMARY KEY(commentNewsArticleId)
);

CREATE TABLE favoriteNewsArticle (
	favoriteNewsArticleNewsArticleId INT UNSIGNED NOT NULL,
	favoriteNewsArticleUserId INT UNSIGNED NOT NULL,
	favoriteNewsArticleDateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX(favoriteNewsArticleNewsArticleId),
	INDEX(favoriteNewsArticleUserId),
	FOREIGN KEY(favoriteNewsArticleNewsArticleId) REFERENCES newsArticle(newsArticleId),
	FOREIGN KEY(favoriteNewsArticleUserId) REFERENCES user(userId),
	PRIMARY KEY(favoriteNewsArticleNewsArticleId, favoriteNewsArticleUserId)
);