import LoginPage from './views/LoginPage'
import LoginForm from './components/LoginForm'

import PanelPage from './views/PanelPage'
import Dashboard from './components/Dashboard'
import Profile from './components/Profile'




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
            path: '',
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
          path: '',
          name: 'Dashboard',
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
      ]
    }
]