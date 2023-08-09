import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from "http-status-codes";
import RoutersApi from "@/Stores/RoutersStore";
import {addNotise} from "@/Helpers/Helpers";


class MatchesStore {
    matches = [];
    match = {};
    errors = {};
    message = '';
    loading = false;

    constructor() {
        makeAutoObservable(this);
    }

    add(matches){
        this.matches = matches;
    }
    addMatch(match){
        this.match = match;
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

    async getActualMatches() {
        let context = this;
        context.toggleLoading();
        await mainApi.post(RoutersApi.routes.getActualMatches).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.add(response.data);
                } else {
                    context.add([]);
                }
            });
        }).catch((error) => {
            addNotise(error?.response?.data?.message, error.response.status);
            context.add([]);
            context.toggleLoading();
        });
    }

    async getMatch(id) {
        let context = this;
        context.toggleLoading();
        await mainApi.post(RoutersApi.routes.getMatch, {id}).then((response) => {
            runInAction(() => {
                if(response.status === StatusCodes.OK){
                    context.addMatch(response.data);
                } else {
                    context.addMatch({});
                }
            });
        }).catch((error) => {
            addNotise(error?.response?.data?.message, error.response.status);
            context.addMatch({});
            context.toggleLoading();
        });
    }

}

export default new MatchesStore()
