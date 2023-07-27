import * as React from 'react';

import Box from '@mui/material/Box';
import StartStyle from "@/Styles/StartStyle";
import UserStore from "@/Stores/UserStore";
import {CssBaseline, TextField} from "@mui/material";
import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";
import leaguesStore from "@/Stores/LeaguesStore";
import CardItem from "@/Components/CardItem";
import {observer} from "mobx-react";

const Matches = observer(() => {

    let navigate = useNavigate();

    const {leagues} = leaguesStore;

    useEffect(() => {

    }, []);


    return (
        <>
            <Box sx={StartStyle.container} maxWidth="xs">
               привет
            </Box>
        </>
    );
});
export default Matches;
