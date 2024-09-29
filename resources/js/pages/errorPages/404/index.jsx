import { useLocation, Link } from 'react-router-dom';
// MUI
import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';
import Button from '@mui/material/Button';


function PageNotFound() {
	return (
		<Stack
			px={5}
			direction="column"
			spacing={2}
			justifyContent="center"
			alignItems="center"
			minHeight="100vh"
			color="text.tertiary"
            sx={{

                background: "#151515f7",
                zIndex: "1",

            }}
		>
			<Typography
				variant="h1"
				fontSize={150}
				borderBottom={1}
				sx={{
					textDecoration: 'dotted underline',
				}}
			>
				Ошибка
			</Typography>
			<Button variant="outlined" size="small" component={Link} to="/">
				НА ГЛАВНУЮ
			</Button>
		</Stack>
	);
}

export default PageNotFound;
