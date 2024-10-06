import React, { lazy } from "react";
import { Route, Routes } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import withLazyLoadably from "@hocs/withLazyLoadably";
import MainLayout from "@/components/layouts/mainLayout";
import WithScrollTopOnRouteChange from "@hocs/withScrollTopOnRouteChange";

const Page404 = withLazyLoadably(lazy(() => import("@/pages/errorPages/404")));
const ParkInfoPage = withLazyLoadably(lazy(() => import("@/pages/dashboardsPages/parkInfoPage")));
const Scene = withLazyLoadably(lazy(() => import("@/pages/scenes/park")));
const Dashboard1Page = withLazyLoadably(
    lazy(() => import("@/pages/dashboardsPages/dashboard1")),
);

function Router() {
    const navigate = useNavigate();

    return (
        <WithScrollTopOnRouteChange>
            <Routes>
                <Route path="/" element={<MainLayout />}>
                    <Route index element={<Dashboard1Page />} />
                    <Route path="/info/*" element={<ParkInfoPage />} />

                    <Route path="/scene/*" element={<Scene />} />

                    <Route path="*" element={<Page404 />} />
                    <Route path="404/qr-code" element={<Page404 />} />
                </Route>
                 
                
            </Routes>
        </WithScrollTopOnRouteChange>
    );
}

export default Router;
