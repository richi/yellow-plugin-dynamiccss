<?php
// Source: https://github.com/richi/
// This file may be used and distributed under the terms of the public license.

class YellowDynamicCss
{
	const Version = "0.1.2";
	var $yellow;

	function onLoad($yellow)
	{
		$this->yellow = $yellow;
	}
	
	function onRequest($serverScheme, $serverName, $base, $location, $fileName)
	{
		$statusCode = 0;
				
		if(preg_match("/\.(css)$/", $location) && is_readable($fileName))
		{
			$statusCode = 200;
			
			$data = $this->parseFile($fileName);		
			$lastModifiedFormatted = $this->yellow->toolbox->getHttpDateFormatted(filemtime($fileName));
			@header($this->yellow->toolbox->getHttpStatusFormatted($statusCode));
			@header("Content-Type: ".$this->yellow->toolbox->getMimeContentType($fileName));
			@header("Last-Modified: ".$lastModifiedFormatted);
			echo $data;
		}

		return $statusCode;
	}

	function onCommand($args)
	{
		list($fileNameSource, $command) = $args;
		switch($command)
		{
			case "buildStatic":	$statusCode = $this->buildStaticCommand($args); break;
			default: $statusCode = 0;
		}
		return $statusCode;
	}
	
	function buildStaticCommand($args)
	{
		$statusCode = 0;
		list($fileNameSource, $command, $fileNameDest, $fileTypeMedia) = $args;
		
		if(preg_match("/\.(css)$/", $fileNameSource) && is_readable($fileNameSource))
		{
			$statusCode = 200;
			
			$data = $this->parseFile($fileNameSource);		
			$this->yellow->toolbox->createFile($fileNameDest, $data, true);

		}
		return $statusCode;
	}

	function parseFile($fileName)
	{
		$data = $this->yellow->toolbox->readFile($fileName);

		$varDefPattern = '/\$([\w\-]+)\s*:(.*?);/';
		preg_match_all($varDefPattern, $data, $matches);	
		$varArray = array_combine($matches[1], $matches[2]);
		array_walk($varArray, function(&$key, &$value) {$key = trim($key); $value = trim($value);});
	
		$data = preg_replace($varDefPattern, '', $data);
		$data = preg_replace("/[\r\n]{3,}/", "\n\n", $data);

		foreach ($varArray as $key => $value)
		{
			$data = str_replace('$'.$key, $value, $data);
		}
		
		return $data;
	}
}

$yellow->plugins->register("dynamiccss", "YellowDynamicCss", YellowDynamicCss::Version);
?>
