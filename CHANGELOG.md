#Changelog

This is not a full changelog, but just to keep a lil bit of a track

##Version 0.5.3
- Fixed bug that was causing methods with underscored names not to be validated
- Checks if files were submitted prior to execute add_post_files
- Improves error messaging on files submission

##Version 0.5.2
- Custom routes can be defined to remap class/method requests
- Fixed some issues that were throwing a warning

##Version 0.5.0
- Method Url::full_path_to() will return full path to database objects
- Config file can define some configurations with $config[]
- Moved non configurable code to settings.php
- Moved settings.php to the config directory, to help prevent system directory to be edited by developers
- Added new core class Router, which improves the good ol' routing system
- Removed config/routing.php as useless

##Version 0.4.6
- Fix bug that was causing images not to be attached to a post and resized when description field was empty
- Fixed bug that was redirecting user before post model could return field errors
- Improved error reporting in post forms
- Improved JS add_img_fields

##Version 0.4.5
- Improved JS to add img fields. Add a counter to limit number of new fields
- Rm old cms->find() for AR finder
- Now cms->add() and cms->edit() check if magic_quotes are On and stripslashes input before inserting it in the database
- Removed PHP 5.4 array syntax for better compatibility with cheap hostings
- Lowercased all file names

##Version 0.4.4
- Added new Cms method add_post_files(), which centralizes file uploading and resizing when creating or editing a post
- Closes issue #6 (lighter controllers)

##Version 0.4.3
- Fixes bug #1 (couldn't upload files when no categories were selected)
- Cms post forms only show existing categories

##Version 0.4.2
- Related media has been removed from posts table, and a parent field added to the medias table
- Adapted uploads code to the new DB schema.
- Fixes bug #7 (uploading multiples files when editing a post)

##Version 0.4.1
- Support for two level sections (parent and one child)
- Fixed bug that was storing post sections by id instead of the proper meta identifier

##Version 0.4
- Created a Lang model according to AR
- Langs are usable now
- Can add new languages to your site

##Version 0.3
- Posts can upload multiple images (closes issue #8). It will get the post title, content and description as its own.
- Improved some styling

##Version 0.2
- Posts can upload an image. It will get the post title, content and description as its own. 

##Version 0.1
Safanòria was born. People was excited.