<?php

/**
 * Class DemoTask
 *
 * 演示Task
 *
 * 演示:
 *    cd console; php cli.php -c=demo -a=hello --ENVIRON=develop name=Jacky
 */

class DemoTask extends \WPLib\Console\Task
{
	public function indexAction()
	{
		echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <title>全球油联</title>
    </head>
    <body>
        <h1>Hello World!!!</h1>
    </body>
</html>
EOT;
	}

	/**
	 * Hello World
	 *
	 * @param $argv
	 */
	public function helloAction($argv)
	{
		echo "Hello World!!!\n";
		if (isset($argv['name'])) {
			echo "Hello {$argv['name']}!!!\n";
		}
	}
}
