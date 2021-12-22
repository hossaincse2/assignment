import axios from 'axios';
import authHeader from './auth-header';
import Config from '../config/index';

class UserService {
    placeOrder(order) {
        return axios.post(Config.apiBasePath + '/order/create', order,{ headers: authHeader() });
    }
    getOrders() {
        return axios.get(Config.apiBasePath + '/order/list', { headers: authHeader() });
    }
    getFilterOrders(status) {
        return axios.get(Config.apiBasePath + '/order/filter?status='+status, { headers: authHeader() });
    }
    getProduct($id) {
        return axios.get(Config.apiBasePath + '/product/details?product_id='+$id, { headers: authHeader() });
    }
    getUser() {
        return axios.get(Config.apiBasePath + '/user/details', { headers: authHeader() });
    }
}

export default new UserService();