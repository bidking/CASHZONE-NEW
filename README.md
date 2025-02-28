# crud-laravel-10
 A simple crud application with all the basic features you have to know.

## Features
  1. Image Uplaod
  2. Password encoder
  3. Pagination links
  4. Flash messages
  5. Error pages to handle error code such as 404, 500 etc.

## Technolgies Used 
  1. PHP (8.2)
  2. Laravel-10
  3. Blade templating engine
  4. MySQL database
  5. Bootstrap 5
  6. Developed in Visual studio code
  
## Screenshots
### Users
<div style="display: flex;flex-direction: column; grid-gap: 10px;">
    <div style="display: flex; grid-gap: 10px;">
        <img src="screenshots/s1.png" alt="screenshots" width="49%" style="border: 2px solid lightgreen"/>
        <img src="screenshots/s2.png" alt="screenshots" width="49%" style="border: 2px solid lightgreen"/>
    </div>
    <div style="display: flex; grid-gap: 10px;">
        <img src="screenshots/s3.png" alt="screenshots" width="49%" style="border: 2px solid lightgreen"/>
        <img src="screenshots/s4.png" alt="screenshots" width="49%" style="border: 2px solid lightgreen"/>
    </div>
     <div style="display: flex; grid-gap: 10px;">
        <img src="screenshots/s5.png" alt="screenshots" width="49%" style="border: 2px solid lightgreen"/>
    </div>
</div>
<br>

## HOW TO USE?

 Step-1: **[Install Composer](https://getcomposer.org/)** <br>
 Step-2: **[Install PHP and MySQL OR simply xampp](https://www.apachefriends.org/download.html)**<br>
 Step-3: create database schema for curd-application - to do that simply locate the directory using terminal and run the given command
 
 ```bash
    php artisan migrate
 ```

this will create the database schema for you.<br>
[Note- if you have custom username or password for the database ? you need to update the project configurations. you can edit them in .env file (this file is located in project folder and not visible - to update this you need to open the folder with any advance text editor like visual studio code)]
<br><br>
Step-4: after creating schema you are ready to serve this application - on the project folder open terminal and run following command <br>

 ```bash
    php artisan serve
 ```
<br>
After running this command application start running you can see the application by visiting this url - http://127.0.0.1:8000/<br>


## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.



