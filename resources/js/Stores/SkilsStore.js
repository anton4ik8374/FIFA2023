import {makeAutoObservable, runInAction} from "mobx"
import axios from "axios";
import {mainApi, lkApi} from "@/Helpers/Api";
import {StatusCodes} from "http-status-codes";
import RoutersApi from "@/Stores/RoutersStore";


class Skils {

    skils = [
        {
            id: 1,
            name: 'REACT',
            content: 'JavaScript-библиотека с открытым исходным кодом для разработки пользовательских интерфейсов. React разрабатывается и поддерживается Facebook, Instagram и сообществом отдельных разработчиков и корпораций.',
            className: 'icon-react',
            color: '#3e96d0',
        },
        {
            id: 2,
            name: 'JAVASCRIPTS',
            content: 'Мультипарадигменный язык программирования. Поддерживает объектно-ориентированный, императивный и функциональный стили. Является реализацией спецификации ECMAScript.',
            className: 'icon-js-square',
            color: '#f7df1e',
        },
        {
            id: 3,
            name: 'LARAVEL',
            content: 'Веб-фреймворк с открытым кодом, предназначенный для разработки с использованием архитектурной модели MVC.',
            className: 'icon-laravel',
            color: '#fb503b',
        },
        {
            id: 4,
            name: 'GIT-HUB',
            content: 'Крупнейший веб-сервис для хостинга IT-проектов и их совместной разработки.',
            className: 'icon-github2',
            color: '#FFFFFF',
        },
        {
            id: 5,
            name: 'PHP',
            content: 'C-подобный скриптовый язык общего назначения, интенсивно применяемый для разработки веб-приложений.',
            className: 'icon-php',
            color: '#7478ae',
        },
        {
            id: 6,
            name: 'VUE',
            content: 'JavaScript-фреймворк с открытым исходным кодом для создания пользовательских интерфейсов.',
            className: 'icon-vuejs',
            color: '#41b883',
        },
        {
            id: 7,
            name: 'DATABASES',
            content: 'Совокупность данных, хранимых в соответствии со схемой данных, манипулирование которыми выполняют в соответствии с правилами средств моделирования данных.',
            className: 'icon-data',
            color: '#005e87',
        }
    ];
    constructor() {
        makeAutoObservable(this);
    }
}

export default new Skils()
