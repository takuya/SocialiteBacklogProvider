<?php

namespace SocialiteProviders\Backlog;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BacklogExtendSocialite {
  
  /**
   * Execute the provider.
   */
  public function handle( SocialiteWasCalled $socialiteWasCalled ) {
    $socialiteWasCalled->extendSocialite(
      'Backlog', __NAMESPACE__.'\Provider');
  }
}
