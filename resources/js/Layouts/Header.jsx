import React from 'react';
import {AppBar, Container, Toolbar, Box,} from '@mui/material';
import {} from "@emotion/styled";
import {observer} from "mobx-react";
import {Link} from "react-router-dom";
import {routes, routesMap} from "@/Common/Routers/MapRouter";
import MenuSkeleton from "@/Skeletons/MenuSkeleton";
import MenuItem from "@/Components/MenuItems"
import UserInfo from "@/Components/UserInfo";
import Menus from "@/Stores/MenuStore";
import HeaderStyle from "@/Styles/HeaderStyle";

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
        {elementMenus ?
            (<>
                <AppBar sx={HeaderStyle.header}>

                    <Toolbar>
                        <Box sx={HeaderStyle.logoBox}>
                            <Link to={routesMap.home}>
                                <img style={HeaderStyle.logo} src={`/images/logo/new.jpg`} alt={"Web-door"}/>
                            </Link>
                        </Box>


                        <Container>
                            <Box sx={{ display: { xs: 'none', sm: 'block' } }}>
                                {elementMenus}
                            </Box>
                        </Container>
                        <Box sx={HeaderStyle.UserBox}>
                            <UserInfo/>
                        </Box>
                    </Toolbar>
                </AppBar>
                </>
            ) : (<MenuSkeleton/>)
        }
    </>);
})

export default HeaderUser;
