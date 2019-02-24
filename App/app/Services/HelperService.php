<?php

namespace App\Services;

class HelperService {

    /**
     * movie情報からクレジット情報を取得
     *
     * @var $movie id, title, poster_path, overview
     * @var $num
     * @return Array
     */
     public function getCredits($movie, $num) {
         $directorArray = array();                 // 監督格納用array
         $castArray     = array();                 // キャスト格納用array
         $casts         = $movie->credits->cast;   // 映画情報からキャスト情報を取得
         $crews         = $movie->credits->crew;   // 映画情報からスタッフ情報を取得
         $top3 = range(0, $num);
         foreach ($casts as $cast) {
             if (in_array($cast->order, $top3)) {
                 $castArray[] = $cast;   // orderが0~2のキャストを取得
             }
         }
         foreach ($crews as $crew) {
             if ($crew->department == 'Directing') {
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
     public function createUrlWithParams($url, $params) {
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

     public function getUserImage($email) {
         return 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($email)));
     }
}
