import { forwardRef } from 'react';
import { SnackbarProvider, enqueueSnackbar } from 'notistack';

function Snackbar(props) {
    const { message, severity, title, style, ...alertProps } = props;

    const severityStyles = {
        success: { backgroundColor: '#4caf50', color: '#fff' },
        error: { backgroundColor: '#f44336', color: '#fff' },
        warning: { backgroundColor: '#ff9800', color: '#fff' },
        info: { backgroundColor: '#2196f3', color: '#fff' },
    };

    return (
        <div
            style={{
                ...severityStyles[severity],
                padding: '16px',
                borderRadius: '4px',
                boxShadow: '0 2px 10px rgba(0, 0, 0, 0.2)',
                marginBottom: '16px',
                ...style,
            }}
            {...alertProps}
        >
            {title && <strong>{title}</strong>}
            <div>{message}</div>
        </div>
    );
}

const SnackbarVariant = forwardRef((props, ref) => (
    <div ref={ref}>
        <Snackbar {...props} />
    </div>
));

export function Provider({ children }) {
    return (
        <SnackbarProvider
            maxSnack={3}
            anchorOrigin={{ horizontal: 'right', vertical: 'top' }}
            Components={{
                muiSnackbar: SnackbarVariant,
            }}
        >
            {children}
        </SnackbarProvider>
    );
}

export default enqueueSnackbar;
