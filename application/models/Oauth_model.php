<?php

require_once('Facebook/autoload.php');

class MyPersistentDataHandler implements Facebook\PersistentData\PersistentDataInterface {
  public function __construct(){
    $this->data = array();
  }

  private $data = array();

  /**
   * Get a value from a persistent data store.
   *
   * @param string $key
   *
   * @return mixed
   */
  public function get($key){
    return isset($this->data[$key]) ? $this->data[$key] : null;
  }

  /**
   * Set a value in the persistent data store.
   *
   * @param string $key
   * @param mixed  $value
   */
  public function set($key, $value){
    $this->data[$key] = $value;
  }
}

class Oauth_model extends CI_Model {

  private $appId = '336960786712721';
  private $appSecret = '7e90ee09172c91422bda26408d62d590';

/**
 * Przekierowuje do logowania za pomocą facebooka
 * @method login
 */
  public function login(){
    $fb = new Facebook\Facebook([
      'app_id' => $this->appId, // Replace {app-id} with your app id
      'app_secret' => $this->appSecret,
      'default_graph_version' => 'v2.2',
      'persistent_data_handler'=>'memory'
      ]);

    $helper = $fb->getRedirectLoginHelper();

    $permissions = ['email', 'public_profile']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('http://localhost/Cinema/index.php/OAuth/fb_callback', $permissions);
    $this->load->helper('url');

    redirect($loginUrl);
    //echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  }

  /**
   * @method callback
   * @return string zwraca dane do logowania do aplikacji
   */
  public function callback(){
    $state = $this->input->get('state');
    $persistent = new MyPersistentDataHandler();
    $persistent->set('state', $state);
    $fb = new Facebook\Facebook([
      'app_id' => $this->appId, // Replace {app-id} with your app id
      'app_secret' => $this->appSecret,
      'default_graph_version' => 'v2.2',
      'persistent_data_handler'=> $persistent
      ]);

    $helper = $fb->getRedirectLoginHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }

    // Logged in
    /*echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());*/

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
  /*  echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);*/

    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId($this->appId); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();

    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }

    /*  echo '<h3>Long-lived</h3>';
      var_dump($accessToken->getValue());*/
    }
    $fb->setDefaultAccessToken($accessToken->getValue());
    $response = $fb->get('/me?locale=en_US&fields=name,email');
    $userNode = $response->getGraphUser();
    return $this->logInToApp($accessToken->getValue(), $userNode->getField('email'), $userNode->getField('name'));

    //$_SESSION['fb_access_token'] = (string) $accessToken;

    // User is logged in with a long-lived access token.
    // You can redirect them to a members-only page.
    //header('Location: https://example.com/members.php');
  }

  /**
   * Funkcja sprawdza czy dany użytkownik istnieje w bazie.
   * Jeżeli tak to logujemy go.
   * Jeżeli nie to najpierw go dodajemy do bazy. Pole email to userID.
   * @method logInToApp description
   * @param string $facebookAccessToken  access token dla facebooka
   * @param string $email email usera na facebooku
   * @param string $name nazwa usera na facebooku
   * @return string Zwraca token w formacie json
   */
  public function logInToApp($facebookAccessToken, $email, $name){
    $this->load->model('user_model', 'user');
    $query = $this->user->getUserByEmail($email);
    if ( count($query) == 0 ){
      $this->user->setEmail($email);
      $this->user->setNick($name);
      $this->user->setPassword('NoPassword');
      $this->user->save();
    }
    $this->load->model('token');
    $status = array('token' => $this->token->generateToken($this->user->getUserId($email)),
                      'status' => $this->user->getUserNick($email));
    return $status;
  }

}

?>
