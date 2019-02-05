# No futher update

# GalleryPHP
Hello,

You can do whatever you want with this project.

## Requirement

- Apache 2
- Mysql Distrib 5.7.24
- PHP >= 7.0
- The php extension Imagick is needed


## Pattern used

### Implemented
- The MVC is used for the architectural pattern
- The facade pattern is used for all the view
- The singleton pattern is used for the logger system
- The proxy pattern is used for the login system
- The factory pattern is used for the creation of picture

### Not correctly implemented
- The decorator pattern is used for applying sepia, blur and resize on picture before download


### Not implement yet
- Strategy for the package system
- Iterator for the paging
- Builder to manage the decorator


## Configuration

config.cfg is the config file, it is located in galleryPHP/config.cfg

Contain the level minimum to write in the logger file

- 0 -> DEBUG
- 1 -> INFO
- 2-> WARNING
- 3 -> ERROR


## Issue
*If you have a problem with the upload check the php.ini file*

Maximum allowed size for uploaded files.
upload_max_filesize = 40M

Must be greater than or equal to upload_max_filesize
post_max_size = 40M

*There is a hard-coded value in a query inside the file galleryPHP/Controller/loginSystem/signupSystem.php in the private function createUser*, 3 is the id of the defaut role for the creation of user.

Enjoy

Author : Hugues Audoux
