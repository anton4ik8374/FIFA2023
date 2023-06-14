import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, adminApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from 'http-status-codes'
import MenuStore from "@/Stores/MenuStore";
import RoutersApi from "@/Stores/RoutersStore";
import {addNotise} from "@/Helpers/Helpers"

class User {
    user = {};
    check = {};
    errors = {};
    loading = false;
    status = false

    startLoad = false;

    api_patch_sanctum = '/sanctum/csrf-cookie';

    constructor() {
        makeAutoObservable(this);
    }

    toggleLoading() {
        this.loading = !this.loading;
    }

    addUser(user) {
        this.user = user;
    }
    addCheck(data) {
        this.check = data;
    }

    setStartLoad() {
        this.startLoad = true;
    }

    async startSanctum() {
        let context = this;

        await axios.get(context.api_patch_sanctum).then((response) => {
            RoutersApi.getRoutes().then((response_2) => {
                context.loadStarted();
            });
        });
    }

    async loadStarted() {
        let context = this;

        await Promise.all([
                //Подгрузка всего для старта
                context.loadUser(),
                MenuStore.loadFreeMenu(),
        ]).then(() => {
                context.setStartLoad();
        })
    }


    addErrors(errors) {
        this.errors = errors;
    }

    addStatus(status) {
        this.status = status;
    }

    clearErrorsAndMessage(){
        this.addErrors({});
    }

    async Auth(data) {
        let context = this;
        context.clearErrorsAndMessage();
        await mainApi.post(RoutersApi.routes.login, data).then((response) => {
            if(response.status === StatusCodes.OK){
                runInAction(() => {
                    context.addUser(response.data);
                    addNotise(`Здравствуйте, ${response.data.name} !`, response.status);
                });
            }
        }).catch(errors => {
            if (errors.response.status === StatusCodes.UNAUTHORIZED) {
                runInAction(() => {
                    if(errors?.response?.data?.errors) {
                        context.addErrors(errors?.response?.data?.errors);
                    }
                    if(errors?.response?.data?.message) {
                        addNotise(errors?.response?.data?.message, errors.response.status);
                    }
                });
            } else{
                addNotise(errors?.response?.data?.message, errors.response.status);
            }
        });
    }

    async logout() {
        let context = this;
        await mainApi.post(RoutersApi.routes.logout).then((response) => {
            runInAction(() => {
                context.addUser({});
                addNotise(`До свидание 👋`);
            });
        });
    }

    clearDataUser(){
        this.addUser({});
    }

    async register(data) {
        let context = this;
        await mainApi.post(RoutersApi.routes.register, data).then((response) => {
            if(response.status === StatusCodes.CREATED){
                addNotise(response.data.message, response.status);
            }else if(response.errors){
                context.addErrors(response.errors);
            }
        }).catch((error) => {
            context.addErrors(error?.response?.data?.errors);
            addNotise(error?.response?.data?.message, error.response.status);
        });
    }

    async loadUser() {
        let context = this;
        context.toggleLoading();
        await mainApi.post(RoutersApi.routes.getUserInfo).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addUser(response.data);
                } else {
                    context.addUser({});
                }
                context.toggleLoading();
            });
        }).catch((error) => {
            addNotise(error?.response?.data?.message, error.response.status);
            context.addUser({});
            context.toggleLoading();
        });
    }

    /**
     *
     * @returns {Promise<void>}
     */
    async getCheck(data) {
        let context = this;
        await mainApi.post(RoutersApi.routes.getCheck, data).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    addNotise(response?.data?.message, response.status);
                    context.addCheck(response.data);
                } else {
                    addNotise(response?.data?.message, response.status);
                }
            });
        }).catch((error) => {
            addNotise(error?.response?.data?.message, error.response.status);
            console.log(error);
        });
    }

    get users() {
        return this.user;
    }

    /**
     * Проверяем права администратора
     * @returns {boolean}
     */
    checkAdmin() {
        let result = false;
        let user = this.user;
        if(user && user.roles){
            result = user?.roles.some((role) => role.slug === "A");
        }
        return result;
    }

}

export default new User()
