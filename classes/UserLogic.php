<?php

require_once('../dbconnect.php');

class UserLogic {
  /**
   * ユーザーを登録する
   * @param array $userData
   * @return bool $result
  */
  public static function createUser($userData) {
    $result = false;
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";//プレースホルダー

    $arr = [];
    $arr[] = $userData['username'];
    $arr[] = $userData['email'];
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);//ハッシュ化

    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;//成功したらtrueを返す
    } catch(\Exception $e) {
      return $result;//失敗したらfalseを返す
    }
  }

  /**
   * ログインする
   * @param string $email
   * @param string $password
   * @return bool $result
   */
  public static function login($email, $password) {
    //結果
    $result = false;
    //ユーザーをemailから取得
    $user = self::getUserByEmail($email);
    //emailが一致しないとき
    if(!$user) {
      $_SESSION['msg'] = 'emailが一致しません。';
      return $result;
    }
    //emailが一致したとき
    //パスワード照会
    if(password_verify($password, $user['password'])) {
      //ログイン成功
      session_regenerate_id(true);//セッションハイジャック対策
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }

    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
  }

  /**
   * emailからユーザーを取得
   * @param string $email
   * @return array|bool $user|false
   */
  public static function getUserByEmail($email) {
    $sql = 'SELECT * FROM users WHERE email = ?';//プレースホルダー

    $arr = [];
    $arr[] = $email;
    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute($arr);
      //SQLの結果を返す
      $user = $stmt->fetch();
      return $user;//成功したらtrueを返す
    } catch(\Exception $e) {
      return false;
    }
  }
}

?>
