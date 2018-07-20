<?php

namespace SocialiteProviders\backlog;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BacklogExtendSocialite {
  
  /**
   * Execute the provider.
   */
  public function handle( SocialiteWasCalled $socialiteWasCalled ) {
    $socialiteWasCalled->extendSocialite(
      'backlog', __NAMESPACE__.'\Provider');
  }
}
