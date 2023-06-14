import React from 'react';
import {Box} from '@mui/material';
import User from "../Stores/UserStore";
import {observer} from "mobx-react";
import UserMenu from "@/Components/UserMenu";
import SingInOrRegistration from "@/Components/SingInOrRegistration";
import HeaderStyle from "@/Styles/HeaderStyle";

const UserInfo = observer(({linkLogout = false}) => {

    let {user} = User;

    let logout = (event) => {
        event.preventDefault();

        User.logout();
    }
    return (<>
        <Box sx={HeaderStyle.UserBox}>
            <Box sx={HeaderStyle.login}>
            {user?.id ?
                (<UserMenu/>)
                :
                (<SingInOrRegistration/>)
            }
            </Box>
        </Box>
    </>);

})

export default UserInfo;
