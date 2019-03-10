<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class HelperService
{

    /**
     * movie情報からクレジット情報を取得
     *
     * @var $movie id, title, poster_path, overview
     * @var $num
     * @return Array
     */
     public function getCredits($movie, $num)
     {
         $directorArray = array();                 // 監督格納用array
         $castArray     = array();                 // キャスト格納用array
         $casts         = $movie['credits']['cast'];   // 映画情報からキャスト情報を取得
         $crews         = $movie['credits']['crew'];   // 映画情報からスタッフ情報を取得
         $top3 = range(0, $num);
         foreach ((array)$casts as $cast) {
             if (in_array($cast['order'], $top3)) {
                 $castArray[] = $cast;   // orderが0~2のキャストを取得
             }
         }
         foreach ((array)$crews as $crew) {
             if ($crew['department'] == 'Directing') {
                 $directorArray[] = $crew;   // 監督を取得
             }
         }
         // キャスト情報と監督情報をarrayに格納
         $creditArray   = array('casts'=>$castArray, 'crews'=>$directorArray);
         return $creditArray;
     }

     /**
      * movie情報からクレジット情報を取得
      *
      * @var $movie id, title, poster_path, overview
      * @var $num
      * @return Array
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

     public function getUserImage($email)
     {
         return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($email)));
     }

     /**
      * 映画検索結果（TMDb）から映画idを抽出
      *
      * @var $movies Array
      * @return Array
      */
     public function getMovieIdsFromSearchRes($movies)
     {
         $movieIds = array();
         foreach ($movies as $movie) {
             $movieIds[] = $movie->id;
         }
         return $movieIds;
     }

     public function uploadFileToS3($decodedFile, $path, $fileName, $extension)
     {
         if (!$fileName) {
             $fileName = str_random(40);
         }
         $fileFullName = $fileName.'.'.$extension;
         $result = Storage::disk('s3')->put('/'.$path.'/'.$fileFullName, $decodedFile, 'public');
         $url = '';
         if ($result) {
             $url = Storage::disk('s3')->url($path.'/'.$fileFullName);
         }
         return $url;
     }

     public function decodeProfileImage($fileBase64)
     {
         list(, $fileData) = explode(';', $fileBase64);
         list(, $fileData) = explode(',', $fileData);
         $decodedFile = base64_decode($fileData);
         return $decodedFile;
     }

     public function getExtFromFileBase64($fileBase64)
     {
         list($prefix,) = explode(';', $fileBase64);
         $extension = substr($prefix, strpos($fileBase64, '/') + 1);
         if ($extension == 'jpeg') {
             $extension = 'jpg';
         }
         return $extension;
     }
    // public function uploadFileToS3($fileBase64, $path = '') {
    //     $allowExt = ['jpeg', 'jpg', 'png'];
    //     $decodedFile = $this->decodeProfileImage($fileBase64);
    //     $fileExt = $this->getExtFromFileBase64($fileBase64);
    //     if (array_search($fileExt, $allowExt)) {
    //         $fileName = str_random(40).'.'.$fileExt;
    //         $result = Storage::disk('s3')->put('/'.$path.'/'.$fileName, $decodedFile, 'public');
    //         if ($result) {
    //             $url = Storage::disk('s3')->url($path.'/'.$fileName);
    //             return response()->json(
    //                 [
    //                     'message' => 'アップロードに成功しました。',
    //                     'url' => $url
    //                 ],
    //                 200,
    //                 ['Content-Type' => 'application/json'],
    //                 JSON_UNESCAPED_UNICODE
    //             );
    //         } else {
    //             return response()->json(
    //                 [
    //                     'code' => 01,
    //                     'message' => 'S3にアップロードできませんでした。'
    //                 ],
    //                 500,
    //                 ['Content-Type' => 'application/json'],
    //                 JSON_UNESCAPED_UNICODE
    //             );
    //         }
    //     } else {
    //         return response()->json(
    //             [
    //                 'code' => 02,
    //                 'message' => '不正な拡張子です。'
    //             ],
    //             400,
    //             ['Content-Type' => 'application/json'],
    //             JSON_UNESCAPED_UNICODE
    //         );
    //     }
    // }
    //
    //  public function decodeProfileImage($fileBase64) {
    //      list(, $fileData) = explode(';', $fileBase64);
    //      list(, $fileData) = explode(',', $fileData);
    //      $decodedFile = base64_decode($fileData);
    //      return $decodedFile;
    //  }
    //
    //  public function getExtFromFileBase64($fileBase64) {
    //      list($prefix,) = explode(';', $fileBase64);
    //      $fileExt = substr($prefix, strpos($fileBase64, '/') + 1);
    //      if ($fileExt == 'jpeg') {
    //          $fileExt = 'jpg';
    //      }
    //      return $fileExt;
    //  }
}
