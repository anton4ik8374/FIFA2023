import * as React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@mui/material/CircularProgress';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import {observer} from "mobx-react";


const CircularWithValueLabel = observer(({all, win}) =>  {

    const getPercent = (all, win) => {
        if(all && win) {
            return 100 / (all / win)
        }
        return 0;
    }
    return (
        <Box sx={{ position: 'relative', display: 'inline-flex' }}>
            <CircularProgress color="success" variant="determinate" value={getPercent(all, win)} />
            <Box
                sx={{
                    top: 0,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    position: 'absolute',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                }}
            >
                <Typography variant="caption" component="div" color="text.secondary">
                    {`${Math.round(getPercent(all, win))}%`}
                </Typography>
            </Box>
        </Box>
    );
});

export default CircularWithValueLabel;
