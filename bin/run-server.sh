#!/usr/bin/env bash

APP_DIR="$PWD" php -d display_errors -S localhost:8000 -t public/ -d auto_prepend_file="$PWD/vendor/autoload.php"
