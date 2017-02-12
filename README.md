# noprobLAN Website

Dieses Repo soll die aktuelle Website _npl.ch_ enthalten.

## Dependencies

* PHP 5.3
* Zend Framework 1.11

## Development Setup

### Eclipse
1. Install [Eclipse PDT](https://www.eclipse.org/pdt/)
2. Install and run [XAMPP](https://www.apachefriends.org/download.html). Some times there are problems with Skype running on port 80/443. In that case you need to start Skype after XAMPPs Apache. 
3. Use git to fetch this repo, e.g.: `git clone https://github.com/noproblan/npl-website.git` - you can also use ssh. If you're not the shell-kind-of-guy you can use [TortoiseGit](https://code.google.com/p/tortoisegit/) or the [Eclipse Plugin EGit](https://www.eclipse.org/egit/).
4. Go to [http://localhost/phpmyadmin](https://localhost/phpmyadmin) and create a database named `npl`, for example with this query:<br/>`CREATE DATABASE IF NOT EXISTS npl;`
5. Run the SQL queries in `db/migrations` on the database.
6. Run the SQL queries on `db/seeds.sql` to initialize the application with some important and some nice-to-have data.
7. Create a database user named `npl` all rights on the database `npl`, for example with the following query:
   <pre>CREATE USER 'npl'@'localhost' IDENTIFIED BY 'XXXXXXXXXXXXX';
GRANT USAGE ON *.* TO 'npl'@'localhost' IDENTIFIED BY 'XXXXXXXXXXXXX' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON npl.* TO 'npl'@'localhost';</pre>
8. Now the website should be accessible under [http://localhost/npl-website/public/www/](http://localhost/npl-website/public/www/).

### PHPStorm
* ...

### Manual setup of AMPP on Mac OS X Yosemite
There is already a lot of documentation on the internet, I recommend to use [this guide](http://coolestguidesontheplanet.com/get-apache-mysql-php-phpmyadmin-working-osx-10-10-yosemite/)

### Docker

Install docker and then run

    bin/setup

This copies the INIs if necessary and builds the container.
Run the container like that:

    bin/run

Then you can open the webpage under http://localhost/public/www


## Deployment
For deploying the master branch to production use `bash scripts/deploy_prod.sh USER@HOST` from your developer machine.

