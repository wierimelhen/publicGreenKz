import React, { lazy } from "react";
import { Route, Routes } from "react-router-dom";
import { useNavigate } from "react-router-dom";

import ScrollToTopOnRouteChange from "@hocs/withScrollTopOnRouteChange";
import withLazyLoadably from "@hocs/withLazyLoadably";

import MainLayout from "@/components/layouts/mainLayout";

const Page404 = withLazyLoadably(lazy(() => import("@/pages/errorPages/404")));

const Dashboard1Page = withLazyLoadably(
    lazy(() => import("@/pages/dashboardsPages/dashboard1")),
);

function Router() {
    const navigate = useNavigate();

    return (
        <ScrollToTopOnRouteChange>
            <Routes>
                <Route path="/" element={<MainLayout />}>
                    <Route index element={<Dashboard1Page />} />
                </Route>
                <Route path="*" element={<Page404 />} />
            </Routes>
        </ScrollToTopOnRouteChange>
    );
}

export default Router;
