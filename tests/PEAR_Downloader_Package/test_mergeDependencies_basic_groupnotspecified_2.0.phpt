--TEST--
PEAR_Downloader_Package->detectDependencies(), dependency group not specified, but groups exist
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';

$packageDir  = dirname(__FILE__)  . DIRECTORY_SEPARATOR . 'test_mergeDependencies'. DIRECTORY_SEPARATOR;
$mainpackage = $packageDir . 'main-1.0.tgz';
$sub1package = $packageDir . 'sub1-1.1.tgz';
$sub2package = $packageDir . 'sub2-1.1.tgz';

$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/main-1.0.tgz', $mainpackage);
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/sub1-1.1.tgz', $sub1package);
$GLOBALS['pearweb']->addHtmlConfig('http://www.example.com/sub2-1.1.tgz', $sub2package);

$reg = &$config->getRegistry();
$chan = $reg->getChannel('pear.php.net');
$chan->setBaseURL('REST1.0', 'http://pear.php.net/rest/');
$reg->updateChannel($chan);

$pearweb->addRESTConfig("http://pear.php.net/rest/r/main/allreleases.xml",
'<?xml version="1.0"?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>main</p>
 <c>pear.php.net</c>
 <r><v>1.0</v><s>stable</s></r>
</a>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/p/main/info.xml",
'<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>main</n>
 <c>pear.php.net</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>Main Package</s>
 <d>Main Package</d>
 <r xlink:href="/rest/r/main"/>
</p>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/main/1.0.xml",
'<?xml version="1.0"?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/main">main</p>
 <c>pear.php.net</c>
 <v>1.0</v>
 <st>stable</st>
 <l>PHP License</l>
 <m>cellog</m>
 <s>Main Package</s>
 <d>Main Package</d>
 <da>2004-09-30</da>
 <n>test</n>
 <f>639</f>
 <g>http://www.example.com/main-1.0</g>
 <x xlink:href="package.1.0.xml"/>
</r>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/main/deps.1.0.txt",
'a:2:{s:8:"required";a:2:{s:3:"php";a:2:{s:3:"min";s:5:"4.2.0";s:3:"max";s:5:"6.0.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0a1";}}s:5:"group";a:2:{s:7:"attribs";a:2:{s:4:"name";s:3:"foo";s:4:"hint";s:13:"testing group";}s:7:"package";a:2:{i:0;a:3:{s:4:"name";s:4:"sub1";s:7:"channel";s:12:"pear.php.net";s:3:"min";s:3:"1.1";}i:1;a:3:{s:4:"name";s:4:"sub2";s:7:"channel";s:12:"pear.php.net";s:3:"min";s:3:"1.1";}}}}',
'text/plain');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub1/allreleases.xml",
'<?xml version="1.0"?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>sub1</p>
 <c>pear.php.net</c>
 <r><v>1.1</v><s>stable</s></r>
</a>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/p/sub1/info.xml",
'<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>sub1</n>
 <c>pear.php.net</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>Sub Package1</s>
 <d>Sub Package1</d>
 <r xlink:href="/rest/r/sub1"/>
</p>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub1/1.1.xml",
'<?xml version="1.0"?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/sub1">sub1</p>
 <c>pear.php.net</c>
 <v>1.1</v>
 <st>stable</st>
 <l>PHP License</l>
 <m>cellog</m>
 <s>Sub Package 1</s>
 <d>Sub Package 1</d>
 <da>2004-11-10</da>
 <n>test</n>
 <f>639</f>
 <g>http://www.example.com/sub1-1.1</g>
 <x xlink:href="package.1.1.xml"/>
</r>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub1/deps.1.1.txt",
'a:1:{s:8:"required";a:3:{s:3:"php";a:2:{s:3:"min";s:5:"4.3.0";s:3:"max";s:5:"6.0.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0a1";}}}',
'text/plain');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub2/allreleases.xml",
'<?xml version="1.0"?>
<a xmlns="http://pear.php.net/dtd/rest.allreleases"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.allreleases
    http://pear.php.net/dtd/rest.allreleases.xsd">
 <p>sub2</p>
 <c>pear.php.net</c>
 <r><v>1.1</v><s>stable</s></r>
</a>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/p/sub2/info.xml",
'<?xml version="1.0" encoding="UTF-8" ?>
<p xmlns="http://pear.php.net/dtd/rest.package"    xsi:schemaLocation="http://pear.php.net/dtd/rest.package    http://pear.php.net/dtd/rest.package.xsd">
 <n>sub2</n>
 <c>pear.php.net</c>
 <ca xlink:href="/rest/c/PEAR">PEAR</ca>
 <l>PHP License 3.0</l>
 <s>Sub Package 2</s>
 <d>Sub Package 2</d>
 <r xlink:href="/rest/r/sub2"/>
</p>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub2/1.1.xml",
'<?xml version="1.0"?>
<r xmlns="http://pear.php.net/dtd/rest.release"
    xsi:schemaLocation="http://pear.php.net/dtd/rest.release
    http://pear.php.net/dtd/rest.release.xsd">
 <p xlink:href="/rest/p/sub2">sub2</p>
 <c>pear.php.net</c>
 <v>1.1</v>
 <st>stable</st>
 <l>PHP License</l>
 <m>cellog</m>
 <s>Main Package</s>
 <d>Main Package</d>
 <da>2004-12-10</da>
 <n>test</n>
 <f>639</f>
 <g>http://www.example.com/sub2-1.1</g>
 <x xlink:href="package.1.1.xml"/>
</r>',
'text/xml');

$pearweb->addRESTConfig("http://pear.php.net/rest/r/sub2/deps.1.1.txt",
'a:1:{s:8:"required";a:3:{s:3:"php";a:2:{s:3:"min";s:5:"4.3.0";s:3:"max";s:5:"6.0.0";}s:13:"pearinstaller";a:1:{s:3:"min";s:7:"1.4.0a1";}}}',
'text/plain');

/*
$GLOBALS['pearweb']->addXmlrpcConfig('pear.php.net', 'package.getDownloadURL',
    array(array('package' => 'main', 'channel' => 'pear.php.net'), 'stable'),
    array('version' => '1.0',
          'info' =>
'<?xml version="1.0"?>
<package packagerversion="1.4.0a1" version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0
http://pear.php.net/dtd/tasks-1.0.xsd
http://pear.php.net/dtd/package-2.0
http://pear.php.net/dtd/package-2.0.xsd">
 <name>main</name>
 <channel>pear.php.net</channel>
 <summary>test</summary>
 <description>foo
hi there

 </description>
 <lead>
  <name>person</name>
  <user>single</user>
  <email>joe@example.com</email>
  <active>yes</active>
 </lead>
 <date>2004-12-10</date>
 <time>21:39:43</time>
 <version>
  <release>1.0</release>
  <api>1.0</api>
 </version>
 <stability>
  <release>stable</release>
  <api>stable</api>
 </stability>
 <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
 <notes>here are the
multi-line
release notes

 </notes>
 <contents>
  <dir name="/">
   <dir name="sunger">
    <file baseinstalldir="freeb" md5sum="8332264d2e0e3c3091ebd6d8cee5d3a3" name="foo.dat" role="data">
     <tasks:replace from="@pv@" to="version" type="package-info" />
    </file>
   </dir> <!-- //sunger -->
   <file baseinstalldir="freeb" md5sum="8332264d2e0e3c3091ebd6d8cee5d3a3" name="foo.php" role="php">
    <tasks:replace from="@pv@" to="version" type="package-info" />
   </file>
  </dir> <!-- / -->
 </contents>
 <dependencies>
  <required>
   <php>
    <min>4.3.0</min>
    <max>6.0.0</max>
   </php>
   <pearinstaller>
    <min>1.4.0dev13</min>
   </pearinstaller>
  </required>
  <group name="foo" hint="testing group">
   <package>
    <name>sub1</name>
    <channel>pear.php.net</channel>
    <min>1.1</min>
   </package>
   <package>
    <name>sub2</name>
    <channel>pear.php.net</channel>
    <min>1.1</min>
   </package>
  </group>
 </dependencies>
 <phprelease>
  <installconditions>
   <os>
    <name>*</name>
   </os>
  </installconditions>
  <filelist>
   <install as="merbl.dat" name="sunger/foo.dat" />
   <install as="merbl.php" name="foo.php" />
  </filelist>
 </phprelease>
</package>',
          'url' => 'http://www.example.com/main-1.0'));

*/

$dp = newDownloaderPackage(array());
$result = $dp->initialize('main');
$phpunit->assertNoErrors('after create 1');

$params = array(&$dp);
$dp->detectDependencies($params);
$phpunit->assertNoErrors('after detect');
$phpunit->assertEquals(array(
), $fakelog->getLog(), 'log messages');
$phpunit->assertEquals(array(), $fakelog->getDownload(), 'download callback messages');
$phpunit->assertEquals(1, count($params), 'detectDependencies');

$result = PEAR_Downloader_Package::mergeDependencies($params);
$phpunit->assertNoErrors('after merge 1');
$phpunit->assertFalse($result, 'first return');
$phpunit->assertEquals(1, count($params), 'mergeDependencies');
$phpunit->assertEquals('main', $params[0]->getPackage(), 'main package');

echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(__FILE__) . '/teardown.php.inc';
?>
--EXPECT--
tests done
