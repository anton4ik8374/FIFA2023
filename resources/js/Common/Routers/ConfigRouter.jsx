import React from "react";
import {useRoutes} from "react-router-dom";
import {routes, adminRoutes, authRoutes} from "./MapRouter";
import {observer} from "mobx-react";
import ProtectedRoute from "./ProtectedRoute"
import User from "@/Stores/UserStore";

const ConfigRoute = observer(() => {
    //https://www.robinwieruch.de/react-router-private-routes/ - приватный роутинг

    const constructorRouters = (data) => {
        return data.children.map((route) => {
            if(route.admin){
                return {...route, element: <ProtectedRoute isAllowed={User.checkAdmin()}>{route.element}</ProtectedRoute>};
            }else if(route.auth){
                return {...route, element: <ProtectedRoute isAllowed={User.user.id}>{route.element}</ProtectedRoute>};
            }else{
                return route;
            }
        });
    }

    let userRoute = {...routes, children: constructorRouters(routes)};
    let authRouteUse = {...authRoutes, children: constructorRouters(authRoutes)};
    let adminRouteUse = {...adminRoutes, children: constructorRouters(adminRoutes)};


    return useRoutes([userRoute, authRouteUse, adminRouteUse]);

});

export default ConfigRoute;
