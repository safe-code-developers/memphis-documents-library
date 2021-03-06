=== Memphis Documents Library ===
Contributors: Ian Howatson
Donate link: http://www.kingofnothing.net/
Tags: plugin,documents,memphis,bhaldie,wordpress,library,repository,files,versions, import, export
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.5
Tested up to: 4.0
Stable tag: 2.6.15

A documents library for WordPress.

== Description ==

Memphis Documents Library is a  documents library for WordPress with a robust feature set.  It is a great tool for the organization and distribution of files.

= Security Update!! =

Memphis Documents Library version *2.6.3* is an important sercurity update.  Please update your plugin as soon as possible.

= What's New With Version 2.6 =

* *New* - Added a Dutch Translation thanks to DK for all the hard work.
* *New* - Added more safety check for lost of data.
* *New* - Moved Memphis Document Library post into there own custom post type.
* *New* - Ability to hide and show the share button.
* *New* - Added Finnish language support, thanks to *sloworks* for their hard work.
* *New* - The ability to allow/deny user types access to Private Posts. 
* *New* - In the setting menu you can now choose the allowed file types.
* *New* - A restore defaults option has been added this will restore Memphis Documents Library to its factory state, *WARNING all files and post will be deleted*.
* *Update* - Removed the category mdocs-media.
* *Update* - reduced the number of tags.
* *Update* - Updated localization files.
* *Update* - Uninstall will not remove all saved variables , posts, files, categories, and directories for a single WordPress Site and also WordPress Multisite.
* *Update* - Change the way date modified is handle, was using an array value now using file date modifed attribute.
* *Update* - Updated localization files.
* *Update* - Added a slug name to the custom post recreating function.
* *Update* - Changed the google docs link to google drive.
* *Update* - Fixed the SAMEORIGIN error when using google doc preview.  Now should work for http and https.
* *Update* - English loc file has been updated with new language.
* *Update* - Categories are now called Folder, no functionality change just name change.
* *Bug* - Fixed bug that caused pages not to load.
* *Bug* - Error with javascript loading, if using WordPress Multisite network admin.
* *Bug* - Fixed issue where Post Status was not displaying any statuses.
* *Bug* - Batch upload was cutting of filenames with dots in them.
* *Bug* - Fixed bug causing new installs to produce errors, these errors would correct themselves but very annoying for users to see.
* *Bug* - Removed extra label tag in sort box which was cause issues in Firefox.
* *Bug* - Fixed Chrome bug, where file types that are allowed in WordPress are being blocked by Memphis Documents Library.
* *Bug* - Fixed a bug when creating categories a null category would be created that could not be delete.
* *Bug* - Fixed the XSS (Cross Site Scripting) issues root cause was using $_REQUEST inside a form.
* *Bug* - Fixed the sercuirty vulnerabilities known as LFI/RFI, which stands for Local or Remote File Inclusion.
* *Bug* - Fixed bug which didn't allow for viewing sub categories when using mdocs short codes.  This short code currently only works on main categories you can't target a subcategory to display.
* *Bug* - Fixed Bulk uploader not allowing for editing of name.
* *Bug* - Fixed Event Manger issues when using Memphis Documents.
* *Bug* - Fixed Dashboard Large View not working.
* *Bug* - Fixed notices errors.
* *Bug* - Fixed extra tr error.
* *Bug* - Fixed issue where text was not being put in the right place on a mDocs list, now content will display as published on all mDocs lists.
* *Bug* - Fixed error if file was not found.
* *Bug* - Fixed Batch Upload naming issue.
* *Bug* - Added a missing div tag to list.
* *Bug* - Added the ability to see document previews when logged in.
* *Bug* - Fixed some category issues.

= Memphis Documents Library Features =

* Batch Upload of files into the system (Beta)
* Upload media files that match WordPress's white-list. This white-list is configurable from the WordPress menus.
* Download tracking of media
* Posts created for each new media upload, showing information of the specific file.
* Version control, allows you to view and revise to older version of your file.
* The ability to share you files on other websites.
* Referential file methodology. This allows for the updating of a file while the link remains the same.
* Importing of document libraries into your current library, or just migrating to another website.
* Exporting you documents libraries for safe backup and store, migration to another website or sharing with someone else.
* The ability to create, edit and delete categories and subcategories.
* Search for files using the WordPress search.
* Customization of download button

== Frequently Asked Questions ==

= 404 Error when trying to access document page =

If you get a 404 error when trying to access your Memphis documents pages try going to Setting>Permalinks and pressing Save.  This may solve the issue, if it doesn't please contact me for more support.

= Mempihs Documents Library look wrong in IE =

Add the following code to your theme right under the `<head>` tag this will turn off compatibility mode for IE.
`<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7; IE=EDGE" />`

= Document Preview not displaying content =

Error while viewing files in Memphis Documents Library - "You've reached the bandwidth limit for viewing or downloading files that aren't in Google Docs format. Please try again later".

Memphis Documents Library uses Google Docs to display the files including PDF, DOC and XLS within the browser. If you are having trouble viewing files and you are logged into your Google account, it could be bandwidth limit on that account. There is no bandwidth limit in Memphis Documents Library and in most cases refreshing the page will display the file.

If the message persists, please try signing out of Google, and then try viewing the file again in Memphis Documents Library. This should make you anonymous to Google and avoid the bandwidth limitation.

To sign out of Google, You can use the link below:

<https://accounts.google.com/Logout>

The error is based upon these limits set by Google for each account and here's the link to Google's bandwidth limit page:

<https://support.google.com/a/answer/1071518?hl=en>

= Importing Into Memphis Documents Library =

There are two type of imports you can choose from.

**Keep Existing Saved Variables**

* Is the safest way to import.  This option keeps all your current files and only imports new ones. 
If a file that is being imported matches one on the current system, the one on the current system will be left untouched,
and you will have to manually import these files.

**Overwrite Saved Variables**

* Is a good when you have a empty documents library or you at looking to refresh your current library.  
This method deletes all files, posted and version on the current system. After the method has completed you will
get a list of all the conflicts that have occurred make note of them.
Please take great care in using this method as there is little to no return.

= Exporting Out of Memphis Documents Library =

When you click the export button the document library will create a ZIP files for you to save to your computer.
This compressed data, will contain your documents, saved variables, media and posts tied to each document.
Once you've saved the download file, you can use the Import function in another WordPress installation to import the content from this site.

= Uninstalling Mempihs Documents Library =

When you uninstall the documents library make sure you export all your important files. **All data will be removed on completion of uninstall, this includes files, directories, posts, and media.**

== Installation ==

From the WordPress plugin menu click on Add New and search for Memphis Documents Library

Instead of searching for a plugin you can directly upload the plugin zip file by clicking on Upload:

Use the browse button to select the plugin zip file that was downloaded, then click on Install Now. The plugin will be uploaded to your blog and installed. It can then be activated.

Once uploaded the configuration menu is located in either the "Memphis" menu with the heading of "Documents" in the Dashboard or in the "Memphis Docs" menu. 

== Screenshots ==

1. screenshot-1.png 
2. screenshot-2.png
3. screenshot-3.png
4. screenshot-4.png
5. screenshot-5.png
6. screenshot-6.png
7. screenshot-7.png

== Changelog ==
= 2.6.15 =
* *New* - Added a Dutch Translation thanks to DK for all the hard work.
= 2.6.14 =
* *Update* - English loc file has been updated with new language.
* *Update* - Categories are now called Folder, no functionality change just name change.
* *Bug* - Fixed some category issues.
= 2.6.13 =
* *Update* - Fixed the SAMEORIGIN error when using google doc preview.  Now should work for http and https.
= 2.6.12 =
* minor update to google preview.
= 2.6.11 =
* *Feature* - Added more safety check for lost of data.
* *Update* - Changed the google docs link to google drive.
= 2.6.10 =
* *Update* - Added a slug name to the custom post recreating function.
* *Bug* - Added the ability to see document previews when logged in.
= 2.6.9 =
* *Bug* - Fixed Batch Upload naming issue.
* *Bug* - Added a missing div tag to list.
= 2.6.8.1 =
* *Bug* - Fixed notices errors.
* *Bug* - Fixed extra tr error.
* *Bug* - Fixed issue where text was not being put in the right place on a mDocs list, now content will display as published on all mDocs lists.
= 2.6.8 =
* *Bug* - Fixed Bulk uploader not allowing for editing of name.
* *Bug* - Fixed Event Manger issues when using Memphis Documents.
* *Bug* - Fixed Dashboard Large View not working.
= 2.6.7.1 =
* *Bug* - Fixed bug that caused pages not to load.
= 2.6.7 =
* *Update* - Removed the category mdocs-media.
* *Update* - reduced the number of tags.
* *Update* - Minor fixes.
= 2.6.6 =
* *Feature* - Moved Memphis Document Library post into there own custom post type.
* *Feature* - Ability to hide and show the share button.
* *Bug* - Fixed mime type bug, where mime types where not being removed properly.
* *Bug* - Fixed issue with post always showing mDocs at the top of the post.  Now it behaves as expected.
* *Bug* - Fixed bug preventing the preview window from opening.
= 2.6.5 =
* *Feature* - Added Finnish language support, thanks to *sloworks* for their hard work.
= 2.6.4 =
* *Bug* - Fixed bug which didn't allow for viewing sub categories when using mdocs short codes.  This short code currently only works on main categories you can't target a subcategory to display.
= 2.6.3 =
* *Bug* - Fixed sercuirty issues using $_REQUEST inside a form.
* *Bug* - Fixed sercuirty issue Local or Remote File Inclusion.
= 2.6.2 =
* *Bug* - Fixed a bug when creating categories a nul category would be created that could not be delete.
= 2.6.1 =
* *Update* - Change the way date modified is handle, was using an array value now using file date modifed attribute.
* *Update* - Updated localization files.
* *Bug* - Fixed Chrome bug, where file types that are allowed in WordPress are being blocked by Memphis Documents Library.
= 2.6 =
* *New* - The ability to allow/deny user types access to Private Posts. 
* *New* - In the setting menu you can now choose the allowed file types.
* *New* - A restore defaults option has been added this will restore Memphis Documents Library to its factory state, *WARNING all files and post will be deleted*.
* *Update* - Updated localization files.
* *Update* - Uninstall will not remove all saved variables , posts, files, categories, and directories for a single WordPress Site and also WordPress Multisite.
* *Bug* - Error with javascript loading, if using WordPress Multisite network admin.
* *Bug* - Fixed issue where Post Status was not displaying any statuses.
* *Bug* - Batch upload was cutting of filenames with dots in them.
* *Bug* - Fixed bug causing new installs to produce errors, these errors would correct themselves but very annoying for users to see.
* *Bug* - Removed extra label tag in sort box which was cause issues in Firefox.
= 2.5.1.2 =
* *Bug* - Fixed loop bug, when a Memphis Documents post does not have the category mdocs-media.  Now the result will be an output of the shortcode only.
* *Bug* - Permalink setting fixed. Sub categories where not working when set to default WordPress permalink setting.
* *Bug* - Javascript error with FireFox and IE.  A undefined `event.preventDefault();` was causing Add Main Category to no function.  Removing this line fixed the issue.
= 2.5.1.1 =
* *Hot-Fix* - Added the style.css file to the admin page. Now the page will display the correct style.
= 2.5.1 =
* *Fix* - Removed style.php and replaced it with style.css and used the WordPress function `wp_add_inline_style` to handle custom stylesheet changes.
* *Fix* - Disabled the ability to view a private post if the user does not have the capabilities to.
* *Fix* - Updated large list to reflect the addition of sub categories.
* *Fix* - Removed unnecessary padding from the category tabs.
* *Update* - Updated localization.
* *Update* - Removed the sub folder on the right side of the documents list, seems unneeded.
= 2.5 =
* *New* - You have the ability to create sub categories.
* *New* - Three new widgets have been added, you can now display, Most Downloaded, Highest Rated and Recently Updated documents.
* *Fix* -  Issue with file upload on Windows platform, now is resolved.  Batch upload still remains in beta.
* *Fix* - Minor style changes
* *Bug* - small bug fixes and updates.
= 2.4.1 =
* fixed short code, not showing categories.
* special character changes.
* lots of bug fixes
* optimization of code
= 2.4 =
* Removed IE Compatibility mode fix, this was causing too many header errors.  If you want to this functionality add this line to your theme header file, right under the `<head>` tag
 * `<meta http-equiv="X-UA-Compatible" content="IE=11; IE=10; IE=9; IE=8; IE=7; IE=EDGE" />`
* Add the ability to change the color of the download button.
* Fixed the rss feed bug
* Fixed a look an feel issue with the sort box
* More small fixes and updates
= 2.3.2 =
* possible hotfix to header issues
* fix of Google docs issues
* privacy and protection updates
* still working on child categories
= 2.3.1 =
* htaccess update
* htaccess file editor in settings menu
* fixed a file not found error
= 2.3 =
* Batch file upload beta
* List of available sshort codes
* Document page options added
** Default Content (Preview or Description)
** Show/Hide (Preview and Description)
= 2.2.2 =
* Minor bug fixes
* Small look and feel changes.
* Moved the language files into there own folder
= 2.2.1 =
* Changed the way preview works, added a preview button
* Added default sort options
= 2.2 =
* Added the ability to preview documents instead of a description.
* hot fix on the uninstall issue.  I hope this will solve the problem.
= 2.1.1 =
* fixed some header already sent messages.
= 2.1 =
* added a rating system
* code cleanup
* browser capability fixes
* updated the language file
= 2.0.2 =
* ie compatibility mode fix.
= 2.0.1 =
* Minor html fixes.  Thanks for the reports thibodeaux and ghalusa.
= 2.0 =
* Added a new or updated banner.
* Can now run a filesystem check to clean up and unwanted files or data.
* Can now sort files by any of the categories this sort option is saved for the session of the user.
* Restricted access to the file directory, now only Memphis Documents has access to the files.  Directory link to the files is denied.
* Added a setting menu with the following options
 * Change size of file list on both the site and dashboard
 * Hide our show certain fields of the file.
 * Hide/Show all files from everybody or just non-members
 * Hide/Show all post from everybody or just non-members
 * Hide/Show new and updated banner
 * Determine the length in days to display the new or update banner
* Updated the translation file.
= 1.4 =
* Changed the why sharing works.  Now you share the page that the file is on not the file itself.
* minor bug fixes.
= 1.3.2 =
* fixed permalink bug where the default setting would cause errors when trying to move from one category to another.
= 1.3.1 =
* small bug fixes
= 1.3 =
* Added the ability to disable social apps
* Added the ability to only allow members to download file
* Now have the ability to change the status of a file post
* Have the ability to hide/show your file.
* Changed add update dashboard control panel.
* Update po file.
= 1.2.8 =
*  Fixed broken category issue.
= 1.2.7 =
* fixed download error where the ability to download a file was broken.  This error occurring with the latest WordPress update 3.6.1. The fix was to include a WordPress file ' wp-includes/pluggable.php' that was removed from the WordPress master include list.
= 1.2.6 =
* Stylesheet changes.
=1.2.5 =
* Fixed image links in description.
= 1.2.4 =
* Fixed a compatibility bug with Memphis Custom Login.
* Removed debugging text.
= 1.2.3 =
* Fixed a compatibility bug with Memphis Custom Login.
= 1.2.2 
* Updated robots list.
= 1.2.1 =
* correct path to the mdocs-robots.txt file
= 1.2 =
* Google Plus message updated
* Twitter messages updated.
* Bot list updated
= 1.1 =
* Bots are not counted towards downloads.
* Changed style of dashboard menu.
* Minor bug fixes.
= 1.0.2 =
* Download button fix.
= 1.0.1 =
* Download button fix.
= 1.0 =
* Initial Release of Memphis Documents Library

== Upgrade Notice ==
= 1.0 =
* Initial Release of Memphis Documents Library
== Feature Request ==
* *Bug* - When there are multiple categories on a page the get request fails to recognize each individual category.
* *Feature* - The ability to change the Last Modified category of a file.
* *Feature* - Bulk Delete/Hide
* *Feature* - Bulk move
* *Feature* - Get thumbnails of the documents as the featured image for the post, as an alternative to Google Preview.
* *Feature* - Give other user types the ability to upload files.
* *Feature* - Short-code to add a download link to a post or page.
* *Feature* - Search shows only files that the specific user role has access too.
* *Feature* - Added more level to categories.
* *Feature* - Batch upload choose a category for all file before uploading them.
* *Feature* - Add a pdf preview on the description page
* *Feature* - Add a tag editor to the add/update document page.
* *Feature* - In the Media tab find a way to display the category of the documents created by Memphis Documents.
* *Feature* - Connect to Cloud Services (DropBox, SkyDrive, MediaFire, etc.)
* *Feature* - Add an option in the Settings to change the date format from default European (dd-mm-yy) to American (mm-dd-yy)
* *Feature* - Add the ability to change the path name and breadcrumb name.