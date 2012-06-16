<?php

// *******************
//
//  curl部分はここのコードを引用しています http://naka256blog.seesaa.net/article/198723909.html
//
// ***************

// ******************************************************
// 接続先URLに接続するcurl接続データを作成
// 
// 引数
// 第一：接続先URL（必須）
// 
// 戻り値
// curl接続データ
// ******************************************************
function curl_seting( $url ){
		  	$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );

					return $ch;
}

// ******************************************************
// curlでログイン、api実行の両方で共通して使用する
// オプション処理をセットする
// 
// 引数
// 第一：curl接続データ
// 第二：クッキーファイルの保存先
// 
// 戻り値
// curl接続データ
// ******************************************************
function set_opt( $ch, $cookie_file ){
		  	// クッキーファイルを保存
		  	curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie_file );
				
				// 接続試行時間( 0で永遠に待ち続ける )
				curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );

					// 戻り値を受け取る
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

						return $ch;
}

// ******************************************************
// "name1=data1&name2=data2&･･･" 
// の形式で送られてきたデータを連想配列にセットする
// 
// 引数
// 第一："name1=data1&name2=data2&･･･"の形式の文字列（必須）
// 
// 戻り値
// 連想配列
// ******************************************************
function toArray( $str ){

		  	$ary = array();

				$str = urldecode( $str );

					$amp = strpos( $str, "&" );

						// アンパサンド区切りの文字列を取り出す
						while( !($amp === false) ){

								  		$ary = array_create( $ary, substr( $str, 0, $amp ) );

												$str = substr( $str, $amp + 1, strlen( $str ) );
														$amp = strpos( $str, "&" );

															}

							$ary = array_create( $ary, $str, true );

								return $ary;
}

// ******************************************************
// "name=data" の形式で送られてきたデータを
// 連想配列にセットする
// 
// 引数
// 第一：セットする配列（必須）
// 第二："name=data" 形式の文字列（必須）
// 第三：data が JSON 形式で保存されていて、
// 		変換が必要ならtrue（任意）デフォルトは false
// 
// 戻り値
// array( "name" => "data")の連想配列
// ******************************************************
function array_create( $ary, $str, $json = false ){

		  	$equal = strpos( $str, "=" );

				if( $json === false ){
						  		$ary[ substr( $str, 0, $equal ) ] = substr( $str, $equal + 1, strlen( $str ) );
									} else {
											  		// json形式のデータにデコード
											  		$ary[ substr( $str, 0, $equal ) ] = json_decode( substr( $str, $equal + 1, strlen( $str ) ) );
														}

					return $ary;
}
function getFlv($video_id){

$login_url = "https://secure.nicovideo.jp/secure/login?site=niconico";	//ログイン先
$param = Array(
					 "mail" => "", //メールアドレス
					 "password"=>"" //パスワード
					); 
$cookie_file = "./cookie.txt";
//exec("rm ".$cookie_file);

// ******************************************************
// ログイン
// ******************************************************
$ch = curl_seting( $login_url );

$ch = set_opt( $ch, $cookie_file );

// 証明書を確認しない
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

// POSTメソッドを使用する
curl_setopt( $ch, CURLOPT_POST, true );

// パラメータをセットする
curl_setopt( $ch, CURLOPT_POSTFIELDS, $param );

// 実行して、戻り値を取得
$ret = curl_exec( $ch );

curl_close( $ch );

// ******************************************************
// API使用
// ******************************************************

$api_url = "http://flapi.nicovideo.jp/api/getflv/" . $video_id;	// apiのURL
$ch = curl_seting( $api_url );

// クッキーファイルを呼び出し
curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookie_file );

$ch = set_opt( $ch, $cookie_file );

// 実行して、戻り値を取得
$ret = curl_exec( $ch );

$array = toArray( $ret );
//print_r($array);
curl_close($ch);

$ch=curl_seting($array["url"]);
curl_setopt($ch, CURLOPT_COOKIEFILE ,$cookie_file);

$ch=set_opt($ch,$cookie_file);

$flvdata=curl_exec($ch);

//$flvdata=file_get_contents($array['url']);
//echo $flvdata."\n";

$PathVideoDir="";//videoを保存するディレクトリ

if(preg_match("/403 Forbidden/",$flvdata)){
file_put_contents("./miss.txt",$video_id."\n",FILE_APPEND );
}elseif(!$array["url"]){
file_put_contents("./log".date("Y-m-d").".txt","===empty???===\n".$ret."===========\n",FILE_APPEND);
}else{
file_put_contents("."$PathVideoDir.$video_id,$flvdata);
}
echo $flvdata;
curl_close($ch);
};

getFlv($argv[1]);
?>
