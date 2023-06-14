import * as React from 'react';
import {Grid, Box} from '@mui/material';
import {Link, useNavigate} from 'react-router-dom';
import LockOutlinedIcon from '@mui/icons-material/LockOutlined';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import {observer} from "mobx-react";
import {Copyright} from "@/Helpers/Helpers";
import {useFormik} from "formik";
import {getLoginSchema} from "@/Validations/LoginScheme";
import UserStore from "@/Stores/UserStore";
import {CssBaseline, TextField, IconButton, InputAdornment, Avatar, Button} from "@mui/material";
import {Visibility, VisibilityOff} from "@mui/icons-material";
import {useState, useEffect} from "react";
import {routesMap} from '@/Common/Routers/MapRouter';
import {enqueueSnackbar } from 'notistack';

const SignIn = observer(() => {

    let {user, errors} = UserStore;
    const formik = useFormik({
        initialValues: {
            email: '',
            password: ''
        },
        validationSchema: getLoginSchema(),
        onSubmit: async (values) => {
            UserStore.Auth(values);
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




    const [showPassword, setShowPassword] = useState(false);

    const handleTogglePassword = () => setShowPassword(!showPassword);

    return (

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
                <Avatar sx={{m: 1, bgcolor: 'secondary.main'}}>
                    <LockOutlinedIcon/>
                </Avatar>
                <Typography component="h1" variant="h5">
                    Авторизация
                </Typography>
                <Box component="form" onSubmit={formik.handleSubmit} noValidate sx={{mt: 1}}>
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
                    <Button
                        type="submit"
                        fullWidth
                        variant="contained"
                        sx={{mt: 3, mb: 2}}
                    >
                        Войти
                    </Button>
                    {/*<Grid container>
                        <Grid item xs>
                            <Link to={routesMap.registrations} variant="body2">
                                Забыли пароль?
                            </Link>
                        </Grid>
                        <Grid item>
                            <Link to={routesMap.registrations} variant="body2">
                                Регистрация
                            </Link>
                        </Grid>
                    </Grid>*/}
                </Box>
            </Box>
        </Container>
    );
});

export default SignIn;
