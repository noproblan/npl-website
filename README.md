# noprobLAN Website

Dieses Repo soll die aktuelle Website _npl.ch_ enthalten.

## Dependencies

* PHP 5.3
* Zend Framework 1.11

## Development Setup

### Eclipse
1. Install [Eclipse PDT](https://www.eclipse.org/pdt/)
2. Install and run [XAMPP](https://www.apachefriends.org/download.html). Some times there are problems with Skype running on port 80/443. In that case you need to start Skype after XAMPPs Apache. 
3. Use git to fetch this repo, e.g.: git clone https://github.com/noproblan/npl-website.git - you can also use ssh. If you're not the shell-kind-of-guy you can use [TortoiseGit](https://code.google.com/p/tortoisegit/) or the [Eclipse Plugin EGit](https://www.eclipse.org/egit/).
4. Go to [https://localhost/phpmyadmin](https://localhost/phpmyadmin) and create a database named `npl`, for example with this query:<br/>`CREATE DATABASE IF NOT EXISTS npl;`
5. Run the SQL queries in `db/migrations` on the database.
6. Run the SQL queries on `db/seeds.sql` to initialize the application with some important and some nice-to-have data.

### PHPStorm
* ...

