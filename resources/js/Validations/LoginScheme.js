import React from 'react';
import * as yup from "yup";

export function getLoginSchema() {
    return yup.object().shape({

        email: yup
            .string()
            .email("Некорректный формат электронной почты")
            .required("Email обязателен для заполнения"),
        password: yup
            .string()
            .required("Пароль обязателен для заполнения")
    });
}
