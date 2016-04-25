# dbWebGen-demo - Demo App for dbWebGen

This is the demo app for [dbWebGen](https://github.com/eScienceCenter/dbWebGen). First follow the setup steps there. Then:
* Clone this repository into any folder that is served by your web server.
* Adjust the `ENGINE_PATH` constant in `index.php` to point to the folder where in which you cloned the dbWebGen repository.
* Create a PostgreSQL database called `demo` on your localhost
* Run the SQL script in [demo_db.sql](demo_db.sql) on that database
* Direct your browser to the target folder and log in with user `test` and password `test`