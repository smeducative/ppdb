import "../css/app.css";
import "./bootstrap";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { createInertiaApp } from "@inertiajs/react";
import type { ReactNode } from "react";
import { createRoot } from "react-dom/client";

const appName =
	window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

type PageModule = {
	default: React.ComponentType & {
		layout?: (page: ReactNode) => ReactNode;
	};
};

createInertiaApp({
	title: (title) => `${title} - ${appName}`,
	resolve: async (name) => {
		const pages = import.meta.glob<PageModule>("./Pages/**/*.tsx");
		const page = await pages[`./Pages/${name}.tsx`]();

		// Set default layout for Admin pages
		if (name.startsWith("Admin/") && !page.default.layout) {
			page.default.layout = (page: ReactNode) => (
				<AuthenticatedLayout>{page}</AuthenticatedLayout>
			);
		}

		return page;
	},
	setup({ el, App, props }) {
		const root = createRoot(el);

		root.render(<App {...props} />);
	},
	progress: {
		color: "#4B5563",
	},
});
