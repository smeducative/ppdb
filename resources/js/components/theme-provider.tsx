import { ThemeProvider as NextThemesProvider } from "next-themes";

/**
 * Provider untuk mengelola tema light/dark/system
 * Membungkus aplikasi dengan context tema
 */
export function ThemeProvider({
	children,
	...props
}: React.ComponentProps<typeof NextThemesProvider>) {
	return <NextThemesProvider {...props}>{children}</NextThemesProvider>;
}
