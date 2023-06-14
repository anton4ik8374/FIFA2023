import React from "react";
import {Navigate, Outlet} from "react-router-dom";
import {observer} from "mobx-react";

const ProtectedRoute = ({
                            isAllowed,
                            redirectPath = '/',
                            children,
                        }) => {
    if (!isAllowed) {
        return <Navigate to={redirectPath} replace />;
    }

    return  (children ? children : <Outlet />);
};

export default observer(ProtectedRoute);
