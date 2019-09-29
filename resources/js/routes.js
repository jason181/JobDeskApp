import LoginPage from './views/LoginPage'
import LoginForm from './components/LoginForm'

import PanelPage from './views/PanelPage'
import Dashboard from './components/Dashboard'
import Profile from './components/Profile'
import JobDesk from './components/JobDesk'
import JobDeskV2 from './components/JobDeskV2'
import JobDeskV3 from './components/JobDeskV3'





export const routes = [
    // {
    //     path: '/',
    //     name: 'Login',
    //     component: LoginForm,
        
    // },
    // {
    //     path: '/2',
    //     name: 'Index2',
    //     component: ExampleComponent2,
        
    // },

    // {
    //   path: '*',
    //   meta: {
    //     name: '',
    //     requiresAuth: true
    //   },
    //   redirect: {
    //     path: '/dashboard'
    //   }
    // },

    {
        path: '/',
        meta: {
          name: '',
          // requiresAuth: false
        },
        component: LoginPage,

        children: [
          {
            path: 'login',
            component: LoginForm,
          }
        ]
    },

    {
      path: '/panel',
      meta: {
        name: 'Panel View',
        // requiresAuth: true
      },
      component: PanelPage,
      children: [
        {
          path: 'dashboard',
          meta: {
            name: 'Dashboard',
            // requiresAuth: true
          },
          // name: 'Dashboard',
          component : Dashboard
        },
        {
          path: 'user-profile',
          meta: {
            name: 'User Profile',
            // requiresAuth: true
          },
          component : Profile
        },
        {
          path: 'job-desk',
          meta: {
            name: 'Job Desk',
            // requiresAuth: true
          },
          component : JobDesk
        },
        {
          path: 'job-desk2',
          meta: {
            name: 'Job Desk V2',
            // requiresAuth: true
          },
          component : JobDeskV2
        },
        {
          path: 'job-desk3',
          meta: {
            name: 'Job Desk V3',
            // requiresAuth: true
          },
          component : JobDeskV3
        },
      ]
    }
]