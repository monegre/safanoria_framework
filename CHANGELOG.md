#Changelog

This is not a full changelog, but just to keep a lil bit of a track

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