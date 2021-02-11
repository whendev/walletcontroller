<?php
// DATA BASE AND HOST
define("CONF_DB_HOST", $_ENV["CONF_DB_HOST"]);
define("CONF_DB_NAME", $_ENV["CONF_DB_DATABASE"]);
define("CONF_DB_USER", $_ENV["CONF_DB_USER"]);
define("CONF_DB_PASS", $_ENV["CONF_DB_PASSWORD"]);


// MESSAGE
define("CONF_MESSAGE_CLASS","alert alert-dismissible fade show");
define("CONF_MESSAGE_SUCCESS","alert-success");
define("CONF_MESSAGE_INFO","alert-primary");
define("CONF_MESSAGE_ERROR","alert-danger");
define("CONF_MESSAGE_WARNING","alert-warning");


// PROJECT URLs
define("CONF_URL_BASE","http://walletcontroller.com");
define("CONF_URL_TEST","http://localhost:8080");
define("CONF_URL_ADMIN","/admin");

// VIEW
define("CONF_VIEW_PATCH", __DIR__."/../themes");
define("CONF_VIEW_THEME", "walletweb");
define("CONF_VIEW_APP", "walletapp");
define("CONF_VIEW_EXT", "php");

// PASSWORD
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTIONS", ["cost" => 10]);

// UPLOAD
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR","images");
define("CONF_UPLOAD_FILE_DIR","files");
define("CONF_UPLOAD_MEDIA_DIR","medias");

// IMAGES
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR."/".CONF_UPLOAD_IMAGE_DIR."/cache");
define("CONF_IMAGE_SIZE",2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

// SITE
define("CONF_SITE_NAME","WalletController");
define("CONF_SITE_TITLE", "Gerencie suas contas com o WalletController");
define("CONF_SITE_DESC", "O WalletController é um gerenciador de contas simples, poderoso e gratuito. O prazer de ter o controle total de suas contas.");
define("CONF_SITE_LANG","pt-BR");
define("CONF_SITE_DOMAIN","walletcontroller.com");

define("CONF_DATE_BR", "d-m-Y");
define("CONF_DATE_APP", "d-m-Y");

// EMAIL
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", 'tls');
define("CONF_MAIL_OPTION_CHARSET", 'utf-8');
define("CONF_MAIL_SENDER", ["address" => $_ENV["CONF_MAIL_SENDER_ADDRESS"], "name" => $_ENV["CONF_MAIL_SENDER_NAME"]]);
define("CONF_MAIL_SUPPORT", $_ENV["CONF_MAIL_SUPPORT"]);

define("CONF_MAIL_HOST", $_ENV["CONF_MAIL_HOST"]);
define("CONF_MAIL_PORT", $_ENV["CONF_MAIL_PORT"]);
define("CONF_MAIL_USER", $_ENV["CONF_MAIL_USER"]);
define("CONF_MAIL_PASS", $_ENV["CONF_MAIL_PASS"]);