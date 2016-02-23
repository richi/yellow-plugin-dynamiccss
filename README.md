DynamicCss plugin 0.1.1
=======================

A (very) small CSS preprocessor. It implements SCSS style variables for your css file(s).

Variables are a way to store information that you want to reuse in a stylesheet. Change the value of a variable and all the instances where it is used will update automatically.

Variables have to be declared and initialized:

	$default-margin: 1em;
	$text-color: #222;
	$border-color: #bbb;

Later on they can be used:

	blockquote {
		margin: $default-margin;
		color: $text-color;
		border-left: 4px solid $border-color;
	}

How to install?
---------------
1. Download and install [Yellow](https://github.com/datenstrom/yellow/).  
2. Download [dynamiccss.php](dynamiccss.php?raw=true), copy it into your `system/plugins` folder. 
3. Use $variables in the .css file(s) in your `system/themes` folder.  

If you are already using the command line plugin version 0.6.3 or later you are done.

To get it to work with the old command line plugin (v 0.6.2) you need to change a few lines in the file `commandline.php` in your `system/plugins` folder.

Starting in line 217:

	function buildStaticFile($fileNameSource, $fileNameDest, $fileTypeMedia)
	{
		$statusCode = $this->yellow->toolbox->copyFile($fileNameSource, $fileNameDest, true) &&
				$this->yellow->toolbox->modifyFile($fileNameDest, filemtime($fileNameSource)) ? 200 : 500;

Change to:

	function buildStaticFile($fileNameSource, $fileNameDest, $fileTypeMedia)
	{
		$statusCode = $this->pluginCommand(array($fileNameSource, "buildStatic", $fileNameDest, $fileTypeMedia));
		if ($statusCode == 0)
		{
			$statusCode = $this->yellow->toolbox->copyFile($fileNameSource, $fileNameDest, true) &&
				$this->yellow->toolbox->modifyFile($fileNameDest, filemtime($fileNameSource)) ? 200 : 500;
		}	

To uninstall delete the plugin files.
