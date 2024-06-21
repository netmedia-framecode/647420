<header>
  <div class="uk-section uk-padding-remove-vertical in-header-inverse ">
    <nav class="uk-navbar-container uk-navbar-transparent" data-uk-sticky="show-on-up: true; top: 80; animation: uk-animation-fade">
      <div class="uk-container" data-uk-navbar>
        <div class="uk-navbar-left uk-width-expand uk-flex uk-flex-between">
          <a class="uk-navbar-item uk-logo" href="./">
            <img src="<?= $baseURL ?>assets/img/logo.png" alt="logo" width="60" height="23">
          </a>
        </div>
        <div class="uk-navbar-right uk-width-auto">
          <div class="uk-navbar-item uk-visible@m">
            <div class="in-optional-nav">
              <a href="auth/" class="uk-button uk-button-text"><i class="fas fa-user-circle uk-margin-small-right"></i>Log in</a>
              <a href="auth/register" class="uk-button uk-button-primary uk-button-small uk-border-pill">Sign up</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>