import { route as ziggyRoute } from "ziggy-js";

/**
 * Ziggy routing helper.
 * This replaces the previous custom manual routing implementation.
 */
export function route(
	name?: any,
	params?: any,
	absolute?: boolean,
	config?: any,
): any {
	return ziggyRoute(name, params, absolute, config);
}

if (typeof window !== "undefined") {
	// @ts-expect-error: assigning to global for backward compatibility
	window.route = route;
}

export default route;
