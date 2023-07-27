import Home from "@/Page/Home";
import Matches from "@/Page/Matches";
import React from "react";

import SignIn from "@/Page/SignIn";
import Registrations from "@/Page/Registrations";
import DashboardDefault from "@/Page/Admin/DashboardDefault";
import UserLayout from "@/Layouts/UserLayout";
import AdminLayout from "@/Layouts/AdminLayout";

const routes =
    {
        path: '/',
        element: <UserLayout/>,
        children: [
            {
                name: 'home',
                path: '/',
                element: <Home/>
            },
            {
                name: 'matches',
                path: '/matches/:matches',
                element: <Matches/>
            },
            {
                name: 'signIn',
                path: '/sign-in',
                element: <SignIn/>
            },
            {
                name: 'registrations',
                path: '/registrations',
                element: <Registrations/>
            }
        ]
    };
const adminRoutes =
    {
        path: '/',
        //element: <AdminLayout/>,
        element: <UserLayout/>,
        children: [
            {
                name: 'admin',
                path: 'admin',
                admin: true,
                auth: true,
                element: <DashboardDefault/>
            }
        ]
    };

const authRoutes =
    {
        path: '/',
        element: <UserLayout/>,
        children: [

        ]
    };

let routesMap = {};
routes.children.forEach((route) => {
    routesMap[route.name] = route.path
});
adminRoutes.children.forEach((route) => {
    routesMap[route.name] = route.path
});
authRoutes.children.forEach((route) => {
    routesMap[route.name] = route.path
});

export {routes, routesMap, adminRoutes, authRoutes}



