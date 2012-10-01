<?php

<IfModule mod_rewrite.c>
	Options +FollowSymlinks
	RewriteEngine On
	RewriteBase /
	# Adaptive-Images -----------------------------------------------------------------------------------
	
	# Add any directories you wish to omit from the Adaptive-Images process on a new line, as follows:
	# RewriteCond %{REQUEST_URI} !ignore-this-directory
	RewriteCond %{REQUEST_URI} !resources/app
	
	# Don't apply the AI behaviour to images inside AI's cache folder:
	RewriteCond %{REQUEST_URI} !ai-cache
	
	# Send any GIF, JPG, or PNG request that IS NOT stored inside one of the above directories
	# to adaptive-images.php so we can select appropriately sized versions
	
	RewriteRule \.(?:jpe?g|gif|png)$ app/libraries/adaptive-images.php
	
	# END Adaptive-Images -------------------------------------------------------------------------------

    RewriteRule    ^$    public/    [L]
    RewriteRule    (.*) public/$1   [L]
</IfModule>