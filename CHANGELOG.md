# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Grouping items using Field::group 
- TD::link and TD::linkPost
- Sorting capability for TD [437](https://github.com/orchidsoftware/platform/issues/437)
- Property display for page
- Added ability to change the logo [354](https://github.com/orchidsoftware/platform/issues/354)
- New command `orchid:install`

### Deprecated
- TD::name and TD::title use TD::set

### Changed
- Test migration pgsql to sqlite

### Fixed
- Require to required
- Hide the menu without children
- Deletes a file only if there are no more links [570](https://github.com/orchidsoftware/platform/issues/570)
- Users and roles use screens [579](https://github.com/orchidsoftware/platform/issues/579)
- Deleting a dashboard store [623](https://github.com/orchidsoftware/platform/issues/623)

### Removed
- Font Awesome
- Bootstrap 3 appendix
- "Delete" button by default in the image field
- String record of parameters for building a form [391](https://github.com/orchidsoftware/platform/issues/391)

## [2.2.3] - 2018-03-01
### Added
- Ukrainian language [595](https://github.com/orchidsoftware/platform/pull/595)

### Changed
- Order of items in the media, first folders then files
- Font Awesome replaced by ORCHID icons

### Fixed
- Flying icon when dragging in the menu
- Sorting menu

## [2.2.2] - 2018-02-18
### Added
- Menu validation [537](https://github.com/orchidsoftware/platform/issues/537)
- Translation of notifications

### Changed
- Jquery load replace turbolink

## [2.2.1] - 2018-02-16

### Added
- Link to attachment [525](https://github.com/orchidsoftware/platform/issues/525)

### Fixed
- Base64 URL Safe  [1](https://github.com/tabuna/tutorial_create_profile_for_orchid/issues/1)
- Double file extension  [526](https://github.com/orchidsoftware/platform/issues/526)

### Changed
- Font Awesome replaced by ORCHID icons
- config "slog" is default

### Removed
- Icon for group

## [2.2.0] - 2018-02-12
### Added
- TinyMCE toolbar #522

### Changed
- Upgrade to Laravel 5.6

### Removed
- Avatar user for database

## [2.1.3] - 2018-02-11

### Fixed
- Default value for select2 AJAX
- Hide password for field

## [2.1.2] - 2018-02-09

### Fixed
- Create of category

## [2.1.1] - 2018-02-09

### Fixed
- Display of the third level menu
- Graphs occupy a full block

## [2.1.0] - 2018-02-09

### Added
- "DIV" Layouts
- "Select" field
- "Show" key for admin menu
- Command `make:chart`
- ORCHID Icons
- Error message validate for forms. #468

### Changed
- Upgrade to Bootstrap 4.0
- Behaviors and Layouts has a separate folder
- Record fields as objects #391
- Demo "behaviors" are no longer published
- Access validation does not create multiple database queries
- Hide forms switching with their small number
- Changing the menu, no longer changing the recording number
- Color pallet for graphs
- Design of the file manager

### Deprecated
- Record string/array for fields. Use `Field::make`

### Removed
- google analytics
- robot field
- Simple line icons

## [2.0.14] - 2018-01-16

### Fixed
- Error as select menu "demo post" #457 

## [2.0.11] - 2018-01-09

### Added
- Parameter "format" for "croppie.result" #398
- Displaying old data for validation errors 

### Changed
- Remove source map `npm run production`

### Fixed
- calling relation for new object in template #394
- reset child categories when the parent is deleted

## [2.0.10] - 2017-12-29

### Fixed
- Namespace syntax
- Create empty category

## [2.0.9] - 2017-12-29
### Changed
- Optimization for parser

### Fixed
- Bug name permission for pages

## [2.0.8] - 2017-12-27
### Added 
- Input Mask

### Changed
- Section wrapper remove
- Input build named
- "Not found" message occupies the entire screen
- Error 403 to 404

### Fixed
- Bug permission for behaviors
- Style for select2
- Calling relation for new object in template #382

## [2.0.7] - 2017-12-19
### Added 
- Thai language
- Fix paginate style
- Width for table

### Changed
- Replacing `less` with` sass`
- Modifying paths `app\Http\Screens` to `app\Http\Controllers\Screens`
- Modifying paths `app\Http\Layouts` to `app\Core\Layouts`

### Fixed
- Sort argument for method Screen
- Remove publish_at from `category`


## [2.0.6] - 2017-12-10
### Added 
- Link method title and modal method
- Fix paginate style

## [2.0.5] - 2017-12-10
### Added 
- Left menu notification
- New button logout
- Added markdown fiends
- Fields picture added stub behaviors
- Fields SimpleMDE added stub behaviors

### Deprecated
- Deprecated widget Google analytics

### Removed
- Removed right notification
- Removed right menu
- Removed time picker css

### Fixed
- Video icon to file manager
- Display Area in Chrome 63  

## [2.0.4] - 2017-12-05
### Fixed
- Pagination "..." symbol
- Pagination width
- Load reflection class for Screen

## [2.0.3] - 2017-12-04
### Fixed
- Extra character
- Duplicate error message
- Category prefix
- Update install scout


## [2.0.2] - 2017-12-02
### Added
- Laravel Mix (Manifest&version)
### Fixed
- Update npm dependencies
- Message upload filed


## [2.0.1] - 2017-12-01
### Fixed
- Widget Update


## [2.0] - 2017-12-01
### Added
- Added TinyMCE
- Added support fulltext search
- Added turbolinks
### Changed
- `public` folder is no longer published
- Attachments to each model
- The ability to duplicate a file has been removed
- Removing submodules (Will be in separate packages):
    - Graphical installation
    - Backups
    - Defender
    - Viewing logs
    - Monitor
    - Robot.txt Editor
    - Scheme
    - UTM Tag Generator
    - View all php settings (Form)

### Removed
- Removing Fields
- Removing Footer
- Removing Shortcut
- Removing summernote
- Remote publication of public files, the location of this is used by the proxy controller 

##  [1.1.5] - 2017-09-12
### Added
- Added events for role assignment and deletion


## [1.1.2] - 2017-09-06
### Changed
- Fix bug create user
- Removing unused methods
- Move google analytics to widget

## [1.1.1]
### Added
- Support Laravel 5.5

## [1.1] - 2017-08-31
### Added
- Added global permission for superadmin
### Changed
- fix config display auth
- Summernote supports "media"
- Shortcut (ctrl + s) save form

## [1.0] - 2017-08-04
### Added
- Added menu badges & notifications
- Added the ability to insert js and css code
- Unit tests written

### Removed
- Removing the Content Management System
- Rename config file "content" to "platform"
- Removed auxiliary functions
- Remove unusing fields
- Remove news subscription
