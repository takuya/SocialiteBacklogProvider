<?php

namespace SocialiteProviders\Backlog;

use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

  class Provider extends AbstractProvider implements ProviderInterface {

  /**
   * Unique Provider Identifier.
   */
  const IDENTIFIER = 'BACKLOG';
  /**
   * {@inheritdoc}
   */
  protected $scopes = [];

  /**
   * {@inheritdoc}
   */
  protected function getAuthUrl( $state ) {
    $url = "{$this->getSpaceUri()}/OAuth2AccessRequest.action";

    return $this->buildAuthUrlFromBase($url, $state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getTokenUrl() {
    return "{$this->getSpaceUri()}/api/v2/oauth2/token";
  }

  /**
   * {@inheritdoc}
   */
  protected function getUserByToken( $token ) {

    $res = $this->getHttpClient()->get(
      "{$this->getSpaceUri()}/api/v2/users/myself",
      [
        'headers' => [
          'Authorization' => 'Bearer '.$token,
        ],
      ]);

    return json_decode($res->getBody(), true);
  }

  /**
   * {@inheritdoc}
   */
  protected function mapUserToObject( array $user ) {
    $oauth_account = ( new User() )->setRaw($user)->map(
      [
        'id'       => $user['id'],
        'name'     => $user['userId'],
        'userId'   => $user['userId'],
        'nickname' => $user['name'],
        'email'    => $user['mailAddress'],
        'avatar'   => "{$this->getSpaceUri()}/api/v2/users/{$user['userId']}/icon",
      ]);
    $oauth_account->user['backlog_domain'] = $this->getSpaceUri();

    return $oauth_account;
  }

  /**
   * {@inheritdoc}
   */
  protected function getTokenFields( $code ) {
    return array_merge(
      parent::getTokenFields($code),
      [
        'grant_type' => 'authorization_code',
      ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getSpaceUri() {
    $uri = $this->getConfig('space_uri', null);
    if( !$uri ) {
      throw new \InvalidArgumentException(
        'No space_uri. ENV[BACKLOG_SPACE_URI]=https://your-space-id.Backlog.jp/ must be provided.');
    }
    return $uri;
  }

  /**
   * {@inheritdoc}
   */
  public static function additionalConfigKeys() {
    return ['space_uri'];
  }
}
