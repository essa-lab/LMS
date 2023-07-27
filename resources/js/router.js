import {createRouter, createWebHistory } from 'vue-router'
import Login from './views/users/Login.vue'
import Dashboard from './views/users/Dashboard.vue'
import Register from './views/users/Register.vue'
import { TokenService } from './services/storage.service'
const routes = [
    {
        path:'/login',component:()=>Login,
        meta:{
            public:true,
            onlyWhenLoggedOut:true
        }
    },
    {
        path:'/register',component:()=>Register,
        meta:{
            public:true,
            onlyWhenLoggedOut:true
        }
    },
    {
        path:'/dashboard',component:()=>Dashboard
    }
]

const router = createRouter({
    history:createWebHistory(),
    routes,
    
})
router.beforeEach((to,from,next)=>{
    const isPublic = to.meta.some(record=>record.meta.public)
    const onlyWhenLoggedOut = to.meta.some(record=>record.meta.onlyWhenLoggedOut)
    const loggedIn= !!TokenService.getToken();


    if(!isPublic && !loggedIn){
        return next({
            path:'/login',
            query :{ redirect : to.fullPath }
        })
    }

    if(loggedIn && onlyWhenLoggedOut){
        return next('/')
    }
    return next()

})

export default router;