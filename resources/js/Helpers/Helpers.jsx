import moment from "moment";
import UserStore from "../Stores/UserStore";
import Typography from "@mui/material/Typography";
import Link from "@mui/material/Link";
import * as React from "react";
import {enqueueSnackbar} from "notistack";

/**
 * Возвращает преобразованную дату или -
 * @param date
 * @returns {string|string}
 */
const getFormatDate = (date) => {
    return moment(date).isValid() ? moment(date).locale('ru').format("DD.MM.YYYY kk:mm") : '-';
}

/**
 * Возвращает разницу в днях от текущего дня до даты
 * @param date
 * @returns {boolean|number}
 */
const getCountDay = (date) => {
    let dateFormat = moment(date);
    let now = moment();
    if(now.isBefore(dateFormat)){
        return dateFormat.diff(now, 'day');
    }
    return false;
}

/**
 * Проверяет равны ли организации по id
 * @param element
 * @returns {boolean}
 */
const thisMyProcedure = (element) => {
    if(UserStore?.user?.organization_id === element?.organization_id){
        return true;
    }
    return false;
}

/**
 * Денежное отображение цены
 * @type {Intl.NumberFormat}
 */
const currencyFormatter = new Intl.NumberFormat('ru', {
    style: 'currency',
    currency: 'RUB',
});


function Copyright(props) {
    return (
        <Typography variant="body2" color="text.secondary" align="center" {...props}>
            {'Copyright © '}
            <Link color="inherit" href="https://mui.com/">
                Your Website
            </Link>{' '}
            {new Date().getFullYear()}
            {'.'}
        </Typography>
    );
}

/**
 * variant default, success, error, warning, info
 * @param message
 * @param variant
 */
function addNotise(message, httpCode = 0) {

    let variant = 'default';

    if(httpCode >= 100 && httpCode <= 199)
    {
        variant = 'info';// 100 - 199 Informational responses
    }
    else if(httpCode >= 200 && httpCode <= 299)
    {
        variant = 'success';// 200 - 299 Successful responses
    }
    else if(httpCode >= 300 && httpCode <= 399)
    {
        variant = 'warning';// 300 - 399 Redirection messages
    }
    else if(httpCode >= 400 && httpCode <= 499)
    {
        variant = 'error';// 400 - 499 Client error responses
    }
    else if(httpCode >= 500 && httpCode <= 599)
    {
        variant = 'error';// 500 - 599 Server error responses
    }
    if(message) {
        enqueueSnackbar(message, {variant});
    }
}
function soundClick(code) {
    let sound = '/sound/scan.mp3';
    if(code === 'error'){
        sound = '/sound/error.mp3'
    }
    let audio = new Audio(); // Создаём новый элемент Audio
    audio.src = sound; // Указываем путь к звуку "клика"
    audio.autoplay = true; // Автоматически запускаем
}


export {getFormatDate, thisMyProcedure, getCountDay, currencyFormatter, Copyright, addNotise, soundClick};
