### Apache version: 2.4.54

### MySQL version: 8.0.31

### Steps to config apache server before running (apply for windows OS, other OSes can be achieved with the same procedure):

**Step 1:** Fetch the source code of this repository to your local machine (example path will be C:\\example_path for better demonstation).
**Step 2:** Create `cert`, `log` and `session` directories in the project (C:\\example_path\\cert, C:\\example_path\\log and C:\\example_path\\session)
**Step 3:** Create a self-signed SSL certificate, go to `cert` directory by typing `cd cert` in the terminal and then type in this line `mkcert -key-file key.pem -cert-file cert.pem localhost 127.0.0.1 ::1 www.demo.bookstore.com` (only use for development, production must not use this step)
**Step 4:** Create three log files named `error.log`, `access.log` and `ssl_request.log` in C:\\example_path\\log
**Step 5:** Locate the apache server installation directory (for example C:\\xampp\\apache)
**Step 6:** Check for modules and includes, open `httpd.conf` file from the `conf` directory of your apache installation directory, and uncomment these lines if they are commented

```
LoadModule ssl_module modules/mod_ssl.so
Include conf/extra/httpd-vhosts.conf
Include conf/extra/httpd-ssl.conf
<IfModule ssl_module>
SSLRandomSeed startup builtin
SSLRandomSeed connect builtin
</IfModule>
```

**Step 7:** Add virtual host, open `httpd-vhosts.conf` file from the `conf\extra` directory of your apache installation directory, add the following lines

```
<VirtualHost *:443>
ServerAdmin <your email address>
DocumentRoot "C:\example_path"
ServerName www.demo.bookstore.com
#ServerAlias www.test.bookstore.com

    SSLEngine on
    SSLCertificateFile "C:\example_path\cert\cert.pem"
    SSLCertificateKeyFile "C:\example_path\cert\key.pem"

    CustomLog "C:\example_path\log\ssl_request.log" \
          "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x \"%r\" %b"

    <Directory "C:\example_path">
        #
        # Possible values for the Options directive are "None", "All",
        # or any combination of:
        #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
        #
        # Note that "MultiViews" must be named *explicitly* --- "Options All"
        # doesn't give it to you.
        #
        # The Options directive is both complicated and important.  Please see
        # http://httpd.apache.org/docs/2.4/mod/core.html#options
        # for more information.
        #
        Options Indexes FollowSymLinks Includes ExecCGI

        #
        # AllowOverride controls what directives may be placed in .htaccess files.
        # It can be "All", "None", or any combination of the keywords:
        #   AllowOverride FileInfo AuthConfig Limit
        #
        AllowOverride All

        #
        # Controls who can get stuff from this server.
        #
        Require all granted

        # Set the session save path
        php_value session.save_path "C:\example_path\session"
    </Directory>

    <IfModule dir_module>
        DirectoryIndex index.php index.pl index.cgi index.asp index.shtml index.html index.htm \
                   default.php default.pl default.cgi default.asp default.shtml default.html default.htm \
                   home.php home.pl home.cgi home.asp home.shtml home.html home.htm
    </IfModule>

    ErrorLog "C:\example_path\log\error.log"

    <IfModule log_config_module>
        #
        # The following directives define some format nicknames for use with
        # a CustomLog directive (see below).
        #
        LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
        LogFormat "%h %l %u %t \"%r\" %>s %b" common

        <IfModule logio_module>
        # You need to enable mod_logio.c to use %I and %O
        LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\" %I %O" combinedio
        </IfModule>

        #
        # The location and format of the access logfile (Common Logfile Format).
        # If you do not define any access logfiles within a <VirtualHost>
        # container, they will be logged here.  Contrariwise, if you *do*
        # define per-<VirtualHost> access logfiles, transactions will be
        # logged therein and *not* in this file.
        #
        #CustomLog "log/access.log" common

        #
        # If you prefer a logfile with access, agent, and referer information
        # (Combined Logfile Format) you can use the following directive.
        #
        CustomLog "C:\example_path\log\access.log" combined
    </IfModule>

    <Files ".ht*">
        Require all denied
    </Files>

</VirtualHost>
```

**Step 8:** Update Hosts File, go to this file `C:\Windows\System32\drivers\etc\hosts` (usually the case) and add these lines at the near bottom

```
# Map www.demo.bookstore.com to localhost
127.0.0.1 www.demo.bookstore.com
::1 www.demo.bookstore.com
```

You will need to be an administrator to apply these changes
This only apply for development stage, production stage should skip this
**Step 9:** Start apache server (by using XAMPP for example)
**Step 10:** Go to https://www.demo.bookstore.com
