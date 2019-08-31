import ExampleComponent from './components/ExampleComponent'
import ExampleComponent2 from './components/ExampleComponent2'


export const routes = [
    {
        path: '/',
        name: 'Index',
        component: ExampleComponent,
        
    },
    {
        path: '/2',
        name: 'Index2',
        component: ExampleComponent2,
        
    },
]