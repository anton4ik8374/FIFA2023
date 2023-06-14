import '@fontsource/roboto/300.css';
import '@fontsource/roboto/400.css';
import '@fontsource/roboto/500.css';
import '@fontsource/roboto/700.css';
import '@/../css/font-icons.css';

import theme from "./Themes/Blue"
import React from "react";
import * as ReactDOMClient from 'react-dom/client';
import {BrowserRouter} from 'react-router-dom';
import {ThemeProvider } from '@mui/material/styles';
import Start from './Start';
import User from "./Stores/UserStore";
import { SnackbarProvider } from 'notistack';

User.startSanctum();

const container = document.getElementById("app");
const root = ReactDOMClient.createRoot(container);

root.render(
    <BrowserRouter>
        <ThemeProvider theme={theme}>
            <SnackbarProvider maxSnack={10} anchorOrigin={{
                vertical: 'bottom',
                horizontal: 'right',
            }}>
                <Start/>
            </SnackbarProvider>
        </ThemeProvider>
    </BrowserRouter>
  );




