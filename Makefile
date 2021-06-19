
# COMPOSER
COMPOSER        = $(EXEC_PHP) composer.phar

composer_install:
	@COMPOSER install

composer_update:
	@COMPOSER update

# SASS
sass_dev:
	@sass --watch assets/css/style.scss assets/css/style.css

sass_production:
	@sass assets/css/game.scss assets/css/game.min.css --style compressed