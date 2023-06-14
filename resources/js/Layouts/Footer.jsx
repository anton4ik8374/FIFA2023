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
                            <Box sx={{...FooterStyle.containerCollCentr, ...FooterStyle.marginRight}}>
                                <Link href="https://github.com/anton4ik8374?tab=repositories" target="_blank">
                                    <Box component="i" sx={{color: '#FFFFFF', fontSize: 30}}
                                         className={'icon-github2'}/>
                                </Link>
                            </Box>
                            <Box sx={FooterStyle.containerCollCentr}>
                                <Link href="https://webmaster.yandex.ru/sqi?host=web-door.net">
                                    <Image width="88" height="45" sx={FooterStyle.containerCollCentr}
                                         alt="" border="0"
                                         src="https://yandex.ru/cycounter?web-door.net&theme=light&lang=ru"/>
                                </Link>
                            </Box>
                        </Box>
                    </Box>
                    <Box sx={FooterStyle.container}>
                        <Box sx={{...FooterStyle.containerColl, mr: 5}}>
                            <Box>
                                <Typography variant="h4" sx={FooterStyle.textHeader}>Контакты</Typography>
                                <Box sx={FooterStyle.containerColl}>
                                    <Link
                                        href="tel:+79650347115">
                                        +7(965)034-71-15
                                    </Link>
                                    <Link
                                        href="mailto:anton4ik2251@yandex.ru">
                                        anton4ik2251@yandex.ru
                                    </Link>
                                </Box>
                            </Box>
                        </Box>
                        <Box sx={{...FooterStyle.containerColl, mr: 5}}>
                            <Box>
                                <Typography variant="h4" sx={FooterStyle.textHeader}>Адрес</Typography>
                                <Box sx={FooterStyle.containerColl}>
                                    <Typography component="address" sx={{color: '#FFF'}}>
                                        Санкт-Петербугр
                                    </Typography>
                                </Box>
                            </Box>
                        </Box>
                        <Box sx={FooterStyle.containerColl}>
                            <Box sx={FooterStyle.containerColl}>
                                <Typography variant="h4" sx={FooterStyle.textHeader}>Соц.Сети</Typography>
                                <Box sx={FooterStyle.containerSocial}>
                                    <Link href="https://www.facebook.com/webdo0r" target="_blank">
                                        <Box component="i" sx={{color: '#0165E1', fontSize: 25, mr: 1}}
                                             className={'icon-facebook'}/>
                                    </Link>
                                    <Link href="https://twitter.com/web_do0r" target="_blank">
                                        <Box component="i" sx={{color: '#1D9BF0', fontSize: 25, mr: 1}}
                                             className={'icon-twitter'}/>
                                    </Link>
                                    <Link href="https://www.instagram.com/web_door/" target="_blank">
                                        <Box component="i" sx={{color: '#F56040', fontSize: 25, mr: 1}}
                                             className={'icon-instagram'}/>
                                    </Link>
                                    <Link href="https://vk.com/web_door" target="_blank">
                                        <Box component="i" sx={{color: '#0077ff', fontSize: 25}}
                                             className={'icon-vk2'}/>
                                    </Link>
                                </Box>
                            </Box>
                        </Box>
                    </Box>
                </Box>
            </Container>
            <Box sx={FooterStyle.footerContainerBotton}>
                <Box sx={FooterStyle.containerColl}>
                    <Typography variant="small" sx={FooterStyle.wdTextSub}>
                        2019 - {(new Date).getFullYear()} Все права не защищены <Link target="_blank"
                                                                                      href="https://vk.com/@anton4ik08-partizanskii-manifest-ob-otkrytoi-informacii">манифест
                        об открытой информации</Link>
                    </Typography>
                </Box>
            </Box>
        </Box>);
});

export default FooterUser;
