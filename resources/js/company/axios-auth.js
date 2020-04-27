import axios from 'axios'
let BASE_URL = location.protocol+'//'+location.hostname+'/api/auth'
const axiosInstance = axios.create({
    baseURL:BASE_URL
})

export default axiosInstance
