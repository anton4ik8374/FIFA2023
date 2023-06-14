import * as React from 'react';
import {Box} from '@mui/material';
import {Link} from 'react-router-dom';
import {observer} from "mobx-react";
import {routesMap} from '@/Common/Routers/MapRouter';
import HeaderStyle from "@/Styles/HeaderStyle";
import UseLink from "@/Components/UseLink";



const SingInOrRegistration = observer(({linkLogout = false}) => {

    return (<>
        <UseLink to={routesMap.signIn} name={'Войти в IT'}/>
        {<UseLink to={routesMap.registrations} name={'Регистрация'}/>}</>);

})

export default SingInOrRegistration;
