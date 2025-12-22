import type { PageProps as InertiaPageProps } from "@inertiajs/core";
import type { AxiosInstance } from "axios";

declare global {
	interface Window {
		axios: AxiosInstance;
	}

	/* eslint-disable no-var */
	var route: (
		name?: string,
		params?: any,
		absolute?: boolean,
		config?: any,
	) => string;

	interface AppPageProps {
		auth: {
			user: {
				id: number;
				name: string;
				email: string;
				email_verified_at: string;
			};
		};
		flash: {
			success: string | null;
			error: string | null;
		};
		csrf_token?: string;
		[key: string]: any;
	}
}

declare module "@inertiajs/core" {
	interface PageProps extends InertiaPageProps, AppPageProps {}
}
