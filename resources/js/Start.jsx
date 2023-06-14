import * as React from 'react';
import ProjectSkeleton from "./Skeletons/ProjectSkeleton";
import ConfigRouter from "./Common/Routers/ConfigRouter";
import User from "./Stores/UserStore";
import RoutersApi from "@/Stores/RoutersStore";
import {observer} from "mobx-react";


const Start = observer(() => {

    return (
        <>
            {!(User.startLoad && RoutersApi.loaded) ? (<ProjectSkeleton/>) : (<ConfigRouter/>)}
        </>
    );
});

export default Start;
