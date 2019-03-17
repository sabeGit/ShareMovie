/**
 * Httpレスポンスコード
 */
export const OK = 200
export const CREATED = 201
export const INTERNAL_SERVER_ERROR = 500
export const UNPROCESSABLE_ENTITY = 422
export const UNAUTHORIZED = 401

/**
 * フラッシュメッセージ
 */
export const LOGIN_ERROR = '入力されたユーザー名やパスワードが正しくありません。確認してからやりなおしてください。'
export const AUTH_ERROR = 'ログインしてください'
export const ADD_FAVORITE = 'お気に入りに登録しました';
export const REMOVE_FAVORITE = 'お気に入りを解除しました';
export const ADD_WATCHED = '視聴済みに登録しました';
export const REMOVE_WATCHED = '視聴済みを解除しました';
export const POST_COMMENT = 'コメントを投稿しました';
export const UPDATE_RATING = '評価を更新しました';

/**
 * クッキーの値を取得する
 * @param {String} searchKey 検索するキー
 * @returns {String} キーに対応する値
 */
export function getCookieArray () {
    var arr = new Array();
    if(document.cookie != ''){
        var tmp = document.cookie.split('; ');
        for(var i=0;i<tmp.length;i++){
            var data = tmp[i].split('=');
            arr[data[0]] = decodeURIComponent(data[1]);
        }
    }
    return arr;
}
