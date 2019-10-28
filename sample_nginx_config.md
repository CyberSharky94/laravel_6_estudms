# For more information on configuration, see:
#   * Official English Documentation: http://nginx.org/en/docs/
#   * Official Russian Documentation: http://nginx.org/ru/docs/

# Below is a sample configuration for NGINX running on CentOS 8
# Main Changes: # Setting for Test Laravel, # Setting for Test Laravel, # Setting for Laravel_6_EStudMS
# This config file has been tested on VMWare Workstation, CentOS 8, NGINX 1.14, PHP 7.3.11, PostgreSQL 12

user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log;
pid /run/nginx.pid;

# Load dynamic modules. See /usr/share/doc/nginx/README.dynamic.
include /usr/share/nginx/modules/*.conf;

events {
    worker_connections 1024;
}

http {
    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';

    access_log  /var/log/nginx/access.log  main;

    sendfile            on;
    tcp_nopush          on;
    tcp_nodelay         on;
    keepalive_timeout   65;
    types_hash_max_size 2048;

    include             /etc/nginx/mime.types;
    default_type        application/octet-stream;

    # Load modular configuration files from the /etc/nginx/conf.d directory.
    # See http://nginx.org/en/docs/ngx_core_module.html#include
    # for more information.
    include /etc/nginx/conf.d/*.conf;

    server {
        listen       80 default_server;
        listen       [::]:80 default_server;
        server_name  _;
        root         /usr/share/nginx/html;

        # Load configuration files for the default server block.
        include /etc/nginx/default.d/*.conf;

        location / {
            # URLs to attempt, including pretty ones.
            try_files $uri $uri/ /index.php?q=$uri&$args;
        }

        # Remove trailing slash to please routing system.
        if (!-d $request_filename) {
            rewrite     ^/(.+)/$ /$1 permanent;
        }

        # Setting for Test Laravel
        location ^~ /test_laravel {
            alias /usr/share/nginx/html/test_laravel/public;
            try_files $uri $uri/ @test_laravel;

            location ~ \.php {
                fastcgi_pass unix:/var/run/php-fpm/www.sock;
                fastcgi_split_path_info ^(.+\.php)(.*)$;
                fastcgi_param SCRIPT_FILENAME /usr/share/nginx/html/test_laravel/public/index.php;
                include fastcgi_params;
            }
        }

        location @test_laravel {
            rewrite /test_laravel/(.*)$ /test_laravel/index.php?/$1 last;
        }
        # END: Setting for Test Laravel

        # Setting for Laravel_6_EStudMS
        location ^~ /laravel_6_estudms {
            alias /usr/share/nginx/html/laravel_6_estudms/public;
            try_files $uri $uri/ @laravel_6_estudms;

            location ~ \.php {
                fastcgi_pass unix:/var/run/php-fpm/www.sock;
                fastcgi_split_path_info ^(.+\.php)(.*)$;
                fastcgi_param SCRIPT_FILENAME /usr/share/nginx/html/laravel_6_estudms/public/index.php;
                include fastcgi_params;
            }
        }

        location @laravel_6_estudms {
            rewrite /laravel_6_estudms/(.*)$ /laravel_6_estudms/index.php?/$1 last;
        }
        # END: Setting for Laravel_6_EStudMS

        error_page 404 /404.html;
            location = /40x.html {
        }

        error_page 500 502 503 504 /50x.html;
            location = /50x.html {
        }

        # PHP FPM configuration.
        location ~* \.php$ {
            fastcgi_pass                        unix:/var/run/php-fpm/www.sock;
            include             				fastcgi_params;
            fastcgi_index           			index.php;
            fastcgi_split_path_info     		^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO     		$fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED 		$document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME 		$document_root$fastcgi_script_name;
        }

        # We don't need .ht files with nginx.
        location ~ /\.ht {
            deny all;
        }

        # Set header expirations on per-project basis
        location ~* \.(?:ico|css|js|jpe?g|JPG|png|svg|woff)$ {
            expires 365d;
        }
    }

# Settings for a TLS enabled server.
#
#    server {
#        listen       443 ssl http2 default_server;
#        listen       [::]:443 ssl http2 default_server;
#        server_name  _;
#        root         /usr/share/nginx/html;
#
#        ssl_certificate "/etc/pki/nginx/server.crt";
#        ssl_certificate_key "/etc/pki/nginx/private/server.key";
#        ssl_session_cache shared:SSL:1m;
#        ssl_session_timeout  10m;
#        ssl_ciphers PROFILE=SYSTEM;
#        ssl_prefer_server_ciphers on;
#
#        # Load configuration files for the default server block.
#        include /etc/nginx/default.d/*.conf;
#
#        location / {
#        }
#
#        error_page 404 /404.html;
#            location = /40x.html {
#        }
#
#        error_page 500 502 503 504 /50x.html;
#            location = /50x.html {
#        }
#    }

}

