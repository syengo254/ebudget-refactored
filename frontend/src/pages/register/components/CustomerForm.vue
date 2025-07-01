<script lang="ts" setup>
import { RouterLink } from 'vue-router'

const error: boolean = false
</script>

<template>
  <div class="customer-signup">
    <h5>Customer Signup</h5>
    <span class="info-text text-center">Sign up here if you are a customer.</span>

    <form>
      <div class="form-group">
        <label for="customer-fullname">Fullname</label>
        <input id="customer-fullname" type="text" class="form-input" name="name" placeholder="Your Name" required />
        <span class="muted-text error" />
      </div>

      <div class="form-group">
        <label for="customer-email">Email Address</label>
        <input
          id="customer-email"
          type="email"
          class="form-input"
          name="email"
          placeholder="user@example.com"
          autocomplete="email"
          required
        />
        <span class="muted-text error" />
      </div>

      <div class="form-group">
        <label for="customer-password1">Password</label>
        <input
          id="customer-password1"
          type="password"
          class="form-input"
          name="password1"
          autocomplete="new-password"
          placeholder="Password"
          required
        />
        <span class="muted-text error" />
      </div>

      <div class="form-group">
        <label for="customer-password2">Confirm password</label>
        <input
          id="customer-password2"
          type="password"
          class="form-input"
          name="password2"
          autocomplete="new-password"
          placeholder="Password"
          required
        />
        <span class="muted-text error" />
      </div>

      <div class="submit-btns">
        <button type="submit" class="btn block">Sign up</button>
        <p style="margin: 0.5rem 0">Already registered? Click here to <RouterLink to="/login">Sign in.</RouterLink></p>
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

div.customer-signup > h5 {
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

div.submit-btns button[type='submit'] {
  background-color: blue;
  color: white;
  border: 1px solid blue;
  cursor: pointer;
  font-weight: 600;
}

div.submit-btns button[type='submit']:hover {
  background-color: rgb(2, 2, 173);
}

label {
  color: rgba(0, 0, 0, 0.85);
  margin-top: 0.5rem;
  font-size: 0.9rem;
}
</style>
