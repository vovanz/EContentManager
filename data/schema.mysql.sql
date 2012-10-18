CREATE TABLE tbl_project (
    pid INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pweight INTEGER,
    ptime INTEGER,
    pname VARCHAR(128),
    ptype VARCHAR(128)
);

CREATE TABLE tbl_component(
    cid INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pid INTEGER NOT NULL,
    ctype VARCHAR(128),
    cweight INTEGER,
    is_main BOOL NOT NULL DEFAULT  '0'
);

CREATE TABLE tbl_text (
    cid INTEGER NOT NULL,
    text LONGTEXT
);

CREATE TABLE tbl_textandimage (
    cid INTEGER NOT NULL,
    image_pos VARCHAR(128),
    text LONGTEXT
);

CREATE TABLE tbl_file (
    fid INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fpath VARCHAR(128)
);

CREATE TABLE tbl_image (
    cid INTEGER NOT NULL,
    fid INTEGER,
    iweight INTEGER,
    alt VARCHAR(128),
    title VARCHAR(128),
    annotation TEXT
);

CREATE TABLE tbl_filecomp (
    cid INTEGER NOT NULL,
    fid INTEGER
);

CREATE TABLE tbl_gallery (
    cid INTEGER NOT NULL,
    gallery_type VARCHAR(128)
);

CREATE TABLE tbl_color (
    cid INTEGER NOT NULL,
    code VARCHAR(128)
);

CREATE TABLE IF NOT EXISTS `tbl_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientname` varchar(128) DEFAULT NULL,
  `phone` varchar(128) DEFAULT NULL,
  `text` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;