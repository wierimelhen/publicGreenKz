import { Suspense } from 'react';
import Loader from '@/components/loader';

const Loadable = (Component) => (props) =>
	(
		<Suspense
			fallback={
				<Loader
					addSx={{
						mt: 5,
					}}
				/>
			}
		>
			<Component {...props} />
		</Suspense>
	);

export default Loadable;
