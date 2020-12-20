# CS50 Final Project - Football viewer 

This final project is a simple football statistics viewer. It contains of three main sections which are Players, 
Matches, Table and additional section for login as admin. On the website we can follow matches results, general team statistics and 
look at the player details which can be modified if logged as admin.

Technologies used:

    Server side: 
        - php
        - apache(xampp)
    Database:
        - mysql
    Front End:
        - JavaScript
        - Vue
        - Vue Material Theme
    

## Description
    The API server is written in php and it is managing requests to database where all the data is stored such as player details, matches, teams, admin details etc.
    Vue for front end  is responsible of reperesenting reqested data to the user.

## How to use
1. Download project code `https://github.com/szymonwartalowicz/footballviewer.git`
2. Setup an api server:
    1. Install xampp package (`https://www.apachefriends.org/index.html`) on your machine 
    2. Copy project files to htdocs folder (default location on Ubuntu is '/opt/lampp/htdocs')
    3. Start server by typing in terminal: 'sudo /opt/lampp/lampp start'
    4. Setup database:
        1. Go to `http://localhost/phpmyadmin/` in your browser
        2. Create new database 'footballapidb'
        3. Import football data from 'footballdb.sql' available in project folder  
3. Check that you have Node version 8+ and npm
4. In new folder install vue-material theme from `https://www.npmjs.com/package/vue-material` typing on Ubuntu 
    'npm install vue-material --save' 
3. Replace 'src' folder in vue-material with 'src' folder from 'the project/frontend/src' directory
4. Install vuex by typing 'npm install vuex --save' in Ubuntu terminal 
5. Run website typing 'npm run serve' in terminal
6. You are ready to go!

# Requirements

    xampp,
    npm,
    vue,
    vuex
    vue-material theme 