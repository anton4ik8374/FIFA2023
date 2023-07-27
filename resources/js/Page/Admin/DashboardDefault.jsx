import * as React from 'react';
import {Box, Checkbox, Button} from '@mui/material';
import Container from '@mui/material/Container';
import {observer} from "mobx-react";

import {useState, useEffect} from "react";
import {QrCode} from '@mui/icons-material';
import UserStore from "@/Stores/UserStore";
import Typography from "@mui/material/Typography";


const DashboardDefault = observer(() => {
    const [onResult, setOnResult] = useState({});
    const [onError, setOnError] = useState({});
    const [stop, setStop] = useState(true);
    const [isCredit, setIsCredit] = useState(false);

    useEffect(() => {
        if (onResult?.text) {
            setStop(true);
            Send();
        }
    }, [onResult, onError]);

    const toogleQR = () => {
        setStop(!stop);
        setOnResult({});
    };
    const Send = () => {
        UserStore.getCheck({qrraw: onResult?.text, is_credit: isCredit})
    }
    const handleIsCredit = () => {
        setIsCredit(!isCredit);
    }

    return (
        <>
            <Box>
                <Container maxWidth="sm">
                    <Typography>
                        <Checkbox
                            checked={isCredit}
                            onChange={handleIsCredit}
                            inputProps={{'aria-label': 'controlled'}}
                        />
                        Используется кредитный лимит
                    </Typography>
                    <Button
                        variant="contained"
                        color={stop ? 'success' : 'error'}
                        startIcon={<QrCode/>}
                        onClick={toogleQR}>
                        QR код
                    </Button>
                    {!stop && <BarcodeScanner onResult={setOnResult} onError={setOnError}/>}
                    <Box>

                    </Box>
                </Container>
            </Box>
        </>
    );
});
export default DashboardDefault;
