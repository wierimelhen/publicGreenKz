import { Outlet, useLocation } from "react-router-dom";
import Header from "@/components/header";

function MainLayout({ container = "lg", pb = true }) {
    const location = useLocation();
    return (
        <>
            <div style={{ display: 'flex', minHeight: '100vh', flexDirection: 'column', alignItems: 'center', height: '100%' }}>
                <Header />
                <main
                    style={{
                        maxWidth: container,
                        flex: '1 0 auto',
                        paddingBottom: pb ? '20%' : '0',
                        marginTop: '25px',
                        paddingLeft: '10%',
                        paddingRight: '10%',
                        maxHeight: '80%',
                        overflow: 'auto'
                    }}
                >
                   <Outlet />
                </main>
            </div>
        </>
    );
}

export default MainLayout;
