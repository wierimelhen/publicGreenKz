export interface users {
	id: number;
	fio: string;
	img: string;
	email: string;
}

export interface case_field {
	field: string;
	data: string;
}

export interface case_general {
	id: number;
	case_token: string;
	user_add: string;
	date_create: string;
	date_modified: string;
	fields: case_field[];
}

export interface rights {
	right: string;
	group: string;
}

export interface users_general {
	id: number;
	name: string;
    surname: string;
	phone: string;
	post: string;
    rank: string;
	second_name: string;
	subdivision: string;
	created_dt: string;
    updated_dt: string;
	pass_data: string;
	rights: rights[];
}

export interface persons_row {
	id: number;
	person_name: string;
	main_photo: string;
	date_of_death: string;
	date_of_birth: string;
	hash: string;
}

export interface FieldsType {
	name: string;
	label: string;
	type:
		| "button"
		| "checkbox"
		| "color"
		| "date"
		| "datetime-local"
		| "email"
		| "file"
		| "hidden"
		| "image"
		| "month"
		| "number"
		| "password"
		| "radio"
		| "range"
		| "reset"
		| "search"
		| "tel"
		| "text"
		| "time"
		| "url"
		| "week"
		| "submit";
}

export interface AccountProps {
	account: {
		main: {
			accept: boolean;
			fields: FieldsType[];
		};
		public: {
			accept: boolean;
			fields: FieldsType[];
		};
		advanced: {
			accept: boolean;
			fields: FieldsType[];
		};
		delete: {
			accept: boolean;
			fields: FieldsType[];
		};
	};
}

export interface GalleryProps {
	gallery: {
		main: {
			accept: boolean;
			fields: FieldsType[];
		};
	};
}
