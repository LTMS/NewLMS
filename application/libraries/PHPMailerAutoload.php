
<!-- saved from url=(0069)https://raw.github.com/Synchro/PHPMailer/master/PHPMailerAutoload.php -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<pre style="word-wrap: break-word; white-space: pre-wrap;">&lt;?php
/**
 * PHPMailer SPL autoloader.
 * PHP Version 5.0.0
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/
 * @author Marcus Bointon (coolbru) &lt;phpmailer@synchromedia.co.uk&gt;
 * @author Jim Jagielski (jimjag) &lt;jimjag@gmail.com&gt;
 * @author Andy Prevost (codeworxtech) &lt;codeworxtech@users.sourceforge.net&gt;
 * @author Brent R. Matzelle (original founder)
 * @copyright 2013 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * PHPMailer SPL autoloader.
 * @param string $classname The name of the class to load
 */
function PHPMailerAutoload($classname)
{
    //Can't use __DIR__ as it's only in PHP 5.3+
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'class.'.strtolower($classname).'.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '&gt;=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '&gt;=')) {
        spl_autoload_register('PHPMailerAutoload', true, true);
    } else {
        spl_autoload_register('PHPMailerAutoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
        PHPMailerAutoload($classname);
    }
}
</pre>
</body>
</html>
