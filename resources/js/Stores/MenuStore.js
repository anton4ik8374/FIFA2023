import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from "http-status-codes";
import RoutersApi from "@/Stores/RoutersStore";


class Menus {
    freeMenu = {
        menu: [],
        loading: false,
        loaded: false,
        errors: false,
        message: null
    };
    lkMenu = {
        menu: [],
        loading: false,
        loaded: false,
        errors: false,
        message: null
    };
    adminMenu = {
        menu: [],
        loading: false,
        loaded: false,
        errors: false,
        message: null
    };
    location = window.location.pathname;

    constructor() {
        makeAutoObservable(this);
    }

    addMenu(menu){
        this.freeMenu.menu = menu;
    }

    addErrors(errors){
        this.freeMenu.errors = errors;
    }

    addMessage(message){
        this.freeMenu.message = message;
    }

    toggleLoading(){
        this.freeMenu.loading = !this.freeMenu.loading;
    }
    setLoaded(status){
        this.freeMenu.loaded = status;
    }

    addLkMenu(menu){
        this.lkMenu.menu = menu;
    }
    setLkLoaded(status){
        this.lkMenu.loaded = status;
    }

    toggleLkLoading(status){
        this.lkMenu.loading = status;
    }

    addAdminMenu(menu){
        this.adminMenu.menu = menu;
    }
    setAdminLoaded(status){
        this.adminMenu.loaded = status;
    }

    toggleAdminLoading(status){
        this.adminMenu.loading = status;
    }

    async loadFreeMenu(){
        let context = this;
        context.toggleLoading();
        await mainApi.post(RoutersApi.routes.getFreeMenu).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addMenu(response.data);
                }
                context.setLoaded(true);
                context.toggleLoading();
            });
        });
    }

    async loadLkMenu(){
        let context = this;
        context.setLkLoaded(false);
        await lkApi.post(RoutersApi.routes.getLkMenu).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addLkMenu(response.data);
                }
                context.setLkLoaded(true);
                context.toggleLkLoading(false);
            });
        });
    }

    async loadAdminMenu(){
        let context = this;
        context.toggleAdminLoading(false);
        await mainApi.post(RoutersApi.routes.getAdminMenu).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addAdminMenu(response.data);
                }
                context.setAdminLoaded(true);
                context.toggleAdminLoading(false);
            });
        });
    }
}

export default new Menus()
