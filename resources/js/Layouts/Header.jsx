import React from 'react';
import {AppBar, Container, Toolbar, Box,} from '@mui/material';
import {} from "@emotion/styled";
import {observer} from "mobx-react";
import MenuItem from "@/Components/MenuItems"
import Menus from "@/Stores/MenuStore";
import HeaderStyle from "@/Styles/HeaderStyle";
import Typography from "@mui/material/Typography";
import OutlinedButtons from "@/Components/OutlinedButtons";

const HeaderUser = observer(() => {

    let elementMenus = [];

    if (!!Menus.freeMenu.loaded) {
        elementMenus = Menus.freeMenu.menu.map((item, index) => {
            return (
                <MenuItem key={item.id} url={item.url} ind={index}>
                    {item.name}
                </MenuItem>
            );
        });
    }
    return (<>
                <AppBar sx={HeaderStyle.appBar}>
                    <Box sx={HeaderStyle.logoBox}>
                        <Typography variant="h3" component="h2" sx={HeaderStyle.betberto}>betberto</Typography>
                    </Box>
                    <Toolbar>
                        <Container>
                            <Box>
                                <OutlinedButtons/>
                            </Box>
                        </Container>
                    </Toolbar>
                </AppBar>

    </>);
})

export default HeaderUser;
