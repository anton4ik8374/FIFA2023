import React from 'react';
import {Box, Typography, Container, Link} from "@mui/material";
import FooterStyle from "@/Styles/FooterStyle";
import {observer} from "mobx-react";
import Image from 'mui-image'

const FooterUser = observer(() => {

    return (
        <Box sx={FooterStyle.footer} component="footer">
            <Container maxWidth="mb" sx={FooterStyle.footerContainerTop}>
                <Box sx={FooterStyle.container}>
                    <Box sx={{...FooterStyle.containerColl, mr: 20}}>
                        <Box sx={FooterStyle.containerColl}>
                            <Typography variant="span" sx={FooterStyle.wdText}>
                                Web_door
                            </Typography>
                        </Box>
                        <Box sx={FooterStyle.container}>

                        </Box>
                    </Box>
                    <Box sx={FooterStyle.container}>
                        <Box sx={{...FooterStyle.containerColl, mr: 5}}>

                        </Box>
                        <Box sx={{...FooterStyle.containerColl, mr: 5}}>
                            <Box>
                                <Typography variant="h4" sx={FooterStyle.textHeader}>Адрес</Typography>
                                <Box sx={FooterStyle.containerColl}>
                                    <Typography component="address" sx={{color: '#FFF'}}>

                                    </Typography>
                                </Box>
                            </Box>
                        </Box>
                        <Box sx={FooterStyle.containerColl}>
                            <Box sx={FooterStyle.containerColl}>
                                <Typography variant="h4" sx={FooterStyle.textHeader}>Соц.Сети</Typography>
                                <Box sx={FooterStyle.containerSocial}>

                                </Box>
                            </Box>
                        </Box>
                    </Box>
                </Box>
            </Container>
            <Box sx={FooterStyle.footerContainerBotton}>
                <Box sx={FooterStyle.containerColl}>
                    <Typography variant="small" sx={FooterStyle.wdTextSub}>
                        2019 - {(new Date).getFullYear()} Все права не защищены
                    </Typography>
                </Box>
            </Box>
        </Box>);
});

export default FooterUser;
