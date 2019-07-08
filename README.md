# alisimbiPhp

### First steps to take to initialize Passengine without errors  


*1. Create a database*

*2. Open /includes/config.php*

*3. Update the fields highlighted below*


`define('DB_PREFIX', '');	` 

`$SETT['dbhost'] = 'localhost'; `

`$SETT['dbuser'] = 'root'; `

`$SETT['dbpass'] = 'friendship1A@'; `

`$SETT['dbname'] = 'alisimbi';`

You should be all set to run Passengine
Feel free to modify other values on the config.php but be carefull

### Creating a new page
*1. Create a new `.php` file with your prefered name in the `/controller/` dir. All your php codes willgo into this page (Recomended: Duplicate the default page and simply rename the file as desired)*

*2. Create a new directory in `/templates/html/` the name should match the `.php` file you created earlier*

*3. Create a new `.html` file in the new directory you just created name it `content.html`*

*4. When you want to declare a variable go to the `.php` file you created in step 1 and declare the variable like `$PTMPL['good_music'] = 'David Gueretta'`*

*5. Go to the .html file you created in step 3 and call the variable like {$good_music}. Your page specific html, css and javascripts should go into this file, you can add static content by just adding them here also without needing to create a variable*

### Global variables and templates
*- Any variable declared on the `index.php` file found on the root directory can be called from any other page*

*- Likewise any html, css, javascripts and static content declared in the `container.html` file found in the `templates/html` dir would be visible from any other page*

###Getting the country list
The country list is important to the smooth functioning of the program now
To install *Simply run the `locale.sql` file that is in the root dir*

###Getting the newly created databases
To install the newly created Databases run the `alisimbi.sql` file that is at the root dir

###Not seeing some HTML?
Check the corresponding controller file for the page you are currently working on

###Special HTML Cases
*1. The course and modules boxes HTML can be found in the `includes/classes_extenstion.php` file, simply do a search for `course and modules boxes HTML`*