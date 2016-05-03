DROP TABLE IF EXISTS loginSource;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS newsArticle;
DROP TABLE IF EXISTS commentImage;
DROP TABLE IF EXISTS favoriteImage;
DROP TABLE IF EXISTS commentNewsArticle;
DROP TABLE IF EXISTS favoriteNewsArticle;

CREATE TABLE loginSource (
	loginSourceId VARCHAR(256) NOT NULL,
	loginSourceApiKey VARCHAR(256) NOT NULL,
	loginSourceProvider VARCHAR(128) NOT NULL,
	INDEX(loginSourceProvider),
	PRIMARY KEY(loginSourceId)
);

CREATE TABLE user (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userEmail VARCHAR(128) NOT NULL,
	userLoginId VARCHAR(256) NOT NULL,
	userName VARCHAR(128) NOT NULL,
	INDEX(userName),
	UNIQUE(userEmail),
	UNIQUE(userLoginId),
	PRIMARY KEY(userId)
);

CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageCamera VARCHAR(64) NOT NULL,
	imageDescription VARCHAR(5000),
	imageEarthDate DATETIME NOT NULL,
	imagePath VARCHAR(512) NOT NULL,
	imageSol TINYINT UNSIGNED NOT NULL,
	imageTitle VARCHAR(128) NOT NULL,
	imageType VARCHAR(32) NOT NULL,
	imageUrl VARCHAR(512) NOT NULL,
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
	newsArticleSynopsis CHAR(256) NOT NULL,
	newsArticleUrl VARCHAR(512) NOT NULL,
	INDEX(newsArticleDate)
	INDEX(newsArticleSynopsis),
	UNIQUE(newsArticleUrl),
	PRIMARY KEY(newsArticleId)
);

CREATE TABLE commentImage (
	commentImageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	commentImageContent VARCHAR(1024) NOT NULL,
	commentImageDateTime DATETIME NOT NULL,
	commentImageImageId INT UNSIGNED NOT NULL,
	commentImageUserId INT UNSIGNED NOT NULL,
	INDEX(commentImageDateTime),
	INDEX(commentImageImageId),
	INDEX(commentImageUserId),
	FOREIGN KEY(commentImageImageId) REFERENCES image(imageId),
	FOREIGN KEY(commentImageUserId) REFERENCES user(userId),
	PRIMARY KEY(commentImageId)
);

CREATE TABLE favoriteImage (

);

CREATE TABLE commentNewsArticle (

);