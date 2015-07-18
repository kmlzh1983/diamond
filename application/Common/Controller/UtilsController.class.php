<?php
	/*
		屏蔽错误信息的方式：
		【1】error_reporting(0)	【2】@函数(...)
		捕获错误信息：
		【1】致命错误 register_shutdown_function + error_get_last
		【2】警告错误 set_error_handler
		socket的两种方式：
		【1】默认支持fsockopen、fputs、feof、fgets、fclose等
		【2】扩展库(sockets.so)支持socket_connect(socket_*系列)
	*/
namespace Common\Controller;
class UtilsController
	{
		/*根据Content-Type与扩展名来判断上传的文件是否是图片，$file类似于$_FILES["mediaPic"]*/
		public static function isImage(array &$file = null) 
		{
			if (null == $file)
				return false;
			$type = strtolower($file["type"]);
			if ("image/gif" == $type || "image/jpeg" == $type || "image/pjpeg" == $type 
				|| "image/png" == $type || "image/x-png" == $type || "image/bmp" == $type)
			{
				$info = pathinfo($file["name"]);  
				$ext = strtolower($info["extension"]); /*扩展名*/
				if ("gif" == $ext || "jpeg" == $ext || "jpg" == $ext || "png" == $ext || "bmp" == $ext)
					return true;
			}
			return false;
		}
		
		/*根据Content-Type与扩展名来判断上传的文件是否是flash，$file类似于$_FILES["mediaPic"]*/
		public static function isFlash(array &$file = null) 
		{
			if (null == $file)
				return false;
			$type = strtolower($file["type"]);
			if ("application/x-shockwave-flash" == $type)
			{
				$info = pathinfo($file["name"]);  
				$ext = strtolower($info["extension"]); /*扩展名*/
				if ("swf" == $ext)
					return true;
			}
			return false;
		}
		
		/*根据Content-Type与扩展名来判断上传的文件是否是视频(mp4,flv)，$file类似于$_FILES["mediaPic"]*/
		public static function isViedo(array &$file = null) 
		{
			if (null == $file)
				return false;
			$type = strtolower($file["type"]);
			if ("video/mp4" == $type || "application/octet-stream" == $type)
			{
				$info = pathinfo($file["name"]);  
				$ext = strtolower($info["extension"]); /*扩展名*/
				if ("mp4" == $ext || "flv" == $ext)
					return true;
			}
			return false;
		}
		
		/*距离$date(形如20140325)多少天是什么日期，$days可以是正数或负数*/
		public static function getDate($date, $days)
		{
			$year = floor($date / 10000);
			$month = floor(($date % 10000) / 100);
			$day = floor($date % 100);
			return date("Ymd", strtotime("{$days} day", mktime(0, 0, 0, $month, $day, $year)));
		}
		
		public static function getParam($param)
		{
			return isset($_GET[$param]) ? trim($_GET[$param]) : 
				   (isset($_POST[$param]) ? trim($_POST[$param]) :
				   (isset($_COOKIE[$param]) ? trim($_COOKIE[$param]) : ""));
		}
		
		public static function getFirstChar($s0)
		{   
			$fchar = ord($s0{0});
			if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
			$s1 = @iconv("UTF-8","gb2312", $s0);
			$s2 = @iconv("gb2312","UTF-8", $s1);
			if($s2 == $s0){$s = $s1;}else{$s = $s0;}
			$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
			if($asc >= -20319 and $asc <= -20284) return "A";
			if($asc >= -20283 and $asc <= -19776) return "B";
			if($asc >= -19775 and $asc <= -19219) return "C";
			if($asc >= -19218 and $asc <= -18711) return "D";
			if($asc >= -18710 and $asc <= -18527) return "E";
			if($asc >= -18526 and $asc <= -18240) return "F";
			if($asc >= -18239 and $asc <= -17923) return "G";
			if($asc >= -17922 and $asc <= -17418) return "H";
			if($asc >= -17417 and $asc <= -16475) return "J";
			if($asc >= -16474 and $asc <= -16213) return "K";
			if($asc >= -16212 and $asc <= -15641) return "L";
			if($asc >= -15640 and $asc <= -15166) return "M";
			if($asc >= -15165 and $asc <= -14923) return "N";
			if($asc >= -14922 and $asc <= -14915) return "O";
			if($asc >= -14914 and $asc <= -14631) return "P";
			if($asc >= -14630 and $asc <= -14150) return "Q";
			if($asc >= -14149 and $asc <= -14091) return "R";
			if($asc >= -14090 and $asc <= -13319) return "S";
			if($asc >= -13318 and $asc <= -12839) return "T";
			if($asc >= -12838 and $asc <= -12557) return "W";
			if($asc >= -12556 and $asc <= -11848) return "X";
			if($asc >= -11847 and $asc <= -11056) return "Y";
			if($asc >= -11055 and $asc <= -10247) return "Z";
			
			if($asc == -4923) return "X";	//"炫"
			if($asc == -22605) return "X"; //"小"
			
			return "";
		}

		public static function illegalRequest($csrf = false)
		{
			$msg = ($csrf ? "非法token值" : "无权限访问");
			if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || "XMLHttpRequest" != $_SERVER["HTTP_X_REQUESTED_WITH"])
				echo self::alert($msg, 'document.location.href = "/";'); /*没权限就跳到首页申请权限*/
			else /*是ajax请求*/
				self::resOut("-1", $msg);
			exit(0);
		}
		
		/*弹出提示框，同时跳转到某个页面，可用于处理没有权限的情况*/
		public static function alert($msg, $cmd = '')
		{
			echo '<script type="text/javascript">alert("'.$msg.'");'.$cmd.'</script>';
		}
		
		public static function strToMap($str)
		{
			$infoMap = array();
			$strArr = explode("&", trim($str));
			for ($i = 0; $i < count($strArr); $i++)
			{
				$infoArr = explode("=", $strArr[$i]);
				if (2 == count($infoArr))
					$infoMap[$infoArr[0]] = $infoArr[1];
			}
			return $infoMap;
		}
		
		public static function mapToStr($arr)
		{
			$str = "";
			foreach ($arr as $key=>$val)
				$str .= "&".$key."=".$val;
			if ("" != $str)
				$str = substr($str, 1);
			return $str;
		}
		
		public static function charAt($string, $index)
		{
			if ($index < mb_strlen($string))
				return mb_substr($string, $index, 1);
			else
				return -1;
		}
		
		public static function uniord($str)
		{
			if (1 == strlen($str))
				return ord($str);
			$str = mb_convert_encoding($str, 'UCS-4BE', 'GBK');
			$tmp = unpack('N', $str);
			return $tmp[1];
		}
		
		public static function getGTK($str)
		{
			$hash = 5381;
			for ($i = 0, $len = strlen($str); $i < $len; ++$i)
				$hash += ($hash << 5) + self::uniord(self::charAt($str, $i));
			return $hash & 0x7fffffff;
		}
		
		/*首页需要调用getToken()获得Token值，并将这个Token值输出到JS变量中，以后每次请求都须带上token参数（Token值）*/
		public static function getToken()
		{
			$skey = "";
			if (isset($_COOKIE["ticket"])) /*SSO_client会种下cookie：ticket*/
				$skey = substr($_COOKIE["ticket"], 0, 10);
			if ("" == $skey)
				return -1;
			return self::getGTK($skey);
		}
		
		/*判断请求串中的token参数与首页吐出的Token值是否一致，防止CSRF攻击*/
		public static function antiCSRF()
		{
			$token = "";
			if (isset($_GET["token"]))
				$token = $_GET["token"];
			else if (isset($_POST["token"]))
				$token = $_POST["token"];
			if ("" == $token)
				return false;
			return self::getToken() == $token;
		}
		
		public static function isEmail($email)
		{
			if (0 == preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/", $email))
				return false;
			return true;
		}
		
		public static function isPhoneNum($phone)
		{
			if (0 != preg_match("/^(0[0-9]{2,3}[-]?)?[0-9]{7,8}(-[0-9]{1,8})?$/", $phone)
				|| 0 != preg_match("/^1[3578]{1}[0-9]{9}$/", $phone))
				return true;
			return false;
		}
		
		public static function isPositiveInt($digit) /*是否是正整数*/
		{
			if (0 == preg_match("/^[0-9]*[1-9][0-9]*$/", $digit))
				return false;
			return true;
		}
		
		public static function isInt($digit) /*是否是整数*/
		{
			if (0 == preg_match("/^[0-9]+$/", $digit))
				return false;
			return true;
		}
		
		public static function isPercentage($str) /*是否是百分比*/
		{
			if (0 == preg_match("/^\d+(\.\d+)?%$/", $str))
				return false;
			return true;
		}
		
		public static function isPartialAdtag($str) /*是否是ADTAG的一部分*/
		{
			if (0 == preg_match("/^[a-z0-9]+$/", $str))
				return false;
			return true;
		}
		
		public static function isCompleteAdtag($adTag, $resourceTag, $mediaTag) /*是否是完整的ADTAG*/
		{
			if (0 == preg_match("/^media\.{$resourceTag}\.{$mediaTag}\.[a-z0-9]+$/", $adTag))
				return false;
			return true;
		}
		
		public static function resOut($r, $msg = "")
		{
			echo json_encode(array("r"=>$r, "msg"=>$msg));
		}
		
		public static function containCC($str)
		{
			if (preg_match("/[\x7f-\xff]/", $str))
				return true;
			return false;
		}
		
		public static function cleanXss($str) 
		{ 
			return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		}
		
		/*前台传的参数类似于"1,2,3"，用isLegalValueList来判断以逗号隔开的各个值是否是正整数($flag = 1)或数字*/
		public static function isLegalValueList($values = "", $flag = 1)
		{
			if ("" == $values)
				return false;
			$valueList = explode(",", $values);
			for ($i = 0; $i < count($valueList); $i++)
			{
				if (1 == $flag)
				{
					if (!self::isPositiveInt($valueList[$i]))
						return false;
				}
				else if (!is_numeric($valueList[$i]))
					return false;
			}
			return true;
		}
		
		/*为防止XSS漏洞，需要判断浏览器端传过来的callback参数是否是合法的函数名*/
		public static function isValidCallback()
		{
			$paramName = "callback";
			$callback = isset($_GET[$paramName]) ? $_GET[$paramName] : (isset($_POST[$paramName]) ? $_POST[$paramName] : "");
			$callback = trim($callback);
			/*Javascript函数名包括字母、数字、下划线，并且不能以数字开头，长度不超过64*/
			if (preg_match('/^[a-zA-Z_](\w){0,63}$/', $callback)) 
				return $callback;
			return false;
		}
		
		/*数字转化为百分比*/
		public static function digitalToPercent($digital, $num = 2)
		{
			return round($digital * 100, $num)."%";
		}
		
		/*百分比转化为数字*/
		public static function percentToDigital($percent, $num = 2)
		{
			return round(trim($percent, "%") / 100, $num); 
		}
		
		/*
			$server: 服务器url，如: mms.ied.com
			$port: 服务器端口号，一般为80
			$cgiPath: cgi的路径，如: /o2/publish.php
			$referer: 请求头中的Referer
			$cookies: "cookies名"=>"cookies值"
			$params: "参数名"=>"参数值"
			$files: "表单元素名"=>"文件绝对路径"
			使用示例：
			CommUtils::post("mms.ied.com", 80, "/o2/publish.php", "o2.qq.com", array("name"=>"faniuxu", "age"=>30),
							array("schedule"=>"2", "token"=>555), array("f1"=>"jCal.0.3.6/_left.gif", "f2"=>"jCal.0.3.6/jCal.js",
							"f3"=>"jCal.0.3.6/_right.gif"));
		*/
		public static function post($server, $port, $cgiPath, $referer = "", array $cookies = null, array $params = null, 
									array $files = null)
		{
			$boundary = "---------------------------".time();
			/*头部*/
			$header = "POST http://{$server}/{$cgiPath} HTTP/1.1\r\n";
			$header .= "Host: {$server}\r\n";
			$header .= "Connection: close\r\n";
			if (null != $cookies && count($cookies) > 0)
			{
				$header .= "Cookie: ";
				foreach ($cookies as $key=>$value)
					$header .= "{$key}={$value}; ";
				$header = substr($header, 0, strlen($header) - 2)."\r\n";
			}
			$header .= "Content-Type: multipart/form-data; boundary={$boundary}\r\n";
			if (null != $referer && "" != $referer)
				$header .= "Referer: ".$referer."\r\n";
			
			/*参数*/
			$data = "";
			if (null != $params && count($params) > 0)
			{
				foreach ($params as $key=>$value)
				{
					$data .= "--".$boundary."\r\n";
					$data .= 'Content-Disposition: form-data; name="'.$key."\"\r\n\r\n";
					$data .= $value."\r\n";
				}
			}
			/*文件*/
			if (null != $files && count($files) > 0)
			{
				foreach ($files as $key=>$value)
				{
					if (file_exists($value))
					{
						$data .= "--".$boundary."\r\n";
						$data .= 'Content-Disposition: form-data; name="'.$key.'"; filename="'.basename($value)."\"\r\n\r\n";
						$data .= file_get_contents($value)."\r\n";
					}
				}
			}
			$data .= "--".$boundary."--\r\n"; /*结束标志*/
			$header .= "Content-length: ".strlen($data)."\r\n"; /*长度*/
			
			/*fsockopen出错时$errno为0，$errstr为null，抛出警告信息(不是异常)返回false并继续往下执行*/
			$fp = fsockopen($server, $port, $errno, $errstr, 5);
			if (false === $fp)
				return json_encode(array("r"=>"-1", "msg"=>"连接服务器'{$server}:{$port}'失败"));
			fputs($fp, $header."\r\n".$data);
			$res = "";
			while (!feof($fp)) 
				$res .= fgets($fp);
			fclose($fp);
			$pos = strpos($res, "\r\n\r\n");
			if (false !== $pos)
			{
				$header = substr($res, 0, $pos);
				$res = substr($res, $pos + 4);
				$header = explode("\r\n", $header);
				for ($i = 0; $i < count($header); $i++) /*处理状态码*/
				{
					if (0 === strpos(trim($header[$i]), "HTTP"))
					{
						header($header[$i]);
						break;
					}
				}
			}
			return $res;
		}
		
		/*
			参数的含义请参考post函数的参数说明
			使用示例：
			CommUtils::get("mms.ied.com", 80, "/o2/publish.php", "o2.qq.com", array("name"=>"faniuxu", "age"=>30),
						   array("schedule"=>"2", "token"=>555));
		*/
		public static function get($server, $port, $cgiPath, $referer = "", array $cookies = null, array $params = null)
		{
			if (null != $params && count($params) > 0)
			{
				$cgiPath .= "?";
				foreach ($params as $key=>$value)
					$cgiPath .= urlencode($key)."=".urlencode($value)."&";
				$cgiPath = substr($cgiPath, 0, strlen($cgiPath) - 1);
			}
			$header = "GET http://{$server}/{$cgiPath} HTTP/1.1\r\n";
			$header .= "Host: {$server}\r\n";
			$header .= "Connection: close\r\n";
			if (null != $cookies && count($cookies) > 0)
			{
				$header .= "Cookie: ";
				foreach ($cookies as $key=>$value)
					$header .= "{$key}={$value}; ";
				$header = substr($header, 0, strlen($header) - 2)."\r\n";
			}
			if (null != $referer && "" != $referer)
				$header .= "Referer: ".$referer."\r\n";
			$header .= "\r\n\r\n";
			
			/*fsockopen出错时$errno为0，$errstr为null，抛出警告信息(不是异常)返回false并继续往下执行*/
			$fp = fsockopen($server, $port, $errno, $errstr, 5);
			if (false === $fp)
				return json_encode(array("r"=>"-1", "msg"=>"连接服务器'{$server}:{$port}'失败"));
			fputs($fp, $header);
			$res = "";
			while (!feof($fp)) 
				$res .= fgets($fp);
			fclose($fp);
			$pos = strpos($res, "\r\n\r\n");
			if (false !== $pos)
			{
				$header = substr($res, 0, $pos);
				$res = substr($res, $pos + 4);
				$header = explode("\r\n", $header);
				for ($i = 0; $i < count($header); $i++) /*处理状态码*/
				{
					if (0 === strpos(trim($header[$i]), "HTTP"))
					{
						header($header[$i]);
						break;
					}
				}
			}
			return $res;
		}
	}	