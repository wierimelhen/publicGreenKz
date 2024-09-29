import { useLocation, Link } from 'react-router-dom';
// MUI
import Typography from '@mui/material/Typography';
import Stack from '@mui/material/Stack';
import Button from '@mui/material/Button';

// Icons

function PageAccess() {
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
				fontSize={70}
				borderBottom={1}
				sx={{
					textDecoration: 'dotted underline',
				}}
			>
				Ошибка доступа
			</Typography>
			<Button variant="outlined" size="small" component={Link} to="/">
				НА ГЛАВНУЮ
			</Button>
			 <Typography variant="caption">Обратитесь к администратору</Typography>
		</Stack>
	);
}

export default PageAccess;
