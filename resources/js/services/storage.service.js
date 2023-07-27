const TOKEN_KEY = 'LMS_access_token'
const REFRESH_ACCESS_TOKEN = 'LMS_refresh_token'

const TokenService = {
    getToken(){
        return localStorage.getItem(TOKEN_KEY)
    },
    setToken(accessToken){
        localStorage.setItem(TOKEN_KEY,accessToken)
    },
    removeToken(){
        localStorage.removeItem(TOKEN_KEY)
    },
    getRefreshToken(){
        return localStorage.getItem(REFRESH_ACCESS_TOKEN)
    },
    setToken(accessToken){
        localStorage.setItem(REFRESH_ACCESS_TOKEN,accessToken)
    },
    removeToken(){
        localStorage.removeItem(REFRESH_ACCESS_TOKEN)
    },

}
export {TokenService}