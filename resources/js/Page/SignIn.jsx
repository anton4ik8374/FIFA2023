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

    const heandlearA = () => {
        UserStore.testA();
    };




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
    );
});

export default SignIn;
