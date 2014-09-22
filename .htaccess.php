<IfModule mod_rewrite.c>
RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l

RewriteRule ^(.*)$ index.php/$1 [L,QSA]
</IfModule>