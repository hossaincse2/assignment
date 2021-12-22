import axios from 'axios';
import Config from "../config/index";

class AuthService {
    login(user) {
        return axios
            .post(Config.apiBasePath + '/user/login', {
                user_email: user.user_email,
                password: user.password
            })
            .then(response => {
                if (response.data.token) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                }

                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        return axios.post(Config.apiBasePath + '/user/register', user);
    }
}

export default new AuthService();