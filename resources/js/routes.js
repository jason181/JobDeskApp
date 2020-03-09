import middleware, { auth } from './middleware'

import LoginPage from './views/LoginPage'
import LoginForm from './components/LoginForm'

import PanelPage from './views/PanelPage'
import Dashboard from './components/Dashboard'
import Profile from './components/Profile'
import JobDesk from './components/JobDesk'
import JobDeskV2 from './components/JobDeskV2'
import JobDeskV3 from './components/JobDeskV3'
import Employee from './components/ManagementEmployee'
import AdminPanel from './components/AdminPanel'

import Role from './components/ManagementRole'
import JobAccess from './components/JobAccessRequest'


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
            name: 'Login',
            meta: {
            
            },
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
          name: 'Dashboard',
          meta: {
            name: 'Dashboard',
            Akses:[
              'Panel'
            ]
          },
          component : Dashboard,
          beforeEnter: middleware([
            auth
          ]) 
        },
        {
          path: 'user-profile',
          meta: {
            name: 'User Profile',
            Akses:[
              'Panel'
            ]
          },
          component : Profile,
          beforeEnter: middleware([
            auth
          ])
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
          name: 'Job Desk V3',
          meta: {
            name: 'Job Desk V3',
            Akses:[
              'Panel'
            ]
          },
          component : JobDeskV3,
          beforeEnter: middleware([
            auth
          ])
        },
        {
          path: 'employee',
          meta: {
            name: 'Management Employee',
            Akses:[
              'M-Employee-C',
              'M-Employee-R',
              'M-Employee-U',
              'M-Employee-D',
            ]
          },
          component : Employee,
          beforeEnter: middleware([
            auth
          ])
        },
        {
          path: 'role',
          meta: {
            name: 'Management Role',
            Akses:[
              'M-Role-C',
              'M-Role-R',
              'M-Role-U',
              'M-Role-D',
            ]
          },
          component : Role,
          beforeEnter: middleware([
            auth
          ])
        },
        {
          path: 'job-access',
          meta: {
            name: 'Job Access Request',
            Akses:[
              'M-JobAccess-C',
              'M-JobAccess-R',
              'M-JobAccess-U',
              'M-JobAccess-D',
            ]
          },
          component : JobAccess,
          beforeEnter: middleware([
            auth
          ])
        },
        {
          path: 'admin_panel',
          meta: {
            name: 'Admin Panel',
            Akses:[
              'Panel'
            ]
          },
          component : AdminPanel,
          beforeEnter: middleware([
            auth
          ])
        },
      ]
    }
]