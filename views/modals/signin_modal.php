
	<!-- sign in form modal -->
    <div
      class="modal fade pr-0"
      id="signInFormModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0 mb-2">
            <h3 class="modal-title" id="exampleModalLabel">Sign In</h3>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="signInForm" action="/authenticate.php" method="post">
            <div class="modal-body pt-0">
              <div class="form-group mb-4">
                <!-- type email, id signInEmail, name signInEmail, placeholder E-Mail -->
                <input
                  type="text"
                  class="w-100"
                  id="username"
                  name="username"
                  placeholder="Username"
                  required
                />
              </div>
              <!-- type password, id signInpwd, name signInpwd, placeholder Password -->
              <div class="form-group mb-4">
                <input
                  type="password"
                  class="w-100"
                  id="password"
                  name="password"
                  placeholder="Password"
                  required
                />
              </div>
              <div class="msg1"></div>
            </div>
            <div class="modal-footer border-top-0 pt-0 mb-4">
              <button type="submit" id="signInBtn">Sign In</button>
            </div>
            <div class="text-center form-footer">
                <!--
              <div class="mb-0">Forgot Password?
                  <a href="/forgotpassword">
                      Reset</a>
                </div>-->
              <div class="mb-0">
                Not a member yet?
                <a
                  href="javascript:void(0)"
                  id="signUpModalBtn"
                  type="button"
                  data-toggle="modal"
                  data-target="#signUpFormModal"
                  data-backdrop="static"
                  data-keyboard="false"
                  data-dismiss="modal"
                >
                  Sign Up</a
                >
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
	<!-- // sign in form modal -->