<script lang="ts" setup>
import { RouterLink } from 'vue-router';

const error: boolean = false;
</script>

<template>
  <div class="vendor-signup">
    <h5>Vendor Signup</h5>
    <span class="info-text text-center">Sign up here if you are a vendor.</span>

    <form>

      <div class="form-group">
        <label for="vendor-fullname">Vendor name</label>
        <input type="text" class="form-input" name="fullname" id="vendor-fullname" autocomplete="name"
          placeholder="My Example Store Limited" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="vendor-email">Email Address</label>
        <input type="email" class="form-input" name="email" id="vendor-email" placeholder="user@example.com"
          autocomplete="email" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="vendor-password1">Password</label>
        <input type="password" class="form-input" name="password1" id="vendor-password1" autocomplete="new-password"
          required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="vendor-password2">Confirm password</label>
        <input type="password" class="form-input" name="password2" id="pvendor-assword2" autocomplete="new-password"
          required />
        <span class="muted-text error"></span>
      </div>

      <div class="submit-btns">
        <button type="submit" class="btn block">Sign up</button>
        <p style="margin: .5rem 0;">
          Already registered? Click here to <RouterLink to="/signin">Sign in.</RouterLink>
        </p>
      </div>

      <div v-show="error" class="alert error mt-1 block">
        <p>Messages here</p>
      </div>

    </form>

  </div>
</template>

<style scoped>
div.vendor-signup {
  position: relative;
  width: 400px;
  border: 1px solid rgb(180, 180, 180);
  padding: 1rem;
  margin: 1rem;
  border-radius: 3.5px;
}

div.vendor-signup>h5 {
  margin: 0.5rem 0;
  text-align: center;
  font-size: 1.4rem;
  font-weight: 500;
  color: rgba(0, 0, 0, 0.85);
}

div.submit-btns {
  display: flex;
  flex-direction: column;
  margin-top: 1rem;
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

