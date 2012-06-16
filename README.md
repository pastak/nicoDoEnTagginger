nicoDoEnTagginger
=================

PHP script for download video file from nicovideo.jp , then call ffmpeg and add id3v2.4 tag

Require
--------
* NicoNico Account

* ffmpeg
** apt-getとかで入れると上手くいきません。。方法はここらへんによくまとまってます。
<https://ffmpeg.org/trac/ffmpeg/wiki/UbuntuCompilationGuide>

* eyeD3
** mp3にid3なタグをつけるライブラリです。 ffmpegでも出来ますがUTF-16で書き込みたかったので、これを使用しています。

How to Use
----------
1. download.phpを開いて112行目にニコニコ動画のアカウントのメールアドレスとパスワード、169行目にvideoを保存するディレクトリのパスを入れます
2. encode.phpの35行目にも同じディレクトリのパスを入れておきます。４１行目のffmpegのオプションと46行目のオプションは自由に設定変更してください。
3. Terminalで 'php main.php <videoid(ex:sm000001)>' と入力するとダウンロードとエンコードが行われます。

Other Info
----------
* 動作状況は常にログファイルに保存します。(ファイル名：log[Y]-[m]-[d].txt)
		  保存される情報は実行コマンドはダウンロードに失敗した場合のエラーコードなどです。
* videoのダウンロードに失敗した場合はmiss.txtにそのvideoidを書き込みます。
* retry.phpを実行することでmiss.txtに書きこまれているidを順番に引数にしてmain.phpを呼び出します。基本的にはmiss.txtがなくなるまで繰り返します。
