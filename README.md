# No Longer Maintained
Please use [PHP Google Holidays](https://github.com/stephenlake/php-google-holidays) instead!

## Usage

```php
$instance = new \Google\Holidays();

$holidays = $instance->withApiKey('<your-google-calendar-api-key>')
                     ->inCountry('<country-abbreviation>')
                     ->list();
```
Sample Output: See https://developers.google.com/calendar/v3/reference/events/list

## Additional Usage

**Return only `name` and `date`**
```php
$holidays = $instance->withApiKey('<your-google-calendar-api-key>')
                     ->inCountry('US')
                     ->withMinimalOutput()
                     ->list();
```
**Sample Output**
```
[
  "name": "A holiday",
  "date": "2018-01-01"
],
[
  "name": "Another holiday",
  "date": "2018-02-01"
]
```

**Return only dates**
```php
$holidays = $instance->withApiKey('<your-google-calendar-api-key>')
                     ->inCountry('UK')
                     ->withDatesOnly()
                     ->list();
```

**Sample Output**
```
[
  "2018-01-01",
  "2018-02-01",
  "2018-03-15"
]
```
