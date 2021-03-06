<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\Common\ExtensionException;

class HelperService
{
    use \App\Json\UserFailJson;

    // アップロード可能な画像拡張子
    const ALLOW_EXTENSIONS = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
    ];

    /**
     * movie情報からクレジット情報を取得
     *
     * @param object $movie  映画情報
     * @param int    $num    取得するクレジット情報数
     * @return array
     */
     public function getCredits($movie, $num)
     {
         // 映画情報からキャスト情報とスタッフ情報を取得
         $directorArray = array();
         $castArray     = array();
         $casts         = $movie['credits']['cast'];
         $crews         = $movie['credits']['crew'];
         $top3 = range(0, $num);
         foreach ((array)$casts as $cast) {
             // orderが0~2のキャストを取得
             if (in_array($cast['order'], $top3)) {
                 $castArray[] = $cast;
             }
         }
         foreach ((array)$crews as $crew) {
             // 監督を取得
             if ($crew['department'] == 'Directing') {
                 $directorArray[] = $crew;
             }
         }

         // キャスト情報と監督情報をarrayに格納
         $creditArray   = array('casts'=>$castArray, 'crews'=>$directorArray);

         return $creditArray;
     }

     /**
      * パラメータ付きのURLを生成
      *
      * @param string $url     ベースURL
      * @param array  $params  URLに付与するパラメーター
      * @return string
      */
     public function createUrlWithParams($url, $params)
     {
         $count = 0;
         foreach ($params as $key => $value) {
             if ($count == 0) {
                 $url .= "?{$key}={$value}";
             } else {
                 $url .= "&{$key}={$value}";
             }
             $count++;
         }
         
         return $url;
     }

     /**
      * 映画検索結果（TMDb）から映画idを抽出
      *
      * @param array $movies
      * @return array
      */
     public function getMovieIdsFromSearchRes($movies)
     {
         $movieIds = array();
         foreach ($movies as $movie) {
             $movieIds[] = $movie->id;
         }

         return $movieIds;
     }

     /**
      * ファイルをS3へアップロード。
      * ファイルの拡張子が不適切な場合はエラーメッセージをJSON形式で返す。
      *
      * @param string $decodedFile
      * @param string $path
      * @param string $fileName
      * @return string|json
      */
     public function uploadFileToS3($decodedFile, $path, $fileName)
     {
         // ファイル名を生成
         if (!$fileName) {
             $fileName = str_random(40);
         }
         $extension = $this->getFileExtension($decodedFile);

         $fileFullName = $fileName.'.'.$extension;

         // ファイルをアップロード
         $result = Storage::disk('s3')->put(
             '/'.$path.'/'.$fileFullName, $decodedFile, 'public'
         );

         // ファイルのパスを生成
         $url = '';
         if ($result) {
             $url = Storage::disk('s3')->url($path.'/'.$fileFullName);
         }

         return $url;
     }


     /**
      * アップロードされたファイルをデコード。
      *
      * @param string $fileBase64
      * @return string
      */
     public function decodeProfileImage($fileBase64)
     {
         // アップロードされたファイルをデコード
         list(, $fileData) = explode(';', $fileBase64);
         list(, $fileData) = explode(',', $fileData);
         $decodedFile = base64_decode($fileData);

         return $decodedFile;
     }

     /**
      * base64デコード済みのファイルから拡張子を抽出。
      * ファイルの拡張子が不適切な場合はエラーメッセージをJSON形式で返す。
      *
      * @param string $decodedFile
      * @return array|string
      */
     private function getFileExtension($decodedFile)
     {
         // base64デコード済みのファイルから拡張子を抽出
         $mime_type = finfo_buffer(finfo_open(), $decodedFile, FILEINFO_MIME_TYPE);
         if (!in_array($mime_type, self::ALLOW_EXTENSIONS)) {
             throw new ExtensionException();
         }

         return array_search($mime_type, self::ALLOW_EXTENSIONS);
     }
}
