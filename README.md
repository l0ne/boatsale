# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###


Test task for js dev

Should be generated users (can be random 10-15) with simple user interface.

Need to create boat ordering form with different parameters:

Boat type – names randomly generated (3-5)

Boat size- sizes can be randomly generated (4-6)

Boat price- randomly generated price points (5-10)

Boat status- available, not booked, booked

User should be able to choose boat type and size and see total Boat price on display. After boat is ordered should be possibility, to add other users to the boat. As soon as user accepts invite, boat price should be split between users.

Each user need to get notification on his user page and accept or decline.

By default boat status should be available.

If users accept the tab, boat is in status "booked".

If users decline the tab, boat should be in status "not booked"

If boat booking is cancelled, boat status should change back to "available

Need to create function / algorightm and you do not need to create any luxurious user interface or something. Simply Drop Down with the parameters, taken from db (fields – Users , Boats). The difficult part is the user session.

### How do I get set up? ###

    bower install
    npm install
    cp cfg/config_orig.json cfg/config.json and set database params

For nginx:

    location /api/ {                       
      try_files $uri $uri/ /api/index.php;
    }

For Apache .htaccess:

    <IfModule mod_rewrite.c> 
    RewriteEngine On
    RewriteCond %{REQUEST_URI} ^/api/ [NC]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ api/index.php [QSA,L]
    </IfModule>