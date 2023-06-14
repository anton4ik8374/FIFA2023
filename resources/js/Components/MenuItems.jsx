import React from 'react';
import UseLink from '@/Components/UseLink';
import {observer} from "mobx-react";
import {grey} from "@mui/material/colors";

const MenuItems =  observer(({url, children, ind}) => {
    return (<UseLink to={url} name={children} color={grey}/>);
});

export default MenuItems;
