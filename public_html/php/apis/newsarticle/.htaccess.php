<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteCond %{REQUEST_ACCESS} !-f
	RewriteCond %{REQUEST_ACCESS} !-d
	RewriteRule ^/?(\d+)?$ ?id=$&%{QUERY_STRING}
</IfModule>