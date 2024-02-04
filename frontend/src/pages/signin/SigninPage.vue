<script lang="ts" setup>
const error: boolean = false;
</script>

<template>
    <div id="signin">
        <h5>User Login</h5>
        <span class="info-text text-center">Enter your credentials to login</span>
        <form>
            <div class="form-group">
                <label for="user-email">Email Address</label>
                <input type="email" class="form-input" name="email" id="user-email" autocomplete="email"
                    placeholder="user@example.com" required />
                <span class="muted-text error"></span>
            </div>

            <div class="form-group">
                <label for="user-password">Password</label>
                <input type="password" class="form-input" name="password" id="user-password" autocomplete="password"
                    placeholder="password" required />
                <span class="muted-text error"></span>
            </div>

            <div class="submit-btns">
                <button type="submit" class="btn btn-primary">Login</button>
                <p style="margin: .5rem 0;">
                    Not registered? Click here to <RouterLink to="/signup">Register.</RouterLink>
                </p>
            </div>

            <div v-show="error" class="alert error mt-1 block">
                <p>Messages here</p>
            </div>
        </form>
    </div>
</template>

<style scoped>
div#signin {
    position: relative;
    max-width: 320px;
    margin-inline: auto;
}

button[type="submit"]:hover {
    background-color: rgba(0, 0, blue, 0.6);
    color: white;
    border: 1px solid blue;
}
</style>
