import * as React from 'react';
import {useState} from 'react';
import {IconButton, Menu, MenuItem,} from '@mui/material';
import User from "../Stores/UserStore";
import {observer} from "mobx-react";
import AccountCircle from '@mui/icons-material/AccountCircle';


const UserMenu = observer(({linkLogout = false}) => {


    const [anchorEl, setAnchorEl] = useState(null);

    let logout = (event) => {
        event.preventDefault();
        User.logout();
    }

    const handleMenu = (event) => {
        setAnchorEl(event.currentTarget);
    };
    const handleClose = () => {
        setAnchorEl(null);
    };

    return (<>
        <IconButton
            size="large"
            aria-label="account of current user"
            aria-controls="menu-appbar"
            aria-haspopup="true"
            onClick={handleMenu}
            color="info"
        >
            <AccountCircle />
        </IconButton>
        <Menu
            id="menu-appbar"
            anchorEl={anchorEl}
            anchorOrigin={{
                vertical: 'top',
                horizontal: 'right',
            }}
            keepMounted
            transformOrigin={{
                vertical: 'top',
                horizontal: 'right',
            }}
            open={Boolean(anchorEl)}
            onClose={handleClose}
        >
            <MenuItem onClick={() => alert("Раздел в разработке")}>Профиль</MenuItem>
            <MenuItem onClick={logout}>Выйти</MenuItem>
        </Menu>
    </>);

})

export default UserMenu;
