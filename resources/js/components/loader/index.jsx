import Stack from '@mui/material/Stack';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import LinearProgress from '@mui/material/LinearProgress';

export function LogoLoader({ addSx, ...rest }) {
	return (
		<Card
			sx={{
				mx: {
					xs: 1,
					sm: 'auto',
				},
				my: 'auto',
				width: {
					xs: '100%',
					sm: 'fit-content',
				},
				...addSx,
			}}
			{...rest}
		>
			<Stack direction="column" spacing={1}>
				<Box
					// component="img"
					// src={logo}
					// alt="Slim Logo"
					width={{
						xs: '30vw',
						md: '15vw',
					}}
				/>
				<LinearProgress />
				<Typography my={1} textAlign="center" variant="caption">
					Загрузка
				</Typography>
			</Stack>
		</Card>
	);
}


export default LogoLoader;
