
    <!-- sign up form modal -->
    <div
      class="modal fade pr-0"
      id="signUpFormModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0 mb-2">
            <h3 class="modal-title" id="exampleModalLabel">Sign Up</h3>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="signUpForm" action="/<?php echo (disable_registration ? "tempRegAction.php" : "register-process.php"); ?>" method="post">
            <div class="modal-body pt-0">
              <!--<div class="form-group row"> -->
                <div class="form-group mb-2"> <!--col-12 col-sm-6 mb-2 -->
                  <!-- fname, fname, First Name -->
                  <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Username"
                    required/>
                <!-- </div> -->
                <!--
                <div class="col-12 col-sm-6 mb-2">
                  <input
                    type="text"
                    name="lname"
                    id="lname"
                    placeholder="Last Name"
                    required/>
                </div> -->
              </div>
              <div class="form-group mb-2">
                <!-- signInEmail, signInEmail, E-Mail -->
                <input
                  type="email"
                  class="w-100"
                  id="email"
                  name="email"
                  placeholder="E-Mail"
                  required/>
              </div>
              <div class="form-group mb-2">
                <!-- pwd, pwd, Password -->
                <input
                  type="password"
                  class="w-100"
                  id="password"
                  name="password"
                  placeholder="Password"
                  required/>
              </div>
              <div class="form-group mb-2">
                <!-- confirmPwd, confirmPwd, Confirm Password -->
                <input
                  type="password"
                  class="w-100"
                  id="cpassword"
                  name="cpassword"
                  placeholder="Confirm Password"
                  required/>
              </div>
            </div>
            <div class="msg2"></div>
            <div class="modal-footer border-top-0 pt-0 mb-2">
              <button type="submit" id="signUpBtn"><?php echo (disable_registration ? "Sign Ups Temporarily Restricted :(" : "Sign Up") ; ?> </button>
            </div>
            <div class="text-center form-footer">
              <p class="mb-0">
                Already a member?
                <a
                  href="javascript:void(0)"
                  id="signUpModalBtn"
                  type="button"
                  data-toggle="modal"
                  data-target="#signInFormModal"
                  data-backdrop="static"
                  data-keyboard="false"
                  data-dismiss="modal"
                  >Sign In</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- // sign up form modal -->	
