<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_CSV {

  protected $_config;
  protected $_csv;
  protected $_filename;
  private $_rows = array();
  private $_titles = array();

  /**
   * CSV Class constructor
   * 
   * @param   string   filename
   * @param   array    CSV config
   * @return  CSV
   */
  public function __construct($filename, array $config = array())
  {
    // Load config
    $this->_config = $config + (array) Kohana::$config->load('csv');

    require_once Kohana::find_file('vendor/parsecsv', 'parsecsv.lib');

    $this->_csv = new parseCSV();
    $this->_csv->delimiter = $this->_config['delimiter'];
    $this->_csv->enclosure = $this->_config['enclosure'];
    $this->_csv->linefeed = $this->_config['linefeed'];
    $this->_csv->heading = $this->_config['has_titles'];

    $this->_filename = $filename;

    return $this;
  }

  /**
   * Create and return new CSV class
   *
   * 		// Create new CSV class and use semi colon delimiter
   * 		$csv = CSV::factory('file.csv', array('delimiter' => ';'));
   *
   * @param   string   filename
   * @param   array    CSV config
   * @return  CSV
   */
  public static function factory($filename, array $config = array())
  {
    return new CSV($filename, $config);
  }

  /**
   *  Convert character encoding
   *
   * 		$rows = CSV::factory('file.csv')
   * 			->encode('UTF-16', 'UTF-8')
   * 			->parse()
   *      ->rows();
   *
   * @param   string   input character encoding, uses default if left blank
   * @param   string   output character encoding, uses default if left blank
   * @return  CSV
   */
  public function encode($input = NULL, $output = NULL)
  {
    $this->_csv->encoding($input, $output);
    return $this;
  }

  /**
   *  Parse CSV file, you need to use another function rows() or titles() to get the rows
   *
   * @return  CSV
   */
  public function parse()
  {
    // Parse the csv
    $this->_csv->parse($this->_filename);
    // Get the titles
    $this->_titles = $this->_csv->titles;
    // Get the rows
    $this->_rows = $this->_csv->data;

    return $this;
  }

  /**
   *  Set or get CSV column titles. Leave blank to get titles. 
   * 	If you need to get titles, make sure you do it after calling parse() function.
   *
   * 		// Set titles example
   * 		CSV::factory('file.csv')
   * 			->titles(array('Name', 'Address', 'Telephone'));
   * 
   * 		// Get titles example
   * 		$titles = CSV::factory('file.csv')
   *      ->parse()
   *      ->titles();
   *
   * @param   array   array of title
   * @return  mixed   CSV or array
   */
  public function titles(array $titles = array())
  {
    if ($titles)
    {
      $this->_titles = $titles;
      return $this;
    }
    else
    {
      return $this->_titles;
    }
  }

  /**
   *  Set or get CSV rows (without titles). Leave blank to get rows. 
   * 	If you need to get rows, make sure you do it after calling parse() function.
   * 
   *  Return 2D array of rows with row number and title as the key of the array
   *
   * 		// Set rows example
   * 		CSV::factory('file.csv')
   * 			->rows($array);
   * 
   * 		// Get rows example
   * 		$rows = CSV::factory('file.csv')
   *      ->parse()
   *      ->rows();
   * 
   *    foreach ($rows as $row)
   *    {
   *      echo $row['name'];
   *    }
   *
   * @param   array   2D array
   * @return  mixed   CSV or 2D array with row number and title as the key of the array
   */
  public function rows(array $rows = array())
  {
    if ($rows)
    {
      $this->_rows = $rows;
      return $this;
    }
    else
    {
      return $this->_rows;
    }
  }

  /**
   *  Set CSV row
   *
   * 		// Set rows using values example
   * 		CSV::factory('file.csv')
   *      ->titles(array('name', 'age'))
   * 			->values(array('erick', '25'))
   *      ->values(array('john', '32'))
   *      ->save();
   * 
   * @param   array   Row values
   * @return  CSV
   */
  public function values(array $values)
  {
    $this->_rows[] = $values;
    return $this;
  }

  /**
   *  Save CSV file
   *
   * 		CSV::factory('file.csv')
   *      ->titles(array('name', 'age'))
   * 			->values(array('erick', '25'))
   *      ->values(array('john', '32'))
   *      ->save();
   * 
   * @param   boolean   Append rows into file instead create new or overwrite, default is false.
   * @return  CSV
   */
  public function save($append = FALSE)
  {
    $this->_csv->save($this->_filename, $this->_rows, $append, $this->_titles);

    return $this;
  }

  /**
   *  Make user download csv file
   *
   * 		CSV::factory('file.csv')
   *      ->titles(array('name', 'age'))
   * 			->values(array('erick', '25'))
   *      ->values(array('john', '32'))
   *      ->send_file();
   * 
   * @return  CSV
   */
  public function send_file()
  {
    $this->_csv->output($this->_filename, $this->_rows, $this->_titles, $this->_csv->delimiter);
    exit();
  }

}
