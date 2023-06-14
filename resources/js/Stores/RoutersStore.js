import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from "http-status-codes";

class RoutersApi {
    routes = []
    loading = false
    loaded = false
    errors = false
    message = null
    api_patch = 'get-routers'

    constructor() {
        makeAutoObservable(this);
    }

    addRoutes(routes){
        this.routes = routes;
    }

    addErrors(errors){
        this.errors = errors;
    }

    addMessage(message){
        this.message = message;
    }

    toggleLoading(){
        this.loading = !this.loading;
    }
    setLoaded(status){
        this.loaded = status;
    }

    async getRoutes(){
        let context = this;
        context.toggleLoading();
        await mainApi.post(context.api_patch).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addRoutes(response.data);
                }
                context.setLoaded(true);
                context.toggleLoading();
            });
        });
    }
}

export default new RoutersApi()
