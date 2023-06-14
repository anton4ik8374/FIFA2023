import axios from 'axios';
import User from "../Stores/UserStore";

/**
 * 401 - не авторизован
 * 419 - доступ запрещён(нет прав)
 * @type {number[]}
 */
const UNAUTHORIZED = [401];

const mainApi = axios.create({
	baseURL: '/',
    headers: {'Content-Type': 'application/json'}
});

const lkApi = axios.create({
    baseURL: '/lk/',
});

const adminApi = axios.create({
    baseURL: '/admin/',
});

/**
 * Интерцепторы при передаче
 */
/*
mainApi.interceptors.request.use(function(request){
	return request;
});
*/
/**
 * Интерцепторы при ответе
 */
mainApi.interceptors.response.use(response => response,
    error => {

        const {status} = error.response;
        if (UNAUTHORIZED.includes(status)) {
            User.clearDataUser();
        }
        return Promise.reject(error);
    });
/**
 * Интерцепторы при ответе Админ
 */
adminApi.interceptors.response.use(response => response,
    error => {
        const {status} = error.response;
        if (UNAUTHORIZED.includes(status)) {
            User.clearDataUser();
        }
        return Promise.reject(error);
    });
/**
 * Интерцепторы при ответе ЛК
 */
lkApi.interceptors.response.use(response => response,
    error => {
        const {status} = error.response;
        if (UNAUTHORIZED.includes(status)) {
            User.clearDataUser();
        }
        return Promise.reject(error);
    });



export {mainApi, adminApi, lkApi} ;


