import * as React from 'react';
import Button from '@mui/material/Button';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import CardMedia from '@mui/material/CardMedia';
import Grid from '@mui/material/Grid';
import Stack from '@mui/material/Stack';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import Link from '@mui/material/Link';
import StartStyle from "@/Styles/StartStyle";
import SkilsStore from "@/Stores/SkilsStore";


export default function Home() {
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
                        {SkilsStore.skils.map((card) => (
                            <Grid item key={card.id} xs={12} sm={6} md={4}>
                                <Card sx={StartStyle.card}>
                                    <CardMedia
                                        component="i"
                                        sx={{color: card.color, fontSize: 48}}
                                        className={card.className}
                                    />
                                    <CardContent sx={{ flexGrow: 1 }}>
                                        <Typography gutterBottom variant="h5" component="h2"  sx={{color: "#FFFFFF"}}>
                                            {card.name}
                                        </Typography>
                                        <Typography sx={{color: "#FFFFFF",lineHeight: 1.8, boxSizing: 'border-box',fontWeight: 100, fontSize: '.8rem'}}>
                                            {card.content}
                                        </Typography>
                                    </CardContent>
                                </Card>
                            </Grid>
                        ))}
                    </Grid>
                </Container>
            </Box>
        </>
    );
}
