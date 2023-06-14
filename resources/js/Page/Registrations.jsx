import React, {useEffect, useState} from 'react';
import {TextField, Box, Container, InputAdornment, IconButton} from '@mui/material';
import {Visibility, VisibilityOff} from '@mui/icons-material';
import CssBaseline from '@mui/material/CssBaseline';
import {useFormik} from 'formik';
import {observer} from "mobx-react";
import {Copyright} from "@/Helpers/Helpers";
import Button from "@mui/material/Button";
import {getRegistrationSchema} from "@/Validations/RegistrationScheme";
import 'react-phone-input-2/lib/style.css'
import UserStore from "@/Stores/UserStore";
import {useNavigate} from "react-router-dom";
import {routesMap} from "@/Common/Routers/MapRouter";

const Registrations = observer(() => {

    let {user, errors} = UserStore;

    let navigate = useNavigate();

    useEffect(() => {
        if(user.id) {
            navigate(routesMap.home);
        }
    },[user]);

    const formik = useFormik({
        initialValues: {
            name: '',
            email: '',
            phone: '',
            last_name: '',
            middle_name: '',
            password: '',
            password_confirmation: ''
        },
        validationSchema: getRegistrationSchema(),
        onSubmit: (values) => {
            UserStore.register(values);
        },
    });

    useEffect(() => {
        formik.setErrors(errors);
    },[errors]);

    const [showPassword, setShowPassword] = useState(false);

    const handleTogglePassword = () => setShowPassword(!showPassword);

    return (
        <>

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
                    <Box component="form" onSubmit={formik.handleSubmit} noValidate sx={{mt: 1}}>
                        <TextField
                            label="Имя"
                            required
                            fullWidth
                            name="name"
                            id="name"
                            value={formik.values.name}
                            onChange={formik.handleChange}
                            error={formik.touched.name && Boolean(formik.errors.name)}
                            helperText={formik.touched.name && formik.errors.name}
                        />
                        <TextField
                            margin="normal"
                            required
                            fullWidth
                            label="Фамилия"
                            onChange={formik.handleChange}
                            name="last_name"
                            id="last_name"
                            value={formik.values.last_name}
                            error={formik.touched.last_name && Boolean(formik.errors.last_name)}
                            helperText={formik.touched.last_name && formik.errors.last_name}
                        />
                        <TextField
                            label="Отчество"
                            fullWidth
                            name="middle_name"
                            id="middle_name"
                            value={formik.values.middle_name}
                            error={formik.touched.middle_name && Boolean(formik.errors.middle_name)}
                            helperText={formik.touched.middle_name && formik.errors.middle_name}
                        />
                        <TextField
                            margin="normal"
                            name="phone"
                            id="phone"
                            label="Телефон"
                            required
                            fullWidth
                            onChange={formik.handleChange}
                            value={formik.values.phone}
                            error={formik.touched.phone && Boolean(formik.errors.phone)}
                            helperText={formik.touched.phone && formik.errors.phone}
                        />
                        <TextField
                            required
                            fullWidth
                            label="Email"
                            name="email"
                            id="email"
                            onChange={formik.handleChange}
                            value={formik.values.email}
                            error={formik.touched.email && Boolean(formik.errors.email)}
                            helperText={formik.touched.email && formik.errors.email}
                        />
                        <TextField
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Пароль"
                            type={showPassword ? 'text' : 'password'}
                            id="password"
                            onChange={formik.handleChange}
                            value={formik.values.password}
                            error={formik.touched.password && Boolean(formik.errors.password)}
                            helperText={formik.touched.password && formik.errors.password}
                            InputProps={{
                                endAdornment: (
                                    <InputAdornment position="end">
                                        <IconButton
                                            aria-label="toggle password visibility"
                                            onClick={handleTogglePassword}
                                        >
                                            {showPassword ? <Visibility/> : <VisibilityOff/>}
                                        </IconButton>
                                    </InputAdornment>
                                ),
                            }}
                        />
                        <TextField
                            required
                            fullWidth
                            name="password_confirmation"
                            label="Повторите пароль"
                            type={showPassword ? 'text' : 'password'}
                            onChange={formik.handleChange}
                            id="password_confirmation"
                            value={formik.values.password_confirmation}
                            error={formik.touched.password_confirmation && Boolean(formik.errors.password_confirmation)}
                            helperText={formik.touched.password_confirmation && formik.errors.password_confirmation}
                            InputProps={{
                                endAdornment: (
                                    <InputAdornment position="end">
                                        <IconButton
                                            aria-label="toggle password visibility"
                                            onClick={handleTogglePassword}
                                        >
                                            {showPassword ? <Visibility/> : <VisibilityOff/>}
                                        </IconButton>
                                    </InputAdornment>
                                ),
                            }}
                        />
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            sx={{mt: 3, mb: 2}}
                        >
                            Зарегистрировать
                        </Button>
                    </Box>
                </Box>
                <Copyright sx={{mt: 8, mb: 4}}/>
            </Container>
        </>
    );
});

export default Registrations;
