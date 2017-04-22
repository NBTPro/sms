<?php
/**
 * Code by Nguyen Huu Dat - https://www.facebook.com/dl2811
 * Code được chia sẻ miễn phí tại J2TEAM Community - https://www.facebook.com/groups/j2team.community
 * Website: https://trolyfacebook.com
 * 
 */

error_reporting(0);

function gettoken()
{
	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'Host: graph.nhaccuatui.com';
	$headers[] = 'Connection: Keep-Alive';
	
	
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, "https://graph.nhaccuatui.com/v3/commons/token");
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_POSTFIELDS, "deviceinfo=%7B%22DeviceID%22%3A%2206C6F6391B162B7376615C3BB19C3F81%22%2C%22OsName%22%3A%22WINOS%22%2C%22OsVersion%22%3A%2210%22%2C%22AppName%22%3A%22TrolyFacebook%22%2C%22AppVersion%22%3A%226.0.5%22%2C%22UserName%22%3A%22TrolyFacebook.Com%22%2C%22DeviceName%22%3A%22%22%2C%22Provider%22%3A%22DatNguyen%22%2C%22QualityPlay%22%3A%22128%22%2C%22QualityDownload%22%3A%22128%22%2C%22QualityCloud%22%3A%22128%22%2C%22Network%22%3A%22WIFI%22%7D&md5=08ed8ef85801a129ec56635af943e8a3&timestamp=1482155807102&number=&ip=&refesh_token=5944aa2d54000adb75868f29ef5ddb9d");


	$page = curl_exec($c);
	curl_close($c);
	
	$infotoken = json_decode($page);
	$token = $infotoken->data->{2};
	return $token;
}


function getlink($idbaihat,$token)
{
	$linklist = 'https://graph.nhaccuatui.com/v3/songs/'.$idbaihat.'?access_token='.$token.'&number=&pagetracking=PlaySong&iscloud=false&ip=123.30.134.2';
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, $linklist);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

	$page = curl_exec($c);
	curl_close($c);
	
	$data = json_decode($page);
	return $data;
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Demo</title>
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="audioplayerengine/initaudioplayer-1.css">
    

    
  </head>

  <body>

    <div class="container">
		
		<div class="panel panel-primary" style="margin-top: 20px;">
		  <div class="panel-heading">Demo Get Link NhacCuaTui.Com</div>
		  <div class="panel-body">
		    <form class="form-horizontal" action="" method="POST">
				<fieldset>
				<div class="form-group">
				  <div class="col-md-10">
				  <input id="url" name="url" placeholder="Nhập link Bài hát của NhacCuaTui" class="form-control input-md" value="http://www.nhaccuatui.com/bai-hat/noi-nay-co-anh-son-tung-m-tp.JzDZ5BW4RSTI.html" type="text">
				  </div>
				  <div class="col-md-2">
				    <button id="Submit" name="submit" value="submit" class="btn btn-primary">Get link</button>
				  </div>
				</div>
				</fieldset>
				</form>
				

			
			<div class="row">
				<div class="col-md-12" style="text-align: center;">
					<?php 
					if(isset($_POST['url']))
					{
						$url = $_POST['url'];
						$temp = explode(".",$url);
						$idbaihat = trim($temp[3]);
						if($idbaihat != "")
						{
							$token = gettoken();
							if($token != "")
							{
								$data = getlink($idbaihat,$token);

								$linkplay = $data->data->{7};
								$link128 = $data->data->{11};
								$link320 = $data->data->{12};
								$linklossless = $data->data->{19};
								$thumbnail = $data->data->{8};
								$tenbaihat = $data->data->{2};
								$casy = $data->data->{3};
								if($tenbaihat != "")
								{
									$tenfile = "$tenbaihat - $casy";
									$msg.= '<div style="margin:12px auto;">
										<div id="amazingaudioplayer-1" style="display:block;position:relative;width:300px;height:300px;margin:0px auto 0px;">
											<ul class="amazingaudioplayer-audios" style="display:none;">
												<li data-artist="" data-title="'.$tenbaihat.' - '.$casy.'" data-album="" data-info="" data-image="'.$thumbnail.'" data-duration="0">
													<div class="amazingaudioplayer-source" data-src="'.$linkplay.'" data-type="audio/mpeg" />
												</li>
											</ul>
										</div>
									</div>';

									$msg.= ' <a target="_banks" href="'.$link128.'"><button type="button" class="btn btn-success"><i class="fa fa-cloud-download"></i> 128 Kbps</button></a> ';

									$msg.= ' <a target="_banks" href="'.$link320.'"><button type="button" class="btn btn-success"><i class="fa fa-cloud-download"></i> 320 Kbps</button></a> ';

									$msg.= ' <a target="_banks" href="'.$linklossless.'"><button type="button" class="btn btn-success"><i class="fa fa-cloud-download"></i> Lossless</button></a> ';

									echo $msg;
								}
								else
								{
									echo "Lỗi cmnr: Không thể get bài này!!";
								}
							}
							else
							{
								echo "Lỗi cmnr: tạo token!";
							}
						}
						else
						{
							echo "Lỗi cmnr: Không tìm thấy ID bài hát! Link phải có dạng: http://www.nhaccuatui.com/bai-hat/noi-nay-co-anh-son-tung-m-tp.JzDZ5BW4RSTI.html";
						}
						
					}

					?>
				</div>
			</div>
			
			</div>
			
		  </div>

      <footer class="footer">
        <p>&copy; 2017</p>
      </footer>

    </div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="audioplayerengine/amazingaudioplayer.js"></script>
<script src="audioplayerengine/initaudioplayer-1.js"></script>
	
	


  </body>
</html>





