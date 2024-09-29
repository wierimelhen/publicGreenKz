import {
	users,
	persons_row,
	case_general,
	FieldsType,
	AccountProps,
	GalleryProps,
    users_general,
} from "@/utils/types/types";

export type CIW = users | persons_row | case_general | users_general;

export interface AGP {
	account: AccountProps;
	gallery: GalleryProps;
}
