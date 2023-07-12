import * as React from 'react';
import Button from '@mui/material/Button';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import StartStyle from "@/Styles/StartStyle";
import UserStore from "@/Stores/UserStore";
import {CssBaseline, TextField} from "@mui/material";
import {useFormik} from "formik";
import {getLoginSchema} from "@/Validations/LoginScheme";
import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";
import {routesMap} from "@/Common/Routers/MapRouter";


export default function Home() {

    let {user, errors} = UserStore;
    const formik = useFormik({
        initialValues: {
            uuid: '',
        },
        validationSchema: getLoginSchema(),
        onSubmit: async (values) => {
            console.log(values);
            UserStore.testB(values);
        },
    });

    let navigate = useNavigate();

    useEffect(() => {
        if(user.id) {
            navigate(routesMap.home);
        }
    },[user]);

    useEffect(() => {
        formik.setErrors(errors);
    },[errors]);

    const heandlearA = () => {
        UserStore.testA();
    };

    return (
        <>
            <Box sx={{...StartStyle.container, ...StartStyle.shadows}}>
                <Container component="main" maxWidth="xs">
                    <CssBaseline/>
                    <Box
                        sx={{
                            marginTop: 8,
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'center',
                        }}
                    >
                        <Button
                            variant="contained"
                            onClick={heandlearA}>
                            A-parser
                        </Button>
                        <Typography component="h1" variant="h5">
                            Получение информации по UUID
                        </Typography>
                        <Box component="form" onSubmit={formik.handleSubmit} noValidate sx={{mt: 1}}>
                            <TextField
                                required
                                fullWidth
                                label="UUID"
                                name="uuid"
                                id="uuid"
                                onChange={formik.handleChange}
                                value={formik.values.uuid}
                                error={formik.touched.uuid && Boolean(formik.errors.uuid)}
                                helperText={formik.touched.uuid && formik.errors.uuid}
                            />

                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{mt: 3, mb: 2}}
                            >
                                Получить информацию
                            </Button>

                        </Box>
                    </Box>
                </Container>
            </Box>
        </>
    );
}
