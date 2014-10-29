<?php
// echo 'Hello World!'
// phpinfo();

// update.php?appver=1&buildver=2

$app = $_GET['app'];
$appVer = $_GET['appver'];
$buildVer = $_GET['buildver'];
$platform = $_GET['platform'];
$model = $_GET['model'];

// $app = $_POST['app'];
// $appVer = $_POST['appver'];
// $buildVer = $_POST['buildver'];
// $platform = $_POST['platform'];
// $model = $_POST['model'];

$arr = array();

// if ($dbg)
// {
// 	$req = array()
// 	$req['app']=$app;
// 	$req['appVer']=$appVer;
// 	$req['buildVer']=$buildVer;
// 	$arr['req'] = $req;
// }

$version_file = file_get_contents("version");
$versions = str_getcsv($version_file, '.');
// echo "versions=";
// echo json_encode($versions);
$sum = count($versions);
$newAppVer = $versions[0];
// echo "sum = $sum";
for ($x=1; $x<$sum-1; $x++) {
  $newAppVer = $newAppVer . '.' . $versions[$x];
}
$newBuildVer = $versions[$sum-1];
// echo "newAppVer=$newAppVer, newBuildVer=$newBuildVer";

$arr['VERSION'] = $newAppVer;
$arr['BUILD_VERSION'] = $newBuildVer;
if ($newAppVer == $appVer)
{
	// $arr['needUpgrade'] = false;
	if ($newBuildVer != $buildVer)
	{
		// $arr['needUpdate'] = true;

		$path = $_SERVER['HTTP_HOST'];
		$arr['path'] = $path;
		
		$res = Array();
		for ($x=$buildVer; $x<$newBuildVer; $x++) {
			$res[$x-$buildVer] = "pkgv" . ($x+1) . "-$x.zip";
		}
		// $res[0] = "pkgv$newBuildVer-$buildVer.zip";
		$arr['res'] = $res;
	} else {
		// $arr['needUpdate'] = false;
	}
} else {
	// $arr['needUpgrade'] = true;
	// $arr['appStoreUrl'] = "";
}

echo json_encode($arr);
?>
