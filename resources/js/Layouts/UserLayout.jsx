import { useEffect, useState } from 'react';
import { useLocation, Outlet } from 'react-router-dom';

// material-ui
import {Box, CssBaseline} from '@mui/material';

// project import
import HeaderUser from "./Header"
import FooterUser from "./Footer";
import StartStyle from "@/Styles/StartStyle";

import * as React from "react";
import {observer} from "mobx-react";

const UserLayout = observer((props) => {

    const location = useLocation();

    return (
        <Box sx={StartStyle.start}>
            <CssBaseline/>
            <HeaderUser/>
            <Box component="main" sx={StartStyle.main}>
                <Outlet />
            </Box>
            <FooterUser/>
        </Box>
    );
});

export default UserLayout;
