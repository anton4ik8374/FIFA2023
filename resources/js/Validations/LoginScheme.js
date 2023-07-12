import React from 'react';
import * as yup from "yup";

export function getLoginSchema() {
    return yup.object().shape({

        uuid: yup
            .string()
            .required("UUID обязателен для заполнения"),
    });
}
