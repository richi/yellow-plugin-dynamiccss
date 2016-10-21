DynamicCss plugin 0.1.3
=======================

A (very) small CSS preprocessor. It implements SCSS style variables for your css file(s).

Variables are a way to store information that you want to reuse in a stylesheet. Change the value of a variable and all the instances where it is used will update automatically.

Variables have to be declared and initialised:

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
1. [Download and install Yellow](https://github.com/datenstrom/yellow/).
2. [Download plugin](https://github.com/richi/yellow-plugin-dynamiccss/archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `master.zip` into your `system/plugins` folder.
4. Use $variables in the .css file(s) in your `system/themes` folder.  

To uninstall delete the plugin files.
