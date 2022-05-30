# Change Log
All notable changes to this project will be documented in this file.

## [1.2.1] - 2022-05-30

``` bash
composer require surgems/redirect-urls
```
 
### Added
 
### Changed

- Changed location of the redirects database file
 
### Fixed


## [1.2] - 2022-05-29

``` bash
composer require surgems/redirect-urls:1.2
```
 
### Added

- CSV Importer
- Redirect Urls CP Nav
 
### Changed

- Removed the hardcoded array
- Use YAML instead of PHP arrays to store redirects
 
### Fixed


## [1.1.1] - 2022-05-27

``` bash
composer require surgems/redirect-urls:1.1.1
```
 
### Added
 
### Changed
 
### Fixed

- Use __statamic.web__ middleware group insted of __web__ as it was interfering with image requests.


## [1.1] - 2022-05-27

``` bash
composer require surgems/redirect-urls:1.1
```
 
### Added

- Add function to format URL's.
 
### Changed
  
- Updated middleware handler to account for duplicate urls (with '/page' and '/page/' being duplicates).
- Removed the use of custom web routes - just uses middleware instead.
 
### Fixed

 
## [Release] - 2022-05-26

``` bash
composer require surgems/redirect-urls:1.0
```
 
### Added
- Initial release of the Statamic addon
 
### Changed
 
### Fixed
