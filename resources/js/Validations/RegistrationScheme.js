import React from 'react';
import * as yup from "yup";

export function getRegistrationSchema() {
    return yup.object().shape({

        name: yup
            .string()
            .matches(/^([^0-9]*)$/, "Имя пользователя не может содержать цифры")
            .max(30, 'Имя не более 30 символов')
            .required("Имя пользователя обязательно для заполнения"),
        last_name: yup
            .string()
            .matches(/^([^0-9]*)$/, "Фамилия пользователя не может содержать цифры")
            .max(30, 'Фамилия не более 30 символов')
            .required("Фамилия пользователя обязательно для заполнения"),
        email: yup
            .string()
            .email("Некорректный формат электронной почты")
            .required("Электронная почта обязательна для заполнения"),
        password: yup
            .string()
            .required("Пароль обязателен для заполнения")
            .matches(
                /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/,
                "Пароль должен содержать минимум 8 символов, один верхний регистр, один нижний регистр, одно число и один символ специального регистра"
            ),
        password_confirmation: yup
            .string()
            .required("Повтор пароля обязателен для заполнения")
            .oneOf([yup.ref('password'), null], 'Пароли не совпадают'),
        phone: yup
            .string()
            .required("Поле телефон обязателен для заполнения"),
    });
}
