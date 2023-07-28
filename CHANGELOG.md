# Change Log
All notable changes to this project will be documented in this file.
test

## [2.1.4] - 2023-07-28 
 
### Added
 
### Changed

- Updated dashboard UI
 
### Fixed

- Better edge case handling


## [2.1.3] - 2023-05-10
 
### Added
 
### Changed
 
### Fixed

- Trim trailing '/' from imported urls


## [2.1.2] - 2023-05-10
 
### Added
 
### Changed
 
### Fixed

- Fix binding RedirectRepository to DataRepository causing 404


## [2.1.1] - 2023-05-10
 
### Added
 
### Changed

- Improved import process
 
### Fixed


## [2.1.0] - 2023-05-09
 
### Added

- Update Script to migrate old redirects
 
### Changed
 
### Fixed


## [2.0.0] - 2023-05-09

``` bash
composer require surgems/redirect-urls
```
 
### Added

- Redirects stored as individual rows in Stache
- Helpful Redirect facade to create redirects
 
### Changed

- Imported CSV's are not saved anymore
- redirect-urls.yaml in public folder rendered useless
 
### Fixed

- Can add new redirects without erasing old ones


## [1.2.4] - 2022-05-30
 
### Added
 
### Changed

- CP Nav layout and styling
- Refactored code
 
### Fixed

- Url formatter handles full URL's


## [1.2.1] - 2022-05-30
 
### Added
 
### Changed

- Changed location of the redirects database file
 
### Fixed


## [1.2] - 2022-05-29
 
### Added

- CSV Importer
- Redirect Urls CP Nav
 
### Changed

- Removed the hardcoded array
- Use YAML instead of PHP arrays to store redirects
 
### Fixed


## [1.1.1] - 2022-05-27
 
### Added
 
### Changed
 
### Fixed

- Use __statamic.web__ middleware group instead of __web__ as it was interfering with image requests.


## [1.1] - 2022-05-27
 
### Added

- Add function to format URL's.
 
### Changed
  
- Updated middleware handler to account for duplicate urls (with '/page' and '/page/' being duplicates).
- Removed the use of custom web routes - just uses middleware instead.
 
### Fixed

 
## [Release] - 2022-05-26

``` bash
composer require surgems/redirect-urls:1.x
```
 
### Added
- Initial release of the Statamic addon
 
### Changed
 
### Fixed