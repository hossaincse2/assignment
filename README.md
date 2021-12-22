### Wedevs Assignment Docker Setup
// create and start containers
##### docker-compose up
// start services with detached mode
##### docker-compose -d up
// start specific service
##### docker-compose up <service-name>
// list images
##### docker-compose images
// list containers
##### docker-compose ps
// start service
##### docker-compose start
// stop services
##### docker-compose stop
// display running containers
##### docker-compose top
// kill services
##### docker-compose kill
// remove stopped containers
##### docker-compose rm
// stop all contaners and remove images, volumes
##### docker-compose down

### Project run requirement
 Working Environment : Linux
 
 Php version: 7.4+
 
 Node Version: 17.0.3
 
 Project Tools: Laravel, Vuejs 3, Postman for api documentation

### Project Api Setup
// Project composer command 
##### composer install 
// In project .env file setup its database 
 
Every midnight at 12:00AM, all the delivered orders should be moved to a separate “deliveries” table for this pint please run 
 
##### php artisan delivery:cron
 
please setup this

##### /public_html/artisan schedule:run >> /dev/null 2>&1

// Project run command
##### php artisan server
 
#### Admin Credentials
user: admin@gmail.com
password: 12345678

See demo  http://assignmentapi.hossainme.com

### Project Frontend Setup 

##### npm install   
// Project run command
##### npm run dev
// Project production build command
##### npm run --prod build 

See demo  http://assignment.hossainme.com
