import { useEffect, useState } from 'react';
import { useLocation, Outlet } from 'react-router-dom';

// material-ui
import { useTheme } from '@mui/material/styles';
import { Box, Toolbar, useMediaQuery } from '@mui/material'

// project import
import HeaderUser from "./Header"
import FooterUser from "./Footer";
import StartStyle from "@/Styles/StartStyle";

import * as React from "react";
import {observer} from "mobx-react";

const AdminLayout = observer((props) => {

    const location = useLocation();
    return (
        <Box sx={{ display: 'flex', width: '100%' }}>
            <Header open={open} handleDrawerToggle={handleDrawerToggle} />
            <Drawer open={open} handleDrawerToggle={handleDrawerToggle} />
            <Box component="main" sx={{ width: '100%', flexGrow: 1, p: { xs: 2, sm: 3 } }}>
                <Toolbar />
                <Outlet />
            </Box>
        </Box>
    );
});

export default AdminLayout;
