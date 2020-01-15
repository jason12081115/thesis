import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'
// import Charts from '@/views/Charts'
// import Widgets from '@/views/Widgets'

// Students
import StudentLists from '@/views/students/StudentLists'

// Refences
import Subjects from '@/views/references/Subjects'


// Curriculum
import CurriculumYears from '@/views/curriculum/CurriculumYears'
import CurriculumLists from '@/views/curriculum/CurriculumLists'

// Curriculum
import StudentEvaluations from '@/views/evaluation/StudentEvaluations'


import Profile from '@/views/Profile'

// Views - Components
// import Buttons from '@/views/components/Buttons'
// import SocialButtons from '@/views/components/SocialButtons'
// import Cards from '@/views/components/Cards'
// import Forms from '@/views/components/Forms'
// import Modals from '@/views/components/Modals'
// import Switches from '@/views/components/Switches'
// import Tables from '@/views/components/Tables'

// Views - Icons
// import FontAwesome from '@/views/icons/FontAwesome'
// import SimpleLineIcons from '@/views/icons/SimpleLineIcons'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Logout from '@/views/pages/Logout'
import Register from '@/views/pages/Register'


import store from '../store'
Vue.use(Router)

const router = new Router({
  mode: 'hash', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: 'dashboard',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: { requiresAuth: true },
        },
        {
          path: 'students',
          name: 'Students',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'StudentLists',
              name: 'Student List',
              component: StudentLists,
              meta: {requiresAuth: true}
            },
          ]
        },
        {
          path: 'references',
          name: 'References',
          component: {
            render (c) { return c('router-view') }
          },
            children: [
              {
                path: 'subjects',
                name: 'Subject',
                component: Subjects,
                meta: {requiresAuth: true}
              },
            ]
        },
        {
          path: 'curriculum',
          name: 'Curriculum',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'curriculumyears',
              name: 'Curriculum Year',
              component: CurriculumYears,
              meta: {requiresAuth: true}
            },
            {
              path: 'curriculumlists',
              name: 'Curriculum List',
              component: CurriculumLists,
              meta: {requiresAuth: true}
            },
                ]
              },
              {
                path: 'evaluation',
                name: 'Evaluation',
                component: {
                  render (c) { return c('router-view') }
                },
                children: [
                  {
                    path: 'StudentEvaluations',
                    name: 'Students Evaluation',
                    component: StudentEvaluations,
                    meta: {requiresAuth: true}
                  },
                      ]
                    },
        // {
        //   path: 'charts',
        //   name: 'Charts',
        //   component: Charts
        // },
      ]
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    },
    {
      path: '*',
      name:'404', 
      component: Page404
    },
    {
      path: '/Profile',
      name:'Profile', 
      component: Profile
    },
  ]
})
export default router
router.beforeEach((to, from, next) => {

  //check if user has rights on this route
  if(to.matched.some(route => route.meta.rights)){
    var right = false
    var row = store.state.rights.filter(right => 
      right.right_code == to.meta.rights
    )

    if(row.length > 0){
      right = true
    }

    if(!right){
      next({name: from.name})
      return
    }
  }

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    // redirect to login page
    next({ name: 'Login' })
    return
  }

// if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
      next({name: from.name})
      return
  }

next()
})
