import React from 'react';

export function LogoLoader({ addSx, ...rest }) {
    const containerStyle = {
        margin: 'auto',
        maxWidth: 'fit-content',
        width: '100%',
        ...addSx,
    };

    const imageStyle = {
        width: '30vw',
        maxWidth: '100%',
    };

    const progressStyle = {
        height: '4px',
        backgroundColor: '#e0e0e0',
        borderRadius: '4px',
        overflow: 'hidden',
        margin: '8px 0',
    };

    const progressBarStyle = {
        height: '100%',
        width: '100%', // You can control the loading progress here
        backgroundColor: '#3f51b5', // Change the color as needed
        transition: 'width 0.5s ease-in-out', // Add a smooth transition
    };

    return (
        <div style={containerStyle} {...rest}>
            <div style={imageStyle}>
                {/* Uncomment and replace 'logo' with your logo source */}
                {/* <img src={logo} alt="Slim Logo" style={imageStyle} /> */}
            </div>
            <div style={progressStyle}>
                <div style={progressBarStyle} />
            </div>
            <div style={{ textAlign: 'center', marginTop: '8px' }}>
                <span style={{ fontSize: '12px', color: '#757575' }}>
                    Загрузка
                </span>
            </div>
        </div>
    );
}

export default LogoLoader;
