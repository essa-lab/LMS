import axios from "axios";
import { TokenService } from "./storage.service";

const ApiService = {
    init(baseURL){
        axios.defaults.baseURL=baseURL
    },
    setHeader(){
        axios.defaults.headers.common['Authorization']=`Bareer ${TokenService.getToken}`
    },
    removeHeader(){
        axios.defaults.headers.common={}
    },
    get(resource){
        return axios.get(resource)
    },
    post(resource,data){
        return axios.post(resource,data)
    },
    delete(resource){
        return axios.delete(resource)
    },
    put(resource,data){
        return axios.put(resource,data)
    },
    customRequest(data) {
        return axios(data)
    }

}
export default ApiService