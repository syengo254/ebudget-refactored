import StaffLoginPage from '../pages/staff-pages/auth/LoginPage.vue'

export default {
  path: '/staff',
  name: 'staff',
  children: [
    {
      path: 'login',
      name: 'staff-login',
      component: StaffLoginPage,
      meta: {
        title: 'Login Page | E-budget.com | Staff Section | Your Online Shopping Companion',
        guards: ['guest'],
      },
    },
  ],
}
