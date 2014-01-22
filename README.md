# CSV Module for Kohana Framework

A Kohana framework module to help reading and writing CSV file.

This module wraps parsecsv from http://code.google.com/p/parsecsv-for-php/ 

## How to use

### Reading CSV file

Below is a typical example how to read csv file.

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

You can also set custom delimiter, enclosure, etc in the config or directly in the code like example below

	$csv = CSV::factory('file.csv', array(
			'delimiter'   => ';', // Use comma delimiter
			'has_titles'  => FALSE, // Assume csv does not has titles
		));

### Writing CSV file

Below is a typical example how to write csv file.

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

How to append CSV file

	CSV::factory('file.csv')
		->values(array('donna', '25'))
		->values(array('jade', '23'))
		->save(TRUE);

### Misc

Set encoding

	CSV::factory('file.csv')
		->encode('UTF-16', 'UTF-8');

Make user download csv file

	CSV::factory('file.csv')
		->titles(array('name', 'age'))
		->values(array('erick', '25'))
		->values(array('john', '32'))
		->send_file();

### License
The MIT License (MIT)

Copyright (c) 2013 Erick Hartanto

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.