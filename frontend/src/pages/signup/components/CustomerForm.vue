<script lang="ts" setup>
import { RouterLink } from 'vue-router';

const error: boolean = false;
</script>

<template>
  <div class="customer-signup">
    <h5>Customer Signup</h5>
    <span class="info-text text-center">Sign up here if you are a customer.</span>

    <form>

      <div class="form-group">
        <label for="customer-title">Title</label>
        <select name="fullname" class="form-select" id="customer-title" required>
          <option value="">Select title</option>
          <option value="Mr.">Mr.</option>
          <option value="Mrs.">Mrs.</option>
          <option value="Ms.">Ms.</option>
        </select>
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="customer-fullname">Fullname</label>
        <input type="text" class="form-input" name="fullname" id="customer-fullname" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="customer-email">Email Address</label>
        <input type="email" class="form-input" name="email" id="customer-email" placeholder="user@example.com"
          autocomplete="email" required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="customer-password1">Password</label>
        <input type="password" class="form-input" name="password1" id="customer-password1" autocomplete="new-password"
          required />
        <span class="muted-text error"></span>
      </div>

      <div class="form-group">
        <label for="customer-password2">Confirm password</label>
        <input type="password" class="form-input" name="password2" id="customer-password2" autocomplete="new-password"
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
div.customer-signup {
  position: relative;
  width: 400px;
  border: 1px solid rgb(180, 180, 180);
  padding: 1rem;
  margin: 1rem;
  border-radius: 3.5px;
}

div.customer-signup>h5 {
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
