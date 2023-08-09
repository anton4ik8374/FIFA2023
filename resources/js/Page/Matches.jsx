import * as React from 'react';

import Box from '@mui/material/Box';
import StartStyle from "@/Styles/StartStyle";
import {CssBaseline} from "@mui/material";
import {useEffect} from "react";
import {observer} from "mobx-react";
import MatcheDetails from "@/Components/MatcheDetails";
import MatchesStore from "@/Stores/MatchesStore";
import { useParams } from "react-router-dom"

const Matches = () => {
    const { id } = useParams();
    useEffect(() => {
        MatchesStore.getMatch(id);
        return () => {
            MatchesStore.addMatch({});
        }
    }, [id]);


    return (
        <>
            <Box sx={StartStyle.container} maxWidth="xs">
                <CssBaseline/>
                <MatcheDetails/>
            </Box>
        </>
    );
};
export default observer(Matches);
