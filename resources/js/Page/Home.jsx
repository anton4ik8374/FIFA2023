import * as React from 'react';
import Button from '@mui/material/Button';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import StartStyle from "@/Styles/StartStyle";
import UserStore from "@/Stores/UserStore";


export default function Home() {

    const heandlearA = () => {
        console.log(12);
        UserStore.testA();
    };
    return (
        <>
            <Box sx={StartStyle.paralax}>
                <Container sx={StartStyle.clearfix}>
                    <Box sx={StartStyle.paralaxText}>
                        <Typography variant="h2" sx={StartStyle.paralaxTextH2}>Personal website</Typography>
                    </Box>
                </Container>
            </Box>
            <Box sx={{...StartStyle.container, ...StartStyle.shadows}}>
                <Container sx={{ py: 8}} maxWidth="lg">
                    {/* End hero unit */}
                    <Typography variant="h2" sx={StartStyle.head}>
                        Стек
                    </Typography>
                    <Grid container spacing={6}>
                        <Button
                            variant="contained"
                            onClick={heandlearA}>
                            A-parser
                        </Button>
                    </Grid>
                </Container>
            </Box>
        </>
    );
}
