[production]
phpSettings.display_startup_errors = 0
phpSettings.display_errors = 0
includePaths.library = APPLICATION_PATH "/../library"
bootstrap.path = APPLICATION_PATH "/Bootstrap.php"
bootstrap.class = "Bootstrap"
appnamespace = "Application"
resources.frontController.controllerDirectory = APPLICATION_PATH "/controllers"
resources.frontController.params.displayExceptions = 0
resources.layout.layoutPath = APPLICATION_PATH "/layouts/scripts/"
resources.db.adapter       = "PDO_MYSQL"
resources.db.params.host   = "localhost"
resources.db.params.charset = "utf8"

[staging : production]

[testing : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1

[development : production]
phpSettings.display_startup_errors = 1
phpSettings.display_errors = 1
resources.frontController.params.displayExceptions = 1

; Database connection
resources.db.params.dbname = "indiskt"
resources.db.params.username   = "indiskt"
resources.db.params.password   = "mVd4W0mX"

