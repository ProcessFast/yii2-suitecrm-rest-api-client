SuiteCRM / SugarCRM REST API Client for Yii2 - Connect your Yii2 app to a SuiteCRM / SugarCRM instance
===============================================================
This extension provides the AWS SDK 3 integration for the Yii2 framework

[![Latest Stable Version](https://poser.pugx.org/packages/processfast/yii2-suitecrm-rest-api-client/v/stable)](https://packagist.org/packages/processfast/yii2-suitecrm-rest-api-client) [![Total Downloads](https://poser.pugx.org/processfast/yii2-suitecrm-rest-api-client/downloads)](https://packagist.org/packages/processfast/yii2-suitecrm-rest-api-client) [![Latest Unstable Version](https://poser.pugx.org/processfast/yii2-suitecrm-rest-api-client/v/unstable)](https://packagist.org/packages/processfast/yii2-suitecrm-rest-api-client) [![License](https://poser.pugx.org/processfast/yii2-suitecrm-rest-api-client/license)](https://packagist.org/packages/processfast/yii2-suitecrm-rest-api-client)

Contents
--------
1.About
2.Installation
3.Yii2 Configuration
4.Usage Example
5.Notes
6.get_note_attachment() Example
7.set_note_attachment() Example

1.About
-------
- PHP wrapper class for interacting with a SugarCRM REST API
- Creating, reading, and updating capability
- More info on SuiteCRM: https://suitecrm.com/
- More info on SugarCRM: http://www.sugarcrm.com/
- API docs: http://developers.sugarcrm.com/
- Designed to work with SuiteCRM / SugarCRM v.6


2.Installation
--------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
    php composer.phar require --prefer-dist processfast/yii2-suitecrm-rest-api-client "*"
```

or add

```
    "processfast/yii2-suitecrm-rest-api-client": "*"
```

to the require section of your `composer.json` file.


3.Yii2 Configuration
--------------------


To use this extension, simply add the following code in your application configuration:


```php
return [
    //....
    'components' => [
        'suitecrm' => [
            'class' => 'processfast\suitecrm\SuiteCrmRestApi',
            'rest_url' => 'https://mysuitecrm.com/service/v2/rest.php',
            'username' => 'your-crm-username', 
            'password' => 'your-crm-password'
        ],
    ],
];
```

4.Usage Example
---------------

Example Snippet:

```php
    $suiteCrm = Yii::$app->suitecrm;

    $suiteCrm->connect();

    $error = $suiteCrm->get_error();

    if($error !== FALSE) {
        return $error['name'];
    }

    $results = $suiteCrm->get_with_related("Accounts", 
                                            array("Accounts" => array('id','name'), 
                                            "Cases" => array('id','status')));
    $suiteCrm->print_results($results);
```

5.Notes
-------
- The `is_valid_id()` function may need to modify for different versions
of SugarCRM.
- Different versions of SugarCRM have different ID formats.


6.get_note_attachment() Example
-------------------------------
>This example outputs the contents of a note's attachment, given the
>note ID. Assumes $note_id contains the ID of the note you wish to modify.

	$suiteCrm = Yii::$app->suitecrm;
    $suiteCrm->connect();

	$result = $suiteCrm->get_note_attachment($note_id);
	$filename = $result['note_attachment']['filename'];
	$file = $result['note_attachment']['file'];

	$file = base64_decode($file);
	header("Cache-Control: no-cache private");
	header("Content-Description: File Transfer");
	header('Content-disposition: attachment; filename='.$filename);
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: '. strlen($file));
	echo $file;
	exit;


6.set_note_attachment() Example
-------------------------------
>This example illustrates how to set a note's attachment from an html form.
>Assumes $note_id contains the ID of the note you wish to modify.

### HTML Code
	<form method="post" action="example.php" enctype="multipart/form-data">
    	<input name="note_file" type="file" />
  		<input type="submit" value="Go" />
	</form>

### PHP Code (example.php)
	$suiteCrm = Yii::$app->suitecrm;
    $suiteCrm->connect();


	if ($_FILES["note_file"]["error"] > 0) {
    	// Error: $_FILES["file"]["error"]
	} else if(isset($_FILES['note_file']['tmp_name']) && $_FILES['note_file']['tmp_name']!="") {
		$handle = fopen($_FILES['note_file']['tmp_name'], "rb");
		$filename = $_FILES['note_file']['name'];
		$contents = fread($handle, filesize($_FILES['note_file']['tmp_name']));
		$binary = base64_encode($contents);
		$file_results = $sugar->set_note_attachment($note_id,$binary,$filename);
	}

7.get_available_modules() Example
---------------------------------
>This example illustrates how to get the available modules in SuiteCRM/SugarCRM.  All of them.
>This is a handy function to use when building future proof SuiteCRM/SugarCRM plugins.
>

### PHP Code (example.php)
	$suiteCrm = Yii::$app->suitecrm;
	$modules = $suiteCrm->get_available_modules();
>BAM! Now loop through the array that was returned and stored in $modules.  You could use this
>to display a dropdown in the admin panel that displays all modules a user would want to connect your
>sugarcrm plugin to.