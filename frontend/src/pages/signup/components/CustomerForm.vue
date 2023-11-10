<template>
  <div class="customer-signup">
    <h5>Customer Signup</h5>

    <form>

      <div class="form-group">
        <label for="">Title</label>
        <select name="fullname" class="form-select" id="fullname" required>
          <option value="">Select title</option>
          <option value="Mr.">Mr.</option>
          <option value="Mrs.">Mrs.</option>
          <option value="Ms.">Ms.</option>
        </select>
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="">Fullname</label>
        <input type="text" class="form-input" name="fullname" id="fullname" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" class="form-input" name="email" id="email" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="password1">Password</label>
        <input type="text" class="form-input" name="password1" id="password1" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="password2">Confirm password</label>
        <input type="text" class="form-input" name="password2" id="password2" required />
        <span class="muted-text error"></span>
      </div>

      <div class="submit-btns">
        <button type="submit" class="btn block">Sign up</button>
        <p style="margin: .5rem 0;">
          Already registered? Click here to <a href="http://">Sign in.</a>
        </p>
      </div>

      <div class="alert error">
        <p>Messages here</p>
      </div>

    </form>

  </div>
</template>

<style scoped>
div.customer-signup {
  position: relative;
  width: 400px;
  border: 1px solid rgb(180, 180, 180);
  padding: .5rem;
  margin: 1rem;
}

div.customer-signup>h5 {
  margin: 0.5rem 0;
  text-align: center;
  font-size: 1.1rem;
  font-weight: 500;
}

div.submit-btns {
  display: flex;
  flex-direction: column;
  text-align: right;
}

div.submit-btns button[type="submit"] {
  background-color: blue;
  color: white;
  border: 1px solid blue;
  cursor: pointer;
  font-weight: 600;
}

div.submit-btns button[type="submit"]:hover {
  background-color: rgb(2, 2, 173);
}

label {
  color: rgba(0, 0, 0, 0.85);
  margin-top: .5rem;
  font-size: .9rem;
}
</style>
