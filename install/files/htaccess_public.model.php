<?php

<IfModule mod_rewrite.c>
RewriteEngine On
 
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
 
# Rewrite all other URLs to index.php/URL
RewriteRule ^(.*)$ index.php?url=$1 [PT,L]

</IfModule>

<IfModule !mod_rewrite.c>
	ErrorDocument 404 index.php
</IfModule>

#ErrorDocument 404 /views/404.php