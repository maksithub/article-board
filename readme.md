## Requirements

- Laravel 5.8
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Java installed required

## Installation

```
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

If the OS is Windows, need to specify Java.exe installation path
Need to replace java exec command in below lines.

/routes/web.php 
```
47  exec('"C:/Program Files/Java/jre1.8.0_181/bin/java.exe" -jar '.$jar_path.' '.$userString.' 2>&1', $d_result);
...
...
76  exec('"C:/Program Files/Java/jre1.8.0_181/bin/java.exe" -jar '.$jar_path.' '.$userString.' 2>&1', $d_result);
```

