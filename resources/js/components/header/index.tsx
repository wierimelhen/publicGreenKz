import React from "react";
import header from '@/assets/header.png'

function Header() {


    return (
        <>

            <div style={{
                height: '10vh',
                backgroundImage: `url(${header})`,
                backgroundColor: "#183132",
                    backgroundSize: "100% 100%",
                    backgroundRepeat: "no-repeat",
                    backgroundPositionX: "center",
                    width: "100%",
                    boxShadow: '0px 5px 5px 2px rgba(0,0,0,0.76)',
                    display: "flex",
                    alignContent: "center",
                    justifyContent: "center",
                    alignItems: "center"
            }}>
                <div style={{
                    height: '80%',
                    width: '80%',
                    display: "flex",
                    alignContent: "center",
                    justifyContent: "space-between",
                    alignItems: "center"
                }}>
                <button style={{
                      boxShadow: "inset 0px 3px 3px -1px #23395e",
                      backgroundColor: "transparent",
                      borderRadius: "13px",
                      border: "1px solid #4a6794",
                      display: "inline-block",
                      cursor: "pointer",
                      color: "#ffffff",
                      fontFamily: "Arial",
                      fontSize: "18px",
                      padding: "8px 63px",
                      textDecoration: "none",
                      textShadow: "0px 0px 0px #263666"
                }}>
                    aasasdasd
                </button>
                </div>
            </div>
        </>
    );
}

export default Header;
