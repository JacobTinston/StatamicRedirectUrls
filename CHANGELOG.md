# Change Log
All notable changes to this project will be documented in this file.
 
## [Release] - 2022-05-26

``` bash
composer require surgems/redirect-url:1.0
```
 
### Added
- Initial release of the Statamic addon
 
### Changed
 
### Fixed

 
## [1.1] - 2022-05-27

``` bash
composer require surgems/redirect-url
```
 
### Added

- [RedirectController.php](https://github.com/JacobTinston/StatamicRedirectUrls/blob/master/src/Controllers/RedirectController.php)
  Add function to format URL's.
 
### Changed
  
- [Handle404.php](https://github.com/JacobTinston/StatamicRedirectUrls/blob/master/src/Middleware/Handle404.php)
  Updated middleware handler to account for duplicate urls (with '/page' and '/page/' being duplicates).
- [ServiceProvider.php](https://github.com/JacobTinston/StatamicRedirectUrls/blob/master/src/ServiceProvider.php)
  Removed the use of custom web routes - just uses middleware instead.
 
### Fixed