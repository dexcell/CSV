# CSV Module for Kohana Framework

A Kohana framework module to help reading and writing CSV file.

This module wraps parsecsv from http://code.google.com/p/parsecsv-for-php/ 

## How to use

### Reading CSV file

Below is a typical example how to read csv file.

```php
// Read and parse CSV file
$csv = CSV::factory('file.csv')
  ->parse();

// Get titles
$titles = $csv->titles();

// Get rows data
$rows = $csv->rows();

// Loop each rows
foreach ($rows as $row)
{
  echo $row['name'];
}
```

You can also set custom delimiter, enclosure, etc in the config or directly in the code like example below

```php
$csv = CSV::factory('file.csv', array(
    'delimiter'   => ';', // Use comma delimiter
    'has_titles'  => FALSE, // Assume csv does not has titles
  ));
```
### Writing CSV file

Below is a typical example how to write csv file.

```php
// Save CSV file into file.csv
CSV::factory('file.csv')
  ->titles(array('name', 'age'))
  ->values(array('erick', '25'))
  ->values(array('john', '32'))
  ->save();

// or save it using rows() instead of values
CSV::factory('file.csv')
  ->titles(array('name', 'age'))
  ->rows(array(
    array('erick', '25'),
    array('john', 32'),
  ))
  ->save();
```

How to append CSV file

```php
CSV::factory('file.csv')
  ->values(array('donna', '25'))
  ->values(array('jade', '23'))
  ->save(TRUE);
```

### Misc

Set encoding

```php
CSV::factory('file.csv')
  ->encode('UTF-16', 'UTF-8');
```

Make user download csv file

```php
CSV::factory('file.csv')
  ->titles(array('name', 'age'))
  ->values(array('erick', '25'))
  ->values(array('john', '32'))
  ->send_file();
```
