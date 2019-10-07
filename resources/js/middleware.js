import authService from './service/Auth'
import store from './store'

export async function auth(to, from, next) {
  if (!authService.getToken()) {
    // console.log("GA DPET TOKEN")
    next({ name: 'Login' })
    

  } else {
    try {
    // console.log(" DPET TOKEN")

      await authService.refresh()
      console.log(store.getters['LoggedUser/Akses'])
      let Akses = store.getters['LoggedUser/Akses']
      // console.log(Akses)

      var x;
      let aquired=false;
      if(to.meta.Akses.includes("Panel")){
        aquired=true;
        
        next()
      }
      else{
        for(x in Akses.data){
          if (to.meta.Akses.includes(Akses.data[x].Fitur)) {
            aquired=true;
            // console.log("DPET AKSES")
  
            next()
  
          } 
        }
      }
      
      if(aquired==false){
        // console.log("GA DPET AKSES")

        next({ name: 'Dashboard' }) // Fallback if the role doesn't have any permission to access page

      }
      // if (to.meta.role.includes(role)) {
      //   next()
      // } else {
      //   next({ name: 'Dashboard' }) // Fallback if the role doesn't have any permission to access page
      // }
    } catch (err) {
      next({ name: 'Login' })
    }
  }
}

export default function middleware(guards) {
  return (to, from, next) => {
    guards.forEach(async (guard) => {
        await guard(to, from, next)
    })
  }
}