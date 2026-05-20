<style>
    .login-form {
      max-width: 500px;
      margin: auto;
      text-align: center;
    }
    
    .section-login {
      margin: 30px 36px 40px 36px !important;
    }
    
    .login-form-bottom {
      max-width: 500px;
      margin: auto;
      text-align: center;
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
    }
    
    .login-item {
      padding: 20px;
    }

    .login-form .form-image {
      width: 100%;
      max-width: 200px;
      height: auto;
    }
    .login-form .form-group.basic .form-control {
        background: transparent;
        border: none;
        padding: 0 0 0 0;
        border-radius: 0;
        height: 40px;
        text-align: center;
        color: #fff;
        font-weight: bold;
        font-size: 22px;
        letter-spacing: .05rem
    }
    .login-form .icon {
        font-size: 35px !important; 
    }
    .login-form hr {
        margin: 0 42%;
        border-top: 2px solid var(--color-theme-soft) !important;
    }
    .login-form .form-group .form-control:focus hr {
        border-top-color: #fff !important;
    }
    .login-form .form-group .form-control::placeholder {
        color: #6c757d !important;
        font-weight: bold;
        letter-spacing: .075em;
        opacity: 1;
        font-size: 20px
    }

    .form-control-wrap, .form-control-group {
        position: relative;
    }
    .form-control-wrap .form-control {
        font-size: 20px;
        color: #000;
        font-weight: 500;
        letter-spacing: .075em;
    }
    .form-clip, .form-text-hint {
        position: absolute;
        right: 1px;
        top: 1px;
        bottom: 1px;
        display: flex;
        align-items: center;
        color: #854fff;
        padding-left: 1rem;
        padding-right: .75rem;
        background: #fff;
        border-radius: 4px;
    }
    .form-icon {
        position: absolute;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        top: 50%;
        transform: translateY(-50%);
        width: calc(3rem + 24px);
        height: calc(3rem + 24px)
    }

    .form-icon .icon {
        font-size: 16px;
        color: #8094ae
    }

    .form-icon+.form-control {
        padding-left: calc(1rem + 24px)
    }

    .form-icon-right {
        left: auto;
        right: -1px
    }

    .form-icon-right+.form-control {
        padding-left: 1rem;
        padding-right: calc(1rem + 24px)
    }
    .form-icon-left {
        right: auto;
        left: -1px
    }

    .form-icon-left+.form-control {
        padding-right: 1rem;
        padding-left: calc(3rem + 24px)
    }
    .number-box {
      background: transparent;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 60px;
      height: 60px;
      border: 2px solid #fff;
      border-radius: 100%;
      font-size: 2rem !important;
      font-weight: 700;
    }
    .number-box.no-border {
      border: 0
    }
    .number-box:focus {
      color: #FFF !important;
      background-color: var(--color-theme) !important;
    }

    .number-box:hover {
      color: var(--color-theme) !important;
      background-color: #FFF !important;
    }

    .form-control:focus {
        color: #000;
        box-shadow: none;
    }
    
    .imaged.login {
      border-radius: 0 !important;
      padding-bottom: 40px;
    }
    
    p.login {
      font-size: 15px;
    }
    
    .modalbox .modal-dialog .modal-content .modal-body-login {
      margin: 20px;
    }
    
    .bg-primary-new{
        background-color: #000957 !important;
    }
</style>