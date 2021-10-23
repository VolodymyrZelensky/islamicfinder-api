# islamicfinder-api
*Unofficial* Api for islamicfinder.org

### install
```
$ composer require composer require lil-nickel/islamicfinder-api
```

### example
```php
require_once __DIR__.'/vendor/autoload.php';

use LilNickel\IslamicFinder;
$IslamicFinderApi = new IslamicFinder();

// List all supported countries
$countries_list = $IslamicFinderApi->ListCountries(); # => array | bool

// List all supported cities in country
$cities_list = $IslamicFinderApi->ListCities('libya'); # => array | bool

// List Pray Times for entire country
$times_per_country = $IslamicFinderApi->TimesPerCountry('libya'); # => array | bool

// List Pray Times for single city in country
$times_per_city = $IslamicFinderApi->TimesPerCountry('libya', 'benghazi'); # => array | bool

```
<br/><hr/><br/>
<h1 align="center">made with ❤️ and hand craft</h1>
