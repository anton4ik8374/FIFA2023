import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from "http-status-codes";
import RoutersApi from "@/Stores/RoutersStore";
import {addNotise} from "@/Helpers/Helpers";


class leaguesStore {
    leagues = {};
    errors = {};
    message = {};
    loading = false;

    constructor() {
        makeAutoObservable(this);
    }

    addLeagues(leagues){
        this.leagues = leagues;
    }

    addErrors(errors){
        this.errors = errors;
    }

    addMessage(message){
        this.message = message;
    }

    /**
     * Идёт загрузка
     */
    toggleLoading() {
        this.loading = !this.loading;
    }

    async getLeagues() {
        let context = this;
        context.toggleLoading();
        await mainApi.post(RoutersApi.routes.getLeagues).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addLeagues(response.data);
                } else {
                    context.addLeagues({});
                }
            });
        }).catch((error) => {
            addNotise(error?.response?.data?.message, error.response.status);
            context.addLeagues({});
            context.toggleLoading();
        });
    }

}

export default new leaguesStore()
