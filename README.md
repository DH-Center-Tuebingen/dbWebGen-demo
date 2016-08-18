# dbWebGen-demo - Demo App for dbWebGen

This is the demo app for [dbWebGen](https://github.com/eScienceCenter/dbWebGen). It provides a web based user interface for working with data about buildings, locations and user reviews. 

## Data Model
The data model of the demo database is depicted in the following ER diagram. The SQL script to create this database is listed in  [demo_db.sql](demo_db.sql).

![ER Diagram of Demo Database](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/demo_db.png)

## Screenshots
The following are some screenshots of web pages automatically generated by the [dbWebGen](https://github.com/eScienceCenter/dbWebGen) engine for this demo database simply by providing adapting the [settings file](settings.php) to enable users create, edit, browse, search, and query records in the database. Click the thumbnails to enlarge.

[![Record List, Filtered](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/filter_buildings_th.png)](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/filter_buildings.png)  
[![Edit a Record](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/edit_location_th.png)](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/edit_location.png)  
[![Query Result Visualized as Bar Chart](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/query_bar_th.png)](https://esciencecenter.github.io/assets/dbWebGen/screenshots/demo/query_bar.png)

## Installation
First follow the [setup steps for dbWebGen](https://github.com/eScienceCenter/dbWebGen#get-it-running). 

Then:
* Clone this repository into any folder that is served by your web server.
* Adjust the `ENGINE_PATH` constant in `index.php` to point to the folder where in which you cloned the dbWebGen repository.
* Create a PostgreSQL database called `demo` on your localhost
* Run the SQL script in [demo_db.sql](demo_db.sql) on that database
* Direct your browser to the target folder and log in with user `test` and password `test`